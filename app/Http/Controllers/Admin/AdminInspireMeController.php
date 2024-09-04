<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class AdminInspireMeController extends Controller
{
    private static function getInspireMe(): JsonResponse
    {
        // Ritorna tutti gli impiegati.
        $inspireMe = DB::select('SELECT `lang_code`, `entries` FROM `inspire_me`');

        return response()->json([ 'inspireMe' => $inspireMe ]);
    }

    public function index(Request $request): JsonResponse
    {
        return AdminInspireMeController::getInspireMe();
    }

    public function store(Request $request): JsonResponse
    {
        // Esegui una transazione per modificare la tabella `inspire_me`.
        DB::transaction(function() use ($request) {
            $languages = DB::select('SELECT `code` FROM `language`');
            foreach ($languages as $language) {
                $key = 'inspire-me-' . $language->code;
                if (isset($request[$key]) && !is_null($request[$key])) {
                    // Utilizza lo statement 'INSERT with ON DUPLICATE KEY UPDATE'.
                    // La PK è (`lang_code`).
                    DB::insert('INSERT INTO `inspire_me` (`lang_code`, `entries`)' .
                                                 ' VALUES(:lang, :entries) AS new' .
                                ' ON DUPLICATE KEY UPDATE `entries` = new.`entries`',
                               [ 'lang' => $language->code, 'entries' => $request[$key] ]);
                }
                else {
                    // La lingua $language->code non è impostata, elimina l'eventuale entry dal DB.
                    DB::delete('DELETE FROM `inspire_me` WHERE `lang_code` = :lang',
                               [ 'lang' => $language->code ]);
                }
            }
        });

        return AdminInspireMeController::getInspireMe();
    }
}
