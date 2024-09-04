<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class AdminLogsController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        // log-customers
        // log-employees
        // log-actions ('login', 'fail', 'failUnknown', 'toolOpen', 'toolCreate', 'toolSearch')
        // log-sorting ('datetime', 'datetime_desc', 'action', 'action_desc', 'employee', 'employee_desc', 'customer', 'customer_desc')
        $logCustomers = $request['log-customers'] ?? 0;
        $logEmployees = $request['log-employees'] ?? 0;
        $logActions = $request['log-actions'] ?? '';
        $logSorting = $request['log-sorting'] ?? '';

        return response()->json([  ]);
    }
}
