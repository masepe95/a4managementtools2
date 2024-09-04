<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class AdminPersonalGroupsController extends Controller
{
    private static function getCurrentContents($usr, $selGroup): JsonResponse
    {
        // Ritorna i nomi dei gruppi personali di impiegati (ritorna un array vuoto se nessun
        // gruppo è stato trovato).
        $groups = DB::select('SELECT `id`, `group_name` FROM `personal_group`' .
                              ' WHERE `employee_id` = :id ORDER BY `group_name`', ['id' => $usr->id]);

        $grpId = $groups[0]->id ?? 0;  // Id del primo gruppo nell'array $groups.

        // Converti in html-entities gli eventuali caratteri speciali del campo `group_name`.
        foreach ($groups as $grp) {
            $grp->group_name = htmlentities($grp->group_name, ENT_QUOTES, 'UTF-8');

            // Controlla se l'id del gruppo selezionato è contenuto nell'array $groups.
            // Se non viene trovato, allora è appena stato cambiato l'impiegato impersonato,
            // in tal caso, assumi l'id del primo gruppo dell'array $groups.
            if ($grp->id == $selGroup) $grpId = $selGroup;
        }

        // Ritorna gli impiegati attivi (employee_status = 'enabled') dello stesso customer a cui
        // appartiene $usr->id.
        // Nota: la lista di impiegati ritornata non conterrà l'impiegato $usr->id (l'impiegato loggato
        //       o impersonato che sta impostando i propri gruppi personali di impiegati).
        // Nota: l'id $grpId è il primo dell'array $groups oppure è un id incluso nell'array stesso.
        //       L'id non può quindi essere iniettato tramite il valore di $selGroup (proveniente dal form).
        $users = DB::select("SELECT em.`id`, CONCAT(em.`firstname`, ' ', em.`lastname`) AS `fullname`, em.`photo_file`," .
                                  " IF(peg.`group_employee_id` IS NULL, 'off', 'on') AS `linked`" .
                             ' FROM `employee` em JOIN `personal_group` pg ON pg.`id` = :grp AND pg.`employee_id` = :id' .
                             ' LEFT JOIN `personal_employee_group` peg ON peg.`group_employee_id` = em.`id` AND' .
                                        ' peg.`group_id` = pg.`id` AND peg.`employee_owner_id` = pg.`employee_id`' .
                             " WHERE em.`customer_id` = :cust AND em.`employee_status` = 'enabled' AND em.`id` != pg.`employee_id`" .
                             ' ORDER BY `fullname`',
                             ['grp' => $grpId, 'cust' => $usr->customer_id, 'id' => $usr->id]);

        // Converti in html-entities gli eventuali caratteri speciali del campo `fullname`.
        // Trasforma il contenuto del campo `photo_file` da null o binary-image
        // in un'immagine inline in base64.
        foreach ($users as $user) {
            $user->fullname = htmlentities($user->fullname, ENT_QUOTES, 'UTF-8');
            $user->photo_file = GetImage::getImageInfo($user->photo_file);
        }

        return response()->json([ 'groups' => $groups, 'grpSel' => $grpId, 'users' => $users ]);
    }

    public function index(Request $request): JsonResponse
    {
        $usr = AdminController::getRealUser($request);

        $selGroup = (int) $request['user-group-names'] ?? 0;

        return AdminPersonalGroupsController::getCurrentContents($usr, $selGroup);
    }

    public function edit(Request $request): JsonResponse
    {
        $usr = AdminController::getRealUser($request);
        $selGroup = (int) $request['user-group-names'] ?? 0;

        // Esegui una transazione per modificare le tabelle `personal_group` e `personal_employee_group`.
        DB::transaction(function() use ($request, $usr, $selGroup) {
            $usrId = (int) $usr->id;
            $cust = (int) $usr->customer_id;

            // Se un nuovo nome del gruppo è stato specificato, modificalo.
            if (mb_strlen($request['user-new-grp-name']) > 0) {
                $validated = $request->validate([ 'user-new-grp-name' => 'required|max:255' ]);

                // Nota: l'utilizzo del campo `employee_id` nella clausola WHERE evita che si possa iniettare
                //       un `id` di un gruppo non appartenente all'utente stesso.
                DB::update('UPDATE `personal_group` SET `group_name` = :name WHERE `id` = :id AND `employee_id` = :empl',
                            [ 'id' => $selGroup, 'empl' => $usrId, 'name' => $validated['user-new-grp-name'] ]);
            }

            // L'array deve avere almeno un elemento (un impiegato associato al gruppo).
            $validated = $request->validate([ 'users-group-list' => 'array|min:1' ]);

            // Elimina gli impiegati associati al gruppo $selGroup, in seguito, imposta le nuove associazioni.
            // Nota: l'utilizzo del campo `employee_id` nella clausola WHERE evita che si possa iniettare
            //       un `id` di un gruppo non appartenente all'utente stesso.
            DB::delete('DELETE FROM `personal_employee_group` WHERE `group_id` = :id AND `employee_owner_id` = :empl',
                       [ 'id' => $selGroup, 'empl' => $usrId ]);

            // Costruisci la lista degli id degli impiegati del gruppo.
            $cnt = count($validated['users-group-list']) - 1;

            $values = 'VALUES ';
            for ( $n = 0 ; $n <= $cnt ; $n++ ) {
                // Tutti i dati sono castati ad int (bigint su sistemi a 64bit) e quindi sicuri.
                $id = (int) $validated['users-group-list'][$n];
                $values .= "($selGroup, $usrId, $cust, $id)";  // Double-quote per espandere i valori delle variabili.
                if ($n < $cnt) $values .= ', ';
            }

            DB::insert('INSERT INTO `personal_employee_group` (`group_id`, `employee_owner_id`,' .
                                                             ' `customer_id`, `group_employee_id`)' .
                                                            " $values");
        });

        return AdminPersonalGroupsController::getCurrentContents($usr, $selGroup);
    }

    public function add(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'user-new-grp-name' => 'required|max:255',
            'users-group-list' => 'array|min:1',  // L'array deve avere almeno un elemento (un impiegato associato al gruppo).
        ]);

        $usr = AdminController::getRealUser($request);
        $newId = 0;

        // Esegui una transazione, se, durante l'esecuzione della closure, viene lanciata un'exception,
        // allora la transazione termina con un rollback automatico (l'exception viene ritornata al chiamante).
        // In caso contrario (closure executes successfully), la transazione esegue un commit automaticamente.
        // Una transaction tramite il metodo seguente permette di non dover gestire manualmente rollback e commit.
        DB::transaction(function() use ($usr, $validated, &$newId) {  // Passa la variabile $usr alla closure.
            $cust = (int) $usr->customer_id;
            $usrId = (int) $usr->id;

            DB::insert('INSERT INTO `personal_group` (`employee_id`, `customer_id`, `group_name`)' .
                        ' VALUES (:empl, :cust, :name)',
                        [ 'empl' => $usrId, 'cust' => $cust,
                          'name' => $validated['user-new-grp-name'] ]);

            // Ottiene l'id auto_increment appena inserito.
            $newId = (int) DB::getPdo()->lastInsertId();

            // Costruisci la lista degli id degli impiegati del gruppo.
            $cnt = count($validated['users-group-list']) - 1;

            $values = 'VALUES ';
            for ( $n = 0 ; $n <= $cnt ; $n++ ) {
                // Tutti i dati sono castati ad int (bigint su sistemi a 64bit) e quindi sicuri.
                $id = (int) $validated['users-group-list'][$n];
                $values .= "($newId, $usrId, $cust, $id)";  // Double-quote per espandere i valori delle variabili.
                if ($n < $cnt) $values .= ', ';
            }

            DB::insert('INSERT INTO `personal_employee_group` (`group_id`, `employee_owner_id`,' .
                                                             ' `customer_id`, `group_employee_id`)' .
                                                            " $values");
        });

        return AdminPersonalGroupsController::getCurrentContents($usr, $newId);
    }

    public function delete(Request $request): JsonResponse
    {
        $usr = AdminController::getRealUser($request);
        $selGroup = (int) $request['user-group-names'] ?? 0;

        // Nota: l'utilizzo del campo `employee_id` nella clausola WHERE evita che si possa
        //       iniettare un `id` di un gruppo non appartenente all'utente stesso.
        DB::delete('DELETE FROM `personal_group` WHERE `id` = :id AND `employee_id` = :empl',
                   [ 'id' => $selGroup, 'empl' => $usr->id ]);

        return AdminPersonalGroupsController::getCurrentContents($usr, $selGroup);
    }
}
