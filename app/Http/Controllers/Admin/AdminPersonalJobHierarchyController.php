<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AdminPersonalJobHierarchyController extends Controller
{
    private static function getCurrentContents($usr, $selHierarchy): JsonResponse
    {
        // Ritorna i nomi delle gerarchie personali per i job (ritorna un array vuoto se nessuna
        // gerarchia è stata trovata).
        $hierarchies = DB::select('SELECT `id`, `name` FROM `employee_hierarchy`' .
                                   ' WHERE `employee_id` = :id ORDER BY `name`', [ 'id' => $usr->id ]);

        $hierId = $hierarchies[0]->id ?? 0;  // Id della prima gerarchia nell'array $hierarchies.

        // Converti in html-entities gli eventuali caratteri speciali del campo `name`.
        foreach ($hierarchies as $hier) {
            $hier->name = htmlentities($hier->name, ENT_QUOTES, 'UTF-8');

            // Controlla se l'id della gerarchia selezionata è contenuto nell'array $hierarchies.
            // Se non viene trovato, allora è appena stato cambiato l'impiegato impersonato, in tal
            // caso, assumi l'id della prima gerarchia dell'array $hierarchies.
            if ($hier->id == $selHierarchy) $hierId = $selHierarchy;
        }

        // Ritorna i livelli di gerarchia con le relative label in tutte le lingue presenti per ogni singolo livello.
        // Nota: l'id $hierId è il primo dell'array $hierarchies oppure è un id presente nell'array stesso.
        //       L'id non può quindi essere iniettato tramite il valore di $selHierarchy (proveniente dal form).
        $levels = DB::select('SELECT eh.`level`, ehl.`lang_code`, ehl.`name` FROM `empl_hierarchy` eh' .
                              ' JOIN `empl_hierarchy_lang` ehl ON ehl.`employee_hierarchy_id` = eh.`employee_hierarchy_id` AND' .
                                                                ' ehl.`level` = eh.`level`' .
                              ' WHERE eh.`employee_hierarchy_id` = :id' .
                              ' ORDER BY eh.`level`', [ 'id' => $hierId ]);

        // Raggruppa i livelli e renumerali (nel caso ci siano dei gap nella sequenza dei livelli da 1 a 4).
        $lvl = -1;
        $levelList = [];

        foreach ($levels as $level) {
            if ($level->level != $lvl) {
                // Aggiungi un nuovo livello il cui primo elemento è un array associativo contenente
                // i campi `lang_code` e `name`.
                array_push($levelList, [ [ 'lang_code' => $level->lang_code, 'name' => $level->name ] ]);
                $lvl = $level->level;
            }
            else {
                // Aggiungi al livello corrente un nuovo array associativo contenente i campi `lang_code` e `name`.
                array_push($levelList[count($levelList) - 1], [ 'lang_code' => $level->lang_code, 'name' => $level->name ]);
            }
        }

        return response()->json([ 'hierarchies' => $hierarchies, 'hierarchySel' => $hierId, 'levels' => $levelList ]);
    }

    public function index(Request $request): JsonResponse
    {
        $usr = AdminController::getRealUser($request);

        $selHierarchy = (int) $request['personal-job-hierarchy-names'] ?? 0;

        return AdminPersonalJobHierarchyController::getCurrentContents($usr, $selHierarchy);
    }

    public function edit(Request $request): JsonResponse
    {
        $usr = AdminController::getRealUser($request);
        $selHierarchy = (int) $request['personal-job-hierarchy-names'] ?? 0;

        // Esegui una transazione per modificare le tabelle `employee_hierarchy`, `empl_hierarchy` e `empl_hierarchy_lang`.
        DB::transaction(function() use ($request, $usr, $selHierarchy) {
            $usrId = (int) $usr->id;

            // Assicurati che l'id della gerarchia appartenga effettivamente all'utente.
            $hierarchy = DB::select('SELECT `id` FROM `employee_hierarchy`' .
                                     ' WHERE `id` = :id AND `employee_id` = :empl',
                                    [ 'id' => $selHierarchy, 'empl' => $usrId ]);
            Validator::make([ 'hier-injected' => $hierarchy ], [ 'hier-injected' => "array|size:1" ])->validate();

            // Se un nuovo nome della gerarchia è stato specificato, modificalo.
            if (mb_strlen($request['personal-new-job-hierarchy-name']) > 0) {
                $validated = $request->validate([ 'personal-new-job-hierarchy-name' => 'required|max:64' ]);

                // Nota: la potenziale injection di una gerarchia non appartenente all'utente è stata
                //       controllata in precedenza (Validator::make()).
                DB::update('UPDATE `employee_hierarchy` SET `name` = :name WHERE `id` = :id',
                            [ 'id' => $selHierarchy, 'name' => $validated['personal-new-job-hierarchy-name'] ]);
            }

            // Determina il numero di livelli inviati (deve essere compreso tra 1 e 4).
            $re = '';
            $validated = $request->validate([ 'phier-level-count' => 'numeric|between:1,4' ]);
            $lvlCnt = $validated['phier-level-count'];
            for ( $n = 1 ; $n <= $lvlCnt ; $n++ ) $re .= "$n";

            // Popola l'array $blkNames con le variabili post della request.
            // Il formato della key per le variabili dei 'name' è:
            //   phier-L-C: L = level (1 - 4), C = language code (lowercase).
            $blkNames = [];
            foreach ($request->post() as $key => $value) {
                // Assumi solo le variabili non null e con il numero di livello limitato a $lvlCnt ($re).
                if (!is_null($value) && preg_match("/^phier-([$re])-([a-z]{2})$/", $key, $mt) === 1) {
                    $vld = $request->validate([ $key => 'required|max:64' ]);
                    $blkNames[$mt[1]][$mt[2]] = $vld[$key];
                }
            }

            // L'array $blkNames deve contenere esattamente $lvlCnt livelli, questo vuol dire che ogni livello
            // contiene almeno una lingua con un nome valido.
            // Nota: il metodo Validator::make() permette di validare dei dati non provenienti da $request,
            //       infatti, viene validato l'array locale $blkNames appena popolato.
            Validator::make(['hier-name-blocks' => $blkNames],
                            [ 'hier-name-blocks' => "array|size:$lvlCnt" ])->validate();

            // Elimina i livelli correnti della gerarchia identificata da $selHierarchy dalla tabella
            // `empl_hierarchy`.
            // Le row referenziate nella tabella `empl_hierarchy_lang` vengono automaticamente eliminate
            // grazie alla action ON DELETE CASACADE.
            // Le row dei livelli e delle lingue viene ricostruito di seguito, se si verifia un errore,
            // la transaction termina con un rollback ripristinando lo stato precedente.
            // Nota: la potenziale injection di una gerarchia non appartenente all'utente è stata
            //       controllata in precedenza (Validator::make()).
            DB::delete('DELETE `eh`' .  // Utilizza il nome dell'alias definito nella JOIN.
                        ' FROM `employee_hierarchy` emp JOIN `empl_hierarchy` eh ON eh.`employee_hierarchy_id` = emp.`id`' .
                        ' WHERE emp.`id` = :id', [ 'id' => $selHierarchy ]);

            // Costruisci la lista dei livelli (tabella `empl_hierarchy`).
            $values = 'VALUES ';
            for ( $n = 1 ; $n <= $lvlCnt ; $n++ ) {
                $values .= "($selHierarchy, $n)";  // Double-quote per espandere i valori delle variabili.
                if ($n < $lvlCnt) $values .= ', ';
            }

            // Inserisci i livelli della gerarchia.
            DB::insert("INSERT INTO `empl_hierarchy` (`employee_hierarchy_id`, `level`) $values");

            // Itera i livelli delle gerarchie.
            for ( $n = 1 ; $n <= $lvlCnt ; $n++ ) {
                // Inserisci i nomi multilingua del livello corrente ($n).
                foreach ($blkNames[$n] as $key => $value) {
                    DB::insert('INSERT INTO `empl_hierarchy_lang` (`employee_hierarchy_id`, `level`, `lang_code`, `name`)' .
                                ' VALUES (:id, :level, :lang, :name)',
                               [ 'id' => $selHierarchy, 'level' => $n, 'lang' => $key, 'name' => $value ]);
                }
            }
        });

        return AdminPersonalJobHierarchyController::getCurrentContents($usr, $selHierarchy);
    }

    public function add(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'personal-new-job-hierarchy-name' => 'required|max:64',
            'phier-level-count' => 'numeric|between:1,4',
        ]);

        // Determina il numero di livelli inviati (deve essere compreso tra 1 e 4).
        $re = '';
        $lvlCnt = $validated['phier-level-count'];
        for ( $n = 1 ; $n <= $lvlCnt ; $n++ ) $re .= "$n";

        // Popola l'array $blkNames con le variabili post della request.
        // Il formato della key per le variabili dei 'name' è:
        //   phier-L-C: L = level (1 - 4), C = language code (lowercase).
        $blkNames = [];
        foreach ($request->post() as $key => $value) {
            // Assumi solo le variabili non null e con il numero di livello limitato a $lvlCnt ($re).
            if (!is_null($value) && preg_match("/^phier-([$re])-([a-z]{2})$/", $key, $mt) === 1) {
                $vld = $request->validate([ $key => 'required|max:64' ]);
                $blkNames[$mt[1]][$mt[2]] = $vld[$key];
            }
        }

        // L'array $blkNames deve contenere esattamente $lvlCnt livelli, questo vuol dire che ogni livello
        // contiene almeno una lingua con un nome valido.
        // Nota: il metodo Validator::make() permette di validare dei dati non provenienti da $request,
        //       infatti, viene validato l'array locale $blkNames appena popolato.
        Validator::make(['hier-name-blocks' => $blkNames],
                        [ 'hier-name-blocks' => "array|size:$lvlCnt" ])->validate();

        $usr = AdminController::getRealUser($request);
        $newId = 0;

        // Esegui una transazione per modificare le tabelle `employee_hierarchy`, `empl_hierarchy` e `empl_hierarchy_lang`.
        DB::transaction(function() use ($usr, $validated, $blkNames, $lvlCnt, &$newId) {
            $usrId = (int) $usr->id;

            // Inserisci una nuova gerarchia con il suo nome.
            DB::insert('INSERT INTO `employee_hierarchy` (`employee_id`, `name`) VALUES (:empl, :name)',
                       [ 'empl' => $usrId, 'name' => $validated['personal-new-job-hierarchy-name'] ]);

            // Ottiene l'id auto_increment appena inserito.
            $newId = (int) DB::getPdo()->lastInsertId();

            // Costruisci la lista dei livelli (tabella `empl_hierarchy`).
            $values = 'VALUES ';
            for ( $n = 1 ; $n <= $lvlCnt ; $n++ ) {
                $values .= "($newId, $n)";  // Double-quote per espandere i valori delle variabili.
                if ($n < $lvlCnt) $values .= ', ';
            }

            // Inserisci i livelli della gerarchia.
            DB::insert("INSERT INTO `empl_hierarchy` (`employee_hierarchy_id`, `level`) $values");

            // Itera i livelli delle gerarchie.
            for ( $n = 1 ; $n <= $lvlCnt ; $n++ ) {
                // Inserisci i nomi multilingua del livello corrente ($n).
                foreach ($blkNames[$n] as $key => $value) {
                    DB::insert('INSERT INTO `empl_hierarchy_lang` (`employee_hierarchy_id`, `level`, `lang_code`, `name`)' .
                                ' VALUES (:id, :level, :lang, :name)',
                               [ 'id' => $newId, 'level' => $n, 'lang' => $key, 'name' => $value ]);
                }
            }
        });

        return AdminPersonalJobHierarchyController::getCurrentContents($usr, $newId);
    }

    public function delete(Request $request): JsonResponse
    {
        $usr = AdminController::getRealUser($request);
        $selHierarchy = $request['personal-job-hierarchy-names'] ?? 0;

        // Nota: l'utilizzo del campo `employee_id` nella clausola WHERE evita che si possa
        //       iniettare un `id` di una gerarchia non appartenente all'utente stesso.
        DB::delete('DELETE FROM `employee_hierarchy` WHERE `id` = :id AND `employee_id` = :empl',
                   [ 'id' => $selHierarchy, 'empl' => $usr->id ]);

        return AdminPersonalJobHierarchyController::getCurrentContents($usr, $selHierarchy);
    }
}
