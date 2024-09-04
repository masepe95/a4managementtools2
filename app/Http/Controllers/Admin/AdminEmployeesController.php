<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class AdminEmployeesController extends Controller
{
    private static function getEmployees($usr, $selEmployee): JsonResponse
    {
        // Ritorna gli impiegati del customer (ritorna un array vuoto se nessun impiegato è stato trovato).
        $employees = DB::select('SELECT `id`, `acronym`, `employee_id`, `firstname`, `lastname`, `email`, `role`,' .
                                      ' `job_title`, `phone`, `mobile_phone`, `language_code`,  `employee_status`,' .
                                      ' `photo_file`' .
                                 ' FROM `employee` WHERE `customer_id` = :cust ORDER BY `firstname`, `lastname`',
                                [ 'cust' => $usr->customer_id ]);
        // Altri campi: `failed_passwords`, `password_failure_time`.

        // Nome del customer a cui appartiene l'impiegato corrente.
        $customerName = DB::scalar('SELECT `name` FROM `customer` WHERE `id` = :cust', [ 'cust' => $usr->customer_id ]);

        // Se non c'è una selezione corrente ($selEmployee = 0), assumi come nuova selezione
        // la prima row della collection $employees (se esiste).
        if ($selEmployee <= 0) {
            if (count($employees) > 0) $selEmployee = $employees[0]->id;
        }
        else if (count($employees) > 0) {
            // Controlla che l' `id` $selEmployee esista nell'array $employees, in caso contrario,
            // assumi l' `id` della prima row della collection $employees (avviene durante il cambio
            // dell'Impersonated employee o a causa di una injection).
            $sel = $employees[0]->id;
            foreach ($employees as $emp) {
                if ($emp->id == $selEmployee) {
                    $sel = $selEmployee;
                    break;
                }
            }

            $selEmployee = $sel;
        }

        // Tipi di informazioni extra dell'impiegato.
        $roleType = __('globals.employee-role');
        $role = __('admin/adm-employees.role') . ': ';
        $jobTitle = __('admin/adm-employees.job-title') . ': ';
        $acronym = __('admin/adm-employees.acronym') . ': ';
        $employeeId = __('admin/adm-employees.employee-id') . ': ';

        $employeeOpts = ''; $selected = []; $accessOpts = '';

        foreach ($employees as $employee) {
            $sel = ($employee->id == $selEmployee) ? ' selected=""' : '';
            if (strlen($sel) > 0) {
                $selected = [
                    'id' => $employee->id,
                    'acronym' => $employee->acronym ?? '',
                    'employee_id' => $employee->employee_id ?? '',
                    'firstname' => $employee->firstname,
                    'lastname' => $employee->lastname,
                    'email' => $employee->email,
                    'role' => $employee->role,
                    'job_title' => $employee->job_title ?? '',
                    'phone' => $employee->phone ?? '',
                    'mobile_phone' => $employee->mobile_phone ?? '',
                    'language_code' => $employee->language_code,
                    'employee_status' => $employee->employee_status,
                    'photo_file' => $employee->photo_file
                ];

                $photo = $employee->photo_file;
                if (!is_null($photo)) {
                    $photo = GetImage::getImageInfo($photo);
                    if ($photo != '') $selected['photo_file'] = $photo;
                }

                // Ritorna gli accessi di questo impiegato per ogni singolo tool del proprio customer (solo se "enabled").
                $acs = DB::select('SELECT ct.`tool_id`, LOWER(tl.`name_id`) AS `name_id`,' .
                                        " CONCAT(tl.`name_id`, '.', tl.`title_id`) AS `tool_name`," .
                                        " IF(et.`access` IS NULL, 'none' , et.`access`) AS `access`" .
                                   ' FROM `customer_tool` ct JOIN `tool` tl ON tl.`id` = ct.`tool_id`' .
                                   ' LEFT JOIN `employee_tool` et ON et.`tool_id` = ct.`tool_id` AND' .
                                                                   ' et.`customer_id` = ct.`customer_id` AND' .
                                                                   ' et.`employee_id` = :emp' .
                                   " WHERE ct.customer_id = :cust AND ct.enabled = 'Y'" .
                                   ' ORDER BY ct.`tool_id`',
                                  [ 'cust' => $usr->customer_id, 'emp' => $selEmployee ]);

                $ch = __('admin/adm-employees.tools-visibility-choices');
                $wt = $ch['write']['tooltip'];
                $wl = $ch['write']['label'];
                $rt = $ch['read']['tooltip'];
                $rl = $ch['read']['label'];
                $nt = $ch['none']['tooltip'];
                $nl = $ch['none']['label'];

                // Costruisci le entries degli accessi per ogni tool del customer.
                foreach ($acs as $ac) {
                    $accessOpts .= '<li class="p-2 hover:bg-neutral-100">';
                    $accessOpts .= '<div class="grid grid-cols-[auto_1fr] gap-x-1">';
                    $accessOpts .= '<div class="select-sm-cont flex justify-start text-sm">';

                    $nm = $ac->name_id;
                    $accessOpts .= "<select id=\"emp-access-$nm\" name=\"emp-access-$nm\" data-te-select-size=\"sm\"";
                    $accessOpts .= ' data-te-select-init="" data-te-class-select-input-size-sm="py-[0.2rem] text-xs leading-[1.5]"';
                    $accessOpts .= ' data-te-select-option-height="30" class="emp-tool-selector"';
                    $accessOpts .= ' title="' . ($ch[$ac->access]['tooltip']) . '">';

                    $sa = ($ac->access == 'write') ? ' selected=""' : '';
                    $accessOpts .= "<option value=\"write\" title=\"$wt\"$sa>$wl</option>";
                    $sa = ($ac->access == 'read') ? ' selected=""' : '';
                    $accessOpts .= "<option value=\"read\" title=\"$rt\"$sa>$rl</option>";
                    $sa = ($ac->access == 'none') ? ' selected=""' : '';
                    $accessOpts .= "<option value=\"none\" title=\"$nt\"$sa>$nl</option>";

                    $accessOpts .= '</select></div>';

                    // Aggiungi la classe "underline" per tutti gli accessi che sono correntemente 'read' o 'write'.
                    // L'accesso correntemente 'none' non ha la classe "underline".
                    $underline = ($ac->access == 'none') ? '' : ' underline';
                    $accessOpts .= "<div class=\"tool-access-div pl-2{$underline}\" title=\"{$ac->tool_name}\">{$ac->tool_name}</div>";

                    $accessOpts .= '</div></li>';
                }
            }

            $fullname = htmlentities($employee->firstname . ' ' . $employee->lastname, ENT_QUOTES, 'UTF-8');
            $email = htmlentities($employee->email, ENT_QUOTES, 'UTF-8');

            // Costruisci la stringa di informazione extra dell'impiegato.
            $extra = [ $role . $roleType[$employee->role] ];
            if (strlen($employee->job_title ?? '') > 0) $extra[] = $jobTitle . $employee->job_title;
            if (strlen($employee->acronym ?? '') > 0) $extra[] = $acronym . $employee->acronym;
            if (strlen($employee->employee_id ?? '') > 0) $extra[] = $employeeId . $employee->employee_id;

            $extra = ' data-te-select-secondary-text="' . htmlentities(implode(' || ', $extra), ENT_QUOTES, 'UTF-8') . '"';

            $employeeOpts .= "<option value=\"{$employee->id}\"$extra$sel>$fullname &nbsp; &lt;$email&gt;</option>";
        }

        return response()->json([ 'employees' => $employeeOpts, 'selected' => $selected,
                                  'accesses' => $accessOpts, 'customer-name' => $customerName ]);
    }

    public function index(Request $request): JsonResponse
    {
        $usr = AdminController::getRealUser($request);

        $selEmployee = (int) $request['employee-names'] ?? 0;

        return AdminEmployeesController::getEmployees($usr, $selEmployee);
    }

    public function edit(Request $request): JsonResponse
    {
        $usr = AdminController::getRealUser($request);
        $selEmployee = (int) $request['employee-names'] ?? 0;

        // Ottieni i codici ISO 639-1 delle lingue supportate.
        $langs = DB::scalar('SELECT GROUP_CONCAT(`code`) FROM `language`');

        // Il ruolo 'siteAdmin' può essere assegnato solo se l'utente loggato è un 'siteAdmin'.
        $role = 'employee,customerAdmin';
        if ($request->user()->role == 'siteAdmin') $role .=  ',siteAdmin';

        $status = 'enabled,disabled';

        $validated = $request->validate([
            'employee-firstname' => 'required|max:64',
            'employee-lastname' => 'required|max:64',
            'employee-acronym' => 'nullable|max:32',
            'employee-employee-id' => 'nullable|max:32',
            'employee-mobile-phone' => 'nullable|max:32',
            'employee-phone' => 'nullable|max:32',
            'employee-email' => 'required|email:rfc|max:128',
            'employee-language-code' => "required|in:$langs|size:2",
            'employee-password' => 'nullable|required_with:employee-password-new|current_password',
            'employee-password-new' => 'nullable|required_with:employee-password|different:employee-password|min:8|max:64',
            'employee-job-title' => 'nullable|max:64',
            'employee-role' => "required|in:$role",  // Questo campo è anche vincolato dal trigger 'employee_BEFORE_UPDATE'.
            'employee-status' => "required|in:$status",
        ]);

        // Esegui una transazione per modificare le tabelle `employee` e `empl_hierarchy_lang`.
        DB::transaction(function() use ($request, $usr, $selEmployee, $validated) {

            $sql = 'UPDATE `employee` SET `firstname` = :firstname, `lastname` = :lastname, `email` = :email,' .
                                        ' `acronym` = :acronym, `employee_id` = :empId, `job_title` = :jobTitle,' .
                                        ' `phone` = :phone, `mobile_phone` = :mobilePhone, `language_code` = :lang,' .
                                        ' `role` = :role, `employee_status` = :status';
            $bindings = ['firstname' => $validated['employee-firstname'], 'lastname' => $validated['employee-lastname'],
                        'email' => $validated['employee-email'], 'acronym' => $validated['employee-acronym'],
                        'empId' => $validated['employee-employee-id'], 'jobTitle' => $validated['employee-job-title'],
                        'phone' => $validated['employee-phone'], 'mobilePhone' => $validated['employee-mobile-phone'],
                        'lang' => $validated['employee-language-code'], 'role' => $validated['employee-role'],
                        'status' => $validated['employee-status'], 'id' => $selEmployee, 'cust' => $usr->customer_id
                        ];

            // Modifica la password solo se non è blank.
            // La validazione controlla che la password attuale sia corretta.
            if (strlen(trim($validated['employee-password-new'])) > 0) {
                // Aggiungi la password alla query e ai bindings.
                $sql .= ', `password` = :pw';
                $bindings['pw'] = Hash::make($validated['employee-password-new']);
            }

            // Il parametro `customer_id` garantisce che i dati siano modificati solo se $selEmployee
            // è un impiegato appartenente al `customer_id` stesso.
            DB::update($sql . ' WHERE `id` = :id AND `customer_id` = :cust', $bindings);

            // Elimina tutti gli accessi dell'impegato.
            DB::delete('DELETE FROM `employee_tool` WHERE `employee_id` = :emp AND `customer_id` = :cust',
                       [ 'emp' => $selEmployee, 'cust' => $usr->customer_id ]);

            // Inserisci il nuovo set di accessi dell'impegato.
            foreach ($request->post() as $key => $value) {
                if (substr($key, 0, 13) == 'emp-access-a4' && $value != 'none') {
                    DB::insert('INSERT INTO `employee_tool` (`customer_id`, `employee_id`, `tool_id`, `access`)' .
                                                     ' VALUE(:cust, :emp, :tool, :access)',
                               [ 'cust' => $usr->customer_id, 'emp' => $selEmployee,
                                 'tool' => (int) substr($key, 13), 'access' => $value
                               ]);
                }
            }
        });

        return AdminEmployeesController::getEmployees($usr, $selEmployee);
    }

    public function add(Request $request): JsonResponse
    {
        $usr = AdminController::getRealUser($request);

        // Ottieni i codici ISO 639-1 delle lingue supportate.
        $langs = DB::scalar('SELECT GROUP_CONCAT(`code`) FROM `language`');

        // Il ruolo 'siteAdmin' può essere assegnato solo se l'utente loggato è un 'siteAdmin'.
        $role = 'employee,customerAdmin';
        if ($request->user()->role == 'siteAdmin') $role .=  ',siteAdmin';

        $status = 'enabled,disabled';

        $validated = $request->validate([
            'employee-firstname' => 'required|max:64',
            'employee-lastname' => 'required|max:64',
            'employee-acronym' => 'nullable|max:32',
            'employee-employee-id' => 'nullable|max:32',
            'employee-mobile-phone' => 'nullable|max:32',
            'employee-phone' => 'nullable|max:32',
            'employee-email' => 'required|email:rfc|max:128',
            'employee-language-code' => "required|in:$langs|size:2",
            'employee-password-new' => 'required|max:128',
            'employee-job-title' => 'nullable|max:64',
            'employee-role' => "required|in:$role",  // Questo campo è anche vincolato dal trigger 'employee_BEFORE_INSERT'.
            'employee-status' => "required|in:$status",
        ]);

        $newId = 0;

        // Esegui una transazione per modificare le tabelle `employee` e `empl_hierarchy_lang`.
        DB::transaction(function() use ($request, $usr, &$newId, $validated) {

            DB::insert('INSERT INTO `employee` SET `firstname` = :firstname, `lastname` = :lastname, `email` = :email,' .
                                        ' `acronym` = :acronym, `employee_id` = :empId, `job_title` = :jobTitle,' .
                                        ' `phone` = :phone, `mobile_phone` = :mobilePhone, `language_code` = :lang,' .
                                        ' `role` = :role, `employee_status` = :status, `password` = :pw, `customer_id` = :cust',
                       ['firstname' => $validated['employee-firstname'], 'lastname' => $validated['employee-lastname'],
                        'email' => $validated['employee-email'], 'acronym' => $validated['employee-acronym'],
                        'empId' => $validated['employee-employee-id'], 'jobTitle' => $validated['employee-job-title'],
                        'phone' => $validated['employee-phone'], 'mobilePhone' => $validated['employee-mobile-phone'],
                        'lang' => $validated['employee-language-code'], 'role' => $validated['employee-role'],
                        'status' => $validated['employee-status'], 'pw' => Hash::make($validated['employee-password-new']),
                        'cust' => $usr->customer_id,
                       ]);

            // Ottiene l'id auto_increment appena inserito.
            $newId = (int) DB::getPdo()->lastInsertId();

            // Inserisci il nuovo set di accessi dell'impegato.
            foreach ($request->post() as $key => $value) {
                if (substr($key, 0, 13) == 'emp-access-a4' && $value != 'none') {
                    DB::insert('INSERT INTO `employee_tool` (`customer_id`, `employee_id`, `tool_id`, `access`)' .
                                                     ' VALUE(:cust, :emp, :tool, :access)',
                               [ 'cust' => $usr->customer_id, 'emp' => $newId,
                                 'tool' => (int) substr($key, 13), 'access' => $value
                               ]);
                }
            }
        });

        return AdminEmployeesController::getEmployees($usr, $newId);
    }

    public function delete(Request $request): JsonResponse
    {
        $usr = AdminController::getRealUser($request);
        $selEmployee = (int) $request['employee-names'] ?? 0;

        // Nota: l'utilizzo del campo `customer_id` nella clausola WHERE evita che si possa
        //       iniettare un `id` di un impiegato non appartenente al customer stesso.
        // Nota: non permettere di eliminare degli impiegati con il ruolo 'siteAdmin'.
        // Nota: non permettere di eliminare l'ultimo impiegato del customer.
        // Nota: se in una subquery SELECT si specifica la stessa tabella che si sta modificando,
        //       si ottiene l'errore
        //         ERROR 1093 (HY000): You can't specify target table 'employee' for update in FROM clause"
        //       Utilizzare una tabella derivata (materializza in una tabella temporanea) come workaround.
        $del = DB::delete('DELETE FROM `employee`' .
                           " WHERE `id` = :id AND `customer_id` = :cust AND `role` != 'siteAdmin' AND" .
                           ' 1 < (SELECT tb.cnt FROM (SELECT COUNT(em.`id`) AS cnt' .
                                                      ' FROM `employee` em WHERE em.`customer_id` = :cs) AS tb)',
                           [ 'id' => $selEmployee, 'cust' => $usr->customer_id, 'cs' => $usr->customer_id ]);

        // Se l'impiegato è stato eliminato ($del == 1), seleziona il primo impiegato della lista (0),
        // in caso contrario (impiegato non eliminato), mantienilo selezionato nella lista ritornata.
        return AdminEmployeesController::getEmployees($usr, ($del > 0) ? 0 : $selEmployee);
    }

    public function uploadPhoto(Request $request): JsonResponse
    {
        // Carica la foto dell'utente impostando il campo `photo_file` con il parametro 'employeePhoto'.
        $cust = AdminController::getRealUser($request)->customer_id;
        $selEmployee = (int) $request['employee-names'] ?? 0;

        // L'utente $selEmployee deve appartenere allo stesso customer dell'utente loggato o
        // impersonato (previene l'injection di un `id` di un impiegato non appartenente al customer stesso).
        $usr = User::where('customer_id', $cust)->find($selEmployee);
        $file = $request->file('employeePhoto');  // Path del file temporaneo (es.: 'C:\PHP8\uploadtemp\phpBDD3.tmp').

        if (!is_null($usr)) {
            $usr->photo_file = File::get($file);  // Equivalente alla funzione file_get_contents($file).
            $usr->save();

            $photo = $usr->photo_file;
        }
        else $photo = null;

        File::delete($file);  // Elimina il file temporaneo caricato sul server.

        if (!is_null($photo)) {
            $photo = GetImage::getImageInfo($photo);
            if ($photo == '') $photo = null;
        }

        return response()->json([ 'photo' => $photo ]);
    }

    public function deletePhoto(Request $request): JsonResponse
    {
        // Elimina la foto dell'utente impostando il campo `photo_file` con il valore null.
        $cust = AdminController::getRealUser($request)->customer_id;
        $selEmployee = (int) $request['employee-names'] ?? 0;

        // L'utente $selEmployee deve appartenere allo stesso customer dell'utente loggato o
        // impersonato (previene l'injection di un `id` di un impiegato non appartenente al customer stesso).
        $usr = User::where('customer_id', $cust)->find($selEmployee);
        if (!is_null($usr)) {
            $usr->photo_file = null;
            $usr->save();
        }

        return response()->json([ 'deleted' => !is_null($usr) ]);
    }
}
