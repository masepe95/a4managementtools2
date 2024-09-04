<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class AdminLanguagesController extends Controller
{
    private static function getLanguages($selLanguage): JsonResponse
    {
        // Ritorna tutti i linguaggi attualmente impostati.
        $languages = DB::select('SELECT `code`, `name`, `order` FROM `language` ORDER BY `order`');

        // Se non c'è una selezione corrente ($selLanguage = 0), assumi come nuova selezione
        // la prima row della collection $languages (se esiste).
        if ($selLanguage <= 0) {
            if (count($languages) > 0) $selLanguage = $languages[0]->code;
        }
        else if (count($languages) > 0) {
            // Controlla che il `code` $selLanguage esista nell'array $languages, in caso contrario,
            // assumi il `code` della prima row della collection $languages (avviene durante il cambio
            // dell'Impersonated employee o a causa di una injection).
            $sel = $languages[0]->code;
            foreach ($languages as $lang) {
                if ($lang->code == $selLanguage) {
                    $sel = $selLanguage;
                    break;
                }
            }

            $selLanguage = $sel;
        }

        $languageOpts = ''; $selected = '';

        // Costruisci le <option> delle lingue.
        foreach ($languages as $language) {
            $sel = ($language->code == $selLanguage) ? ' selected=""' : '';
            if (strlen($sel) > 0) $selected = [
                'code' => $language->code,
                'name' => $language->name,
                'order' => $language->order
            ];

            $name = htmlentities($language->name, ENT_QUOTES, 'UTF-8');
            $languageOpts .= "<option value=\"{$language->code}\"$sel>$name</option>";
        }

        return response()->json([ 'languageOpts' => $languageOpts, 'selected' => $selected ]);
    }

    public function index(Request $request): JsonResponse
    {
        $selLanguage = $request['language-names'] ?? 0;

        return AdminLanguagesController::getLanguages($selLanguage);
    }

    public function edit(Request $request): JsonResponse
    {
        $selLanguage = $request['language-names'] ?? 0;

        // Ottieni i codici ISO 639-1 delle lingue supportate.
        $langs = DB::scalar('SELECT GROUP_CONCAT(`code`) FROM `language`');

        $validated = $request->validate([
            'language-code' => "required|in:$langs|size:2",
            'language-name' => 'required|max:32',
            'language-order' => 'required|numeric|min:1',
        ]);

        DB::update('UPDATE `language` SET `code` = :newcode, `name` = :name, `order` = :order WHERE `code` = :code',
                   [ 'newcode' => $validated['language-code'], 'name' => $validated['language-name'],
                     'order' => $validated['language-order'], 'code' => $selLanguage ]);

        return AdminLanguagesController::getLanguages($selLanguage);
    }

    public function add(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'language-code' => 'required|size:2',
            'language-name' => 'required|max:32',
            'language-order' => 'required|numeric|min:1',
        ]);

        $ins = (int) DB::insert('INSERT INTO `language` (`code`, `name`, `order`) VALUE(:code, :name, :order)',
                                [ 'code' => $validated['language-code'], 'name' => $validated['language-name'],
                                  'order' => $validated['language-order'] ]);

        $newId = ($ins > 0) ? $validated['language-code'] : ($request['language-names'] ?? 0);

        return AdminLanguagesController::getLanguages($newId);
    }

    public function delete(Request $request): JsonResponse
    {
        $selLanguage = $request['language-names'] ?? 0;

        $del = DB::delete('DELETE FROM `language` WHERE `code` = :code', [ 'code' => $selLanguage ]);

        return AdminLanguagesController::getLanguages(($del > 0) ? 0 : $selLanguage);
    }
}
