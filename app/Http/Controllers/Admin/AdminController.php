<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public static function getRealUser(Request $request): User
    {
        // Ritorna lo user loggato o l'eventuale user impersonato (se lo user loggato è un 'siteAdmin').
        $usr = $request->user();
        if ($usr->role == 'siteAdmin') {
            $impersonatedId = $request->session()->get('impersonated-employee', $usr->id);
            if ($usr->id != $impersonatedId) $usr = User::find($impersonatedId);
        }

        return $usr;
    }

    public function index(Request $request): View
    {
        $languages = DB::select('SELECT `code`, `name` FROM language ORDER BY `order`');

        $languageList = '';
        foreach ($languages as $value) {
            if (strlen($languageList) > 0) $languageList .= "\f";
            $languageList .= "{$value->code}:{$value->name}";
        }

        $usr = $request->user();
        $impersonates = AdminController::getRealUser($request);
        $users = DB::select('SELECT em.`id` AS `employee_id`, em.`customer_id`,' .
                                  " CONCAT(em.`firstname`, ' ', em.`lastname`) AS `employee_name`," .
                                  ' em.`role` AS `employee_role`, cs.`name` AS `customer_name`,' .
                                  ' cs.customer_type' .
                             ' FROM `employee` em JOIN `customer` cs ON cs.`id` = em.`customer_id`' .
                             ' ORDER BY `customer_name`, `employee_name`');
        $customers = DB::select('SELECT `id`, `name` FROM `customer` ORDER BY `name`');

        $currentLanguage = $request->cookie('current-locale') ? : '';
        $currentImpersonated = $impersonates->id;

        $pgAccesses = [];
        $pageAccesses = ImpersonatedController::getPageAccesses($impersonates);
        foreach ($pageAccesses as $value) $pgAccesses[$value->name] = $value->access;

        return view('admin/admin', [
            'user' => $usr,
            'pageAccesses' => $pgAccesses,
            'allUsers' => $users,
            'allCustomers' => $customers,
            'languages' => $languages,
            'languageList' => $languageList,
            'currentLanguage' => $currentLanguage,
            'currentImpersonated' => $currentImpersonated,
            'userPhoto' => GetImage::getImageInfo($usr->photo_file, 'images/no-user.png'),
        ]);
    }
}
