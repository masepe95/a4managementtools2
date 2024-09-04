<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class AdminEmployeesSectionsController extends Controller
{
    private static function getEmployeesSections($usr, $selEmployee, $selSection): JsonResponse
    {
        // Nome del customer a cui appartiene l'impiegato corrente.
        $customerName = DB::scalar('SELECT `name` FROM `customer` WHERE `id` = :cust', [ 'cust' => $usr->customer_id ]);

        // Ritorna gli impiegati del customer (ritorna un array vuoto se nessun impiegato è stato trovato).
        $employees = DB::select("SELECT `id`, CONCAT(`firstname`, ' ', `lastname`) AS `fullname`," .
                                      ' `acronym`, `employee_id`, `email`, `role`, `job_title`,' .
                                      ' (SELECT COUNT(`employee_id`) FROM `section_employee` WHERE `employee_id` = `id`) AS `cntSects`' .
                                 ' FROM `employee` WHERE `customer_id` = :cust ORDER BY `firstname`, `lastname`',
                                [ 'cust' => $usr->customer_id ]);

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

        $lang = App::getLocale();

        // Ritorna le sezioni del customer (ritorna un array vuoto se nessuna sezione è stata trovata).
        $sections = DB::select('SELECT sl.`level`, sc.`id` AS `sectionId`,' .
                                     ' (SELECT sll.`name` FROM `section_level_lang` sll' .
                                        ' JOIN `language` lg ON lg.`code` = sll.`lang_code`' .
                                        ' WHERE sll.`level` = sl.`level` AND sll.`customer_id` = sl.`customer_id`' .
                                        ' ORDER BY IF(sll.`lang_code` = :lvllng, 0, lg.order) LIMIT 1) AS `levelName`,' .
                                     ' (SELECT scl.`name` FROM `section_lang` scl' .
                                        ' JOIN `language` lg ON lg.`code` = scl.`lang_code`' .
                                        ' WHERE scl.`section_id` = sc.`id` AND scl.`customer_id` = sl.`customer_id`' .
                                        ' ORDER BY IF(scl.`lang_code` = :sectlng, 0, lg.order) LIMIT 1) AS `sectionName`,' .
                                     ' (SELECT COUNT(se.`section_id`) FROM `section_employee` se WHERE se.`section_id` = sc.`id`) AS `cntEmps`' .
                                ' FROM `section_level` sl' .
                                ' JOIN `section` sc ON sc.`level` = sl.`level` AND sc.`customer_id` = sl.`customer_id`' .
                                ' WHERE sl.`customer_id` = :cust' .
                                ' ORDER BY sl.`level`, `sectionName`',
                               [ 'cust' => $usr->customer_id, 'lvllng' => $lang, 'sectlng' => $lang ]);

        // Se non c'è una selezione corrente ($selSection = 0), assumi come nuova selezione
        // la prima row della collection $sections (se esiste).
        if ($selSection <= 0) {
            if (count($sections) > 0) $selSection = $sections[0]->sectionId;
        }
        else if (count($sections) > 0) {
            // Controlla che il `sectionId` $selSection esista nell'array $sections, in caso contrario,
            // assumi il `sectionId` della prima row della collection $sections (avviene durante il cambio
            // dell'Impersonated employee o a causa di una injection).
            $sel = $sections[0]->sectionId;
            foreach ($sections as $sect) {
                if ($sect->sectionId == $selSection) {
                    $sel = $selSection;
                    break;
                }
            }

            $selSection = $sel;
        }


        // Ritorna le sezioni associate all'impiegato selezionato (ritorna un array vuoto se nessuna associazione è stata trovata).
        $empSects = DB::select('SELECT `section_id` FROM `section_employee` WHERE `employee_id` = :emp AND `customer_id` = :cust',
                               [ 'emp' => $selEmployee, 'cust' => $usr->customer_id ]);
        $empSectsArr = [];
        foreach ($empSects as $sect) { $empSectsArr[] = $sect->section_id; }

        // Ritorna gli impiegati associati alla sezione selezionata (ritorna un array vuoto se nessuna associazione è stata trovata).
        $sectEmps = DB::select('SELECT `employee_id` FROM `section_employee` WHERE `section_id` = :sect AND  `customer_id` = :cust',
                               [ 'sect' => $selSection, 'cust' => $usr->customer_id ]);
        $sectEmpsArr = [];
        foreach ($sectEmps as $emp) { $sectEmpsArr[] = $emp->employee_id; }


        // Tipi di informazioni extra dell'impiegato.
        // Nota: le stringhe delle lingue sono assunte dai file "adm-employees.php".
        $roleType = __('globals.employee-role');
        $role = __('admin/adm-employees.role') . ': ';
        $jobTitle = __('admin/adm-employees.job-title') . ': ';
        $acronym = __('admin/adm-employees.acronym') . ': ';
        $employeeId = __('admin/adm-employees.employee-id') . ': ';

        $employeeOpts = ''; $sectionEmpsOpts = '';

        // Costruisci le <option> per l'associazione Employee => Sections.
        foreach ($employees as $employee) {
            $sel = ($employee->id == $selEmployee) ? ' selected=""' : '';
            $fullname = htmlentities($employee->fullname, ENT_QUOTES, 'UTF-8');
            $email = htmlentities($employee->email, ENT_QUOTES, 'UTF-8');

            // Costruisci la stringa di informazione extra dell'impiegato.
            $extra = [ $role . $roleType[$employee->role] ];
            if (strlen($employee->job_title ?? '') > 0) $extra[] = $jobTitle . $employee->job_title;
            if (strlen($employee->acronym ?? '') > 0) $extra[] = $acronym . $employee->acronym;
            if (strlen($employee->employee_id ?? '') > 0) $extra[] = $employeeId . $employee->employee_id;

            $extra = ' data-te-select-secondary-text="' . htmlentities(implode(' || ', $extra), ENT_QUOTES, 'UTF-8') . '"';
            $bullet = ($employee->cntSects > 0) ? ' &#x2022;' : '';
            $tooltip = ($employee->cntSects > 0) ? ' data-title="' .
                                                   trans_choice('admin/adm-employees-sections.associated-sections',
                                                                $employee->cntSects, [ 'count' => $employee->cntSects ]) . '"' : '';

            $employeeOpts .= "<option value=\"{$employee->id}\"$extra$tooltip$sel>$fullname$bullet &nbsp; &lt;$email&gt;</option>";

            // Costruisci la lista di impiegati che sono associati alla sezione selezionata.
            $sel = (in_array($employee->id, $sectEmpsArr)) ? ' selected=""' : '';
            $sectionEmpsOpts .= "<option value=\"{$employee->id}\"$extra$sel>$fullname &nbsp; &lt;$email&gt;</option>";
        }

        $levelPrefix = __('admin/adm-sections.level-label');
        $sectionOpts = ''; $employeeSectsOpts = ''; $levelGroup = -1;

        // Costruisci le <option> per l'associazione Section => Employees.
        foreach ($sections as $section) {
            $sel = ($section->sectionId == $selSection) ? ' selected=""' : '';
            if ($section->level != $levelGroup) {
                if ($levelGroup > 0) { $sectionOpts .= '</optgroup>'; $employeeSectsOpts .= '</optgroup>'; }

                $levelGroup = $section->level;
                $label = htmlentities("$levelPrefix $levelGroup: {$section->levelName}", ENT_QUOTES, 'UTF-8');
                $sectionOpts .= "<optgroup label=\"$label\">";
                $employeeSectsOpts .= "<optgroup label=\"$label\">";
            }

            $bullet = ($section->cntEmps > 0) ? ' &#x2022;' : '';
            $tooltip = ($section->cntEmps > 0) ? ' data-title="' .
                                                 trans_choice('admin/adm-employees-sections.associated-employees',
                                                              $section->cntEmps, [ 'count' => $section->cntEmps ]) . '"' : '';

            $sectionOpts .= "<option value=\"{$section->sectionId}\"$tooltip$sel>{$section->sectionName}$bullet</option>";

            // Costruisci la lista delle sezioni che sono associate all'impiegato selezionato.
            $sel = (in_array($section->sectionId, $empSectsArr)) ? ' selected=""' : '';
            $employeeSectsOpts .= "<option value=\"{$section->sectionId}\"$sel>{$section->sectionName}</option>";
        }

        // Chiudi l'ultimo gruppo (se esiste).
        if ($levelGroup > 0) { $sectionOpts .= '</optgroup>'; $employeeSectsOpts .= '</optgroup>'; }

        return response()->json([ 'employeeOpts' => $employeeOpts, 'sectionOpts' => $sectionOpts,
                                  'employeeSectsOpts' => $employeeSectsOpts, 'sectionEmpsOpts' => $sectionEmpsOpts,
                                  'customer-name' => $customerName ]);
    }

    public function index(Request $request): JsonResponse
    {
        $usr = AdminController::getRealUser($request);

        $selEmployee = (int) $request['employee-section-names'] ?? 0;
        $selSection = (int) $request['section-employee-names'] ?? 0;

        return AdminEmployeesSectionsController::getEmployeesSections($usr, $selEmployee, $selSection);
    }

    public function saveEmployee(Request $request): JsonResponse
    {
        $usr = AdminController::getRealUser($request);

        // Il valore di $selSection serve solo come parametro di getEmployeesSections().
        $selEmployee = (int) $request['employee-section-names'] ?? 0;
        $selSection = (int) $request['section-employee-names'] ?? 0;
        $sectIdList = $request['section-all-names'] ?? [];

        // Salva le sezioni associate all'impiegato selezionato.
        DB::transaction(function() use ($usr, $selEmployee, $sectIdList) {
            // Elimina tutte le references delle sezioni associate all'impiegato $selEmployee.
            DB::delete('DELETE FROM `section_employee` WHERE `employee_id` = :emp AND `customer_id` = :cust',
                       [ 'emp' => $selEmployee, 'cust' => $usr->customer_id ]);

            // Aggiungi le nuove sezioni associate all'impiegato $selEmployee (se ce ne sono).
            if (count($sectIdList) > 0) {
                $values = '';
                $cust = (int) $usr->customer_id;

                // Costruisci la lista di id delle sezioni da associare all'impiegato $selEmployee.
                foreach ($sectIdList as $sect) {
                    if (strlen($values) > 0) $values .= ',';

                    $sectId = (int) $sect;
                    $values .= "($sectId,$selEmployee,$cust)";
                }

                // Nota: non serve nessun binding, tutti i dati assunti da POST sono castati ad integer (safe datas).
                DB::insert('INSERT INTO `section_employee` (`section_id`, `employee_id`, `customer_id`)  VALUES ' . $values);
            }
        });

        return AdminEmployeesSectionsController::getEmployeesSections($usr, $selEmployee, $selSection);
    }

    public function saveSection(Request $request): JsonResponse
    {
        $usr = AdminController::getRealUser($request);

        // Il valore di $selEmployee serve solo come parametro di getEmployeesSections().
        $selEmployee = (int) $request['employee-section-names'] ?? 0;
        $selSection = (int) $request['section-employee-names'] ?? 0;
        $empIdList = $request['employee-all-names'] ?? [];

        // Salva gli impiegati associati alla sezione selezionata.
        DB::transaction(function() use ($usr, $selSection, $empIdList) {
            // Elimina tutte le references degli impiegati associati alla sezione $selSection.
            DB::delete('DELETE FROM `section_employee` WHERE `section_id` = :sect AND `customer_id` = :cust',
                       [ 'sect' => $selSection, 'cust' => $usr->customer_id ]);

            // Aggiungi i nuovi impiegati associati alla sezione $selSection (se ce ne sono).
            if (count($empIdList) > 0) {
                $values = '';
                $cust = (int) $usr->customer_id;

                // Costruisci la lista di id degli impiegati da associare alla sezione $selSection.
                foreach ($empIdList as $emp) {
                    if (strlen($values) > 0) $values .= ',';

                    $empId = (int) $emp;
                    $values .= "($selSection,$empId,$cust)";
                }

                // Nota: non serve nessun binding, tutti i dati assunti da POST sono castati ad integer (safe datas).
                DB::insert('INSERT INTO `section_employee` (`section_id`, `employee_id`, `customer_id`)  VALUES ' . $values);
            }
        });

        return AdminEmployeesSectionsController::getEmployeesSections($usr, $selEmployee, $selSection);
    }
}
