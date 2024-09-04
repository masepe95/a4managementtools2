<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class AdminPersonalToolsController extends Controller
{
    private static function getEmployeeTools($selEmployee): JsonResponse
    {
        // Ritorna tutti gli impiegati.
        $employees = DB::select('SELECT cs.`id` AS `custId`, cs.`name` AS `custName`, em.`id` AS `empId`,' .
                                      " CONCAT(em.`firstname`, ' ', em.`lastname`) AS `fullname`," .
                                      ' em.`email`, em.`role`, em.`job_title`, em.`acronym`, em.`employee_id`' .
                                 ' FROM `customer` cs JOIN `employee` em ON em.`customer_id` = cs.`id`' .
                                 ' ORDER BY cs.`name`, em.`firstname`, em.`lastname`');

        // Se non c'è una selezione corrente ($selEmployee = 0), assumi come nuova selezione
        // la prima row della collection $employees (se esiste).
        if ($selEmployee <= 0) {
            if (count($employees) > 0) $selEmployee = $employees[0]->empId;
        }
        else if (count($employees) > 0) {
            // Controlla che l' `empId` $selEmployee esista nell'array $employees, in caso contrario,
            // assumi l' `empId` della prima row della collection $employees (avviene durante il cambio
            // dell'Impersonated employee o a causa di una injection).
            $sel = $employees[0]->empId;
            foreach ($employees as $emp) {
                if ($emp->empId == $selEmployee) {
                    $sel = $selEmployee;
                    break;
                }
            }

            $selEmployee = $sel;
        }

        // Tipi di informazioni extra dell'impiegato.
        // Nota: le stringhe delle lingue sono assunte dai file "adm-employees.php".
        $roleType = __('globals.employee-role');
        $role = __('admin/adm-employees.role') . ': ';
        $jobTitle = __('admin/adm-employees.job-title') . ': ';
        $acronym = __('admin/adm-employees.acronym') . ': ';
        $employeeId = __('admin/adm-employees.employee-id') . ': ';

        $employeeOpts = ''; $customerId = -1;

        // Costruisci i <optgroup> e le <option> dei Customers/Employees.
        foreach ($employees as $employee) {
            $sel = ($employee->empId == $selEmployee) ? ' selected=""' : '';
            if ($employee->custId != $customerId) {
                if ($customerId > 0) $employeeOpts .= '</optgroup>';

                $customerId = $employee->custId;
                $label = htmlentities($employee->custName, ENT_QUOTES, 'UTF-8');
                $employeeOpts .= "<optgroup id=\"$customerId\" label=\"$label\">";
            }

            $fullname = htmlentities($employee->fullname, ENT_QUOTES, 'UTF-8');
            $email = htmlentities($employee->email, ENT_QUOTES, 'UTF-8');

            // Costruisci la stringa di informazione extra dell'impiegato.
            $extra = [ $role . $roleType[$employee->role] ];
            if (strlen($employee->job_title ?? '') > 0) $extra[] = $jobTitle . $employee->job_title;
            if (strlen($employee->acronym ?? '') > 0) $extra[] = $acronym . $employee->acronym;
            if (strlen($employee->employee_id ?? '') > 0) $extra[] = $employeeId . $employee->employee_id;

            $extra = ' data-te-select-secondary-text="' . htmlentities(implode(' || ', $extra), ENT_QUOTES, 'UTF-8') . '"';

            $employeeOpts .= "<option value=\"{$employee->empId}\"$extra$sel>$fullname &nbsp; &lt;$email&gt;</option>";
        }

        $toolOpts = '';

        // Ritorna i tools assegnati all'impiegato $selEmployee (solo se i tools sono "active").
        $acs = DB::select('SELECT tl.`id` AS `toolId`, tl.`name_id` AS `toolNameId`, tl.`title_id` AS `toolTitleId`,' .
                                " IF(ept.`enabled` IS NULL, 'none', ept.`enabled`) AS `assignment`," .
                                ' (SELECT COUNT(pj.`tool_id`) FROM `personal_job` pj' .
                                   ' WHERE pj.`employee_id` = ept.`employee_id` AND pj.`tool_id` = ept.`tool_id`) AS `cntJobs`' .
                           ' FROM `tool` tl LEFT JOIN `employee_personal_tool` ept' .
                                                    ' ON ept.`tool_id` = tl.`id` AND ept.`employee_id` = :emp' .
                           " WHERE tl.`active` = 'Y'" .
                           ' ORDER BY tl.`id`',
                          [ 'emp' => $selEmployee ]);

        $ch = __('admin/adm-personal-tools.tools-visibility-choices');
        $et = $ch['Y']['tooltip'];
        $el = $ch['Y']['label'];
        $dt = $ch['N']['tooltip'];
        $dl = $ch['N']['label'];
        $nt = $ch['none']['tooltip'];
        $nl = $ch['none']['label'];

        // Costruisci le entries degli assegnamenti di ogni tool per l'impiegato $selEmployee.
        foreach ($acs as $ac) {
            $toolOpts .= '<li class="p-2 hover:bg-neutral-100">';
            $toolOpts .= '<div class="grid grid-cols-[auto_1fr] gap-x-1">';
            $toolOpts .= '<div class="select-sm-cont flex justify-start text-sm">';

            $nm = strtolower($ac->toolNameId);
            $toolOpts .= "<select id=\"emp-personal-tools-$nm\" name=\"emp-personal-tools-$nm\" data-te-select-size=\"sm\"";
            $toolOpts .= ' data-te-select-init="" data-te-class-select-input-size-sm="py-[0.2rem] text-xs leading-[1.5]"';
            $toolOpts .= ' data-te-select-option-height="30" class="pers-emp-tool-selector"';
            $toolOpts .= ' title="' . ($ch[$ac->assignment]['tooltip']) . '">';

            $sa = ($ac->assignment == 'Y') ? ' selected=""' : '';
            $toolOpts .= "<option value=\"yes\" title=\"$et\"$sa>$el</option>";
            $sa = ($ac->assignment == 'none') ? ' selected=""' : '';
            $toolOpts .= "<option value=\"no\" title=\"$nt\"$sa>$nl</option>";
            $sa = ($ac->assignment == 'N') ? ' selected=""' : '';
            $toolOpts .= "<option value=\"disabled\" title=\"$dt\"$sa>$dl</option>";

            $toolOpts .= '</select></div>';

            // Aggiungi la classe "underline" per tutti gli assegnamenti che sono correntemente
            // 'Y' (enabled) o 'N' (disabled).
            // L'assegnamento 'none' (non disponibile) non ha la classe "underline".
            $underline = ($ac->assignment == 'none') ? '' : ' class="underline"';

            // Formatta il numero di jobs: '{0} (No jobs)|{1} (1 job)|[2,*] (:count jobs)'
            $jobTooltip = trans_choice('admin/adm-personal-tools.job-count', $ac->cntJobs);
            $toolOpts .= "<div class=\"tool-access-div\" title=\"{$ac->toolNameId}.{$ac->toolTitleId} $jobTooltip\"";
            if ($ac->cntJobs > 0) $toolOpts .= " data-have-jobs=\"{$ac->cntJobs}\"";

            // Se il tool corrente ha dei jobs, rendi visibile il bullet ■, altrimenti, rendilo trasparente ("tool-have-no-job").
            $haveJobs = "<span class=\"";
            $haveJobs .= ($ac->cntJobs > 0) ? "tool-have-job" : "tool-have-no-job";
            $toolOpts .= ">$haveJobs\">&#x25a0;</span><span$underline>{$ac->toolNameId}.{$ac->toolTitleId}</span></div>";
            $toolOpts .= '</div></li>';
        }

        return response()->json([ 'employeeOpts' => $employeeOpts, 'toolOpts' => $toolOpts ]);
    }

    public function index(Request $request): JsonResponse
    {
        $selEmployee = (int) $request['personal-tool-employee-names'] ?? 0;

        return AdminPersonalToolsController::getEmployeeTools($selEmployee);
    }

    public function store(Request $request): JsonResponse
    {
        $selEmployee = (int) $request['personal-tool-employee-names'] ?? 0;

        // Esegui una transazione per modificare la tabella `employee_personal_tool`.
        DB::transaction(function() use ($request, $selEmployee) {
            // Itera i dati di POST e assumi i dati di assegnazione dei personal tools per l'impiegato
            // $selEmployee (eventualmente impersonato).
            $assignValues = [ 'yes', 'no', 'disabled' ];
            foreach ($request->post() as $key => $value) {
                // Assumi solo le variabili con un valore non null e valido con il formato della $key
                // corrispondente al pattern definito dalla RegExp (A4000/A40000 non accettato).
                if (preg_match('/^emp-personal-tools-a4(?!000$|0000)(\d{3,4})$/', $key, $mt) == 1 &&
                    !is_null($value) && in_array($value, $assignValues)) {

                    // Se $value è 'no', il tool non è assegnato, elimina il link dalla tabella `employee_personal_tool`.
                    if ($value == 'no') DB::delete('DELETE FROM `employee_personal_tool`' .
                                                    ' WHERE `employee_id` = :empId AND `tool_id` = :toolId ',
                                                   [ 'empId' => $selEmployee, 'toolId' => (int) $mt[1] ]);
                    else {
                        // Utilizza lo statement 'INSERT with ON DUPLICATE KEY UPDATE'.
                        // La PK è (`employee_id`, `tool_id`).
                        $vl = ($value == 'yes') ? 'Y' : 'N';
                        DB::insert('INSERT INTO `employee_personal_tool` (`employee_id`, `tool_id`, `enabled`)' .
                                                      ' VALUES(:empId, :toolId, :enab) AS new' .
                                    ' ON DUPLICATE KEY UPDATE `enabled` = new.`enabled`',
                                   [ 'empId' => $selEmployee, 'toolId' => (int) $mt[1], 'enab' => $vl ]);
                    }
                }
            }
        });

        return AdminPersonalToolsController::getEmployeeTools($selEmployee);
    }
}
