<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class ImpersonatedController extends Controller
{
    public static function getPageAccesses(User $usr): array
    {
        $sql = ($usr->role == 'siteAdmin') ? "'yes' AS `access`" :
                                             "IF(re.`employee_id` IS NULL, 'no', 'yes') AS `access`";

        // Ritorna gli accessi dell'utente corrente (eventualmente impersonato) per ognuna delle pagine
        // di amministrazione (`resource_access`.`resource_type` = 'page').
        $pageAccesses = DB::select("SELECT ra.`name`, $sql" .
                                    ' FROM `resource_access` ra' .
                                    ' LEFT JOIN `res_employee_res_access` re ON re.`resource_access_name` = ra.`name` AND' .
                                                                              ' re.`employee_id` = :emp' .
                                    " WHERE ra.`resource_type` = 'page'", [ 'emp' => $usr->id ]);

        return $pageAccesses;
    }

    public function change(Request $request): JsonResponse
    {
        // Modifica l'id dell'utente impersonato.
        // Vedi metodo authenticate() della classe 'App\Http\Requests\Auth\LoginRequest'.
        // Il middleware App\Http\Middleware\SuperUser assicura che questo controller sia
        // invocato solo se l'utente è un Super User ('siteAdmin'), nel caso in cui la route
        // '/impersonated/change' sia invocata manualmente.
        $usr = $request->user();
        if ($usr->role == 'siteAdmin' && $request->impersonated_id) {
            session(['impersonated-employee' => $request->impersonated_id]);
            $usr = User::find($request->impersonated_id);
        }

        return response()->json([ 'pageAccesses' => ImpersonatedController::getPageAccesses($usr) ]);
    }

    public function index(Request $request): JsonResponse
    {
        $employees = DB::select('SELECT em.`id` AS `employee_id`, em.`customer_id`,' .
                                  " CONCAT(em.`firstname`, ' ', em.`lastname`) AS `employee_name`," .
                                  ' em.`role` AS `employee_role`, cs.`name` AS `customer_name`' .
                             ' FROM `employee` em JOIN `customer` cs ON cs.`id` = em.`customer_id`' .
                             ' ORDER BY `customer_name`, `employee_name`');

        $selEmployee = (int) $request['impersonated-employee'] ?? 0;

        $employeeOpts = ''; $grp = -1; $first = true; $selected = false;

        foreach ($employees as $employee) {
            if ($employee->customer_id != $grp) {
                if (!$first) $employeeOpts .= '</optgroup>';
                $first = false;
                $grp = $employee->customer_id;

                $employeeOpts .= "<optgroup id=\"{$employee->customer_id}\"" .
                                 ' label="' . htmlentities($employee->customer_name, ENT_QUOTES, 'UTF-8') . '">';
            }

            $sel = ($employee->employee_id == $selEmployee) ? ' selected=""' : '';
            if (strlen($sel) > 0) $selected = true;

            $employeeOpts .= "<option value=\"{$employee->employee_id}\" data-te-select-secondary-text=\"" .
                             __('globals.employee-role')[$employee->employee_role] . "\"$sel>" .
                             htmlentities($employee->employee_name, ENT_QUOTES, 'UTF-8') . '</option>';
        }

        if ($grp >= 0) $employeeOpts .= "</optgroup>";

        // Se questo controller è stato invocato dopo un delete di un impiegato, $selected sarà
        // false, vedi funzione updateImpersonatingSelect() nel file "admin.js".
        return response()->json([ 'employees' => $employeeOpts, 'selected' => $selected ]);
    }
}
