<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AdminToolsController extends Controller
{
    private static function getMultiSelectRegs(): Array
    {
        // Ritorna gli enumerativi e set delle colonne con il nome che inizia per 'cat_'.
        $sets = DB::select("SHOW COLUMNS FROM `tool` LIKE 'cat_%'");

        $setStrings = [];

        foreach ($sets as $set) {
            // RegExp: ^(set|enum)\((['"])([^\)]+)\2\)$
            if (preg_match("/^(set|enum)\\((['\"])([^\\)]+)\\2\\)$/", $set->Type, $mt) === 1) {
                // Se la colonna è un "enum", ritorna in una stringa la lista di enum separata dal carattere virgola.
                //   enum1,enum2, ...
                // Se la colonna è un "set", ritorna la seguente RegExp:
                //   Pattern: /^(?:(?:enum1|enum2| ...),?)+(?<!,)$/
                $setStrings[$set->Field] = ($mt[1] == 'enum') ? str_replace("','", ',', $mt[3]) :
                                                                '/^(?:(?:' . str_replace("','", '|', $mt[3]) . '),?)+(?<!,)$/';
            }
        }

        return $setStrings;
    }

    private static function getTools($selTool, $reloadToolNames): JsonResponse
    {
        // Ritorna tutti i tools (ritorna un array vuoto se nessun tool è stato trovato).
        $tools = DB::select('SELECT * FROM `tool` ORDER BY `id`');

        // Se non c'è una selezione corrente ($selTool = 0), assumi come nuova
        // selezione la prima row della collection $tools (se esiste).
        if ($selTool <= 0) {
            if (count($tools) > 0) $selTool = $tools[0]->id;
        }
        else if (count($tools) > 0) {
            // Controlla che l' `id` $selTool esista nell'array $tools, in caso contrario, assumi il
            // `tag_id` della prima row della collection $tools (avviene durante il cambio dell'Impersonated
            // employee o a causa di una injection).
            $sel = $tools[0]->id;
            foreach ($tools as $tool) {
                if ($tool->id == $selTool) {
                    $sel = $selTool;
                    break;
                }
            }

            $selTool = $sel;
        }

        // Ritorna i tools che sono relazionati con ial tool selezionato (ritorna un array vuoto se nessuna relazione è stata trovata).
        $relateds = DB::select('SELECT * FROM `related_tools` WHERE `source_tool` = :id', [ 'id' => $selTool ]);
        $relatedsArr = [];
        foreach ($relateds as $related) { $relatedsArr[] = $related->related_tool; }

        $toolOpts = ''; $relatedOpts = ''; $selected = '';
        $inactive = ' (' . __('admin/adm-tools.tool-inactive') . ')';

        // Costruisci le <option> della lista di tools.
        foreach ($tools as $tool) {
            $sel = ($tool->id == $selTool) ? ' selected=""' : '';
            if (strlen($sel) > 0) $selected = [
                'name_id' => $tool->name_id,
                'title_id' => $tool->title_id,
                'cat_levels' => $tool->cat_levels,
                'cat_recipients' => $tool->cat_recipients,
                'cat_usages' => $tool->cat_usages,
                'cat_selections' => $tool->cat_selections,
                'cat_scopes' => $tool->cat_scopes,
                'active' => $tool->active
            ];

            $name = htmlentities($tool->name_id . '.' . $tool->title_id, ENT_QUOTES, 'UTF-8');
            if ($tool->active != 'Y') $name .= $inactive;
            $toolOpts .= "<option value=\"{$tool->id}\"$sel>$name</option>";

            $rel = (in_array($tool->id, $relatedsArr)) ? ' selected=""' : '';
            if ($sel == '') $relatedOpts .= "<option value=\"{$tool->id}\"$rel>$name</option>";
        }

        return response()->json([ 'toolOpts' => ($reloadToolNames) ? $toolOpts : "",
                                  'selected' => $selected,
                                  'relatedOpts' => $relatedOpts, 'reloaded' => $reloadToolNames ]);
    }

    public function index(Request $request): JsonResponse
    {
        $selTool = (int) $request['tools-tool-list'] ?? 0;
        $reloadToolNames = $request['reload-tool-names'] ?? 'yes';

        return AdminToolsController::getTools($selTool, $reloadToolNames == 'yes');
    }

    public function edit(Request $request): JsonResponse
    {
        $selTool = (int) $request['tools-tool-list'] ?? 0;
        $regs = AdminToolsController::getMultiSelectRegs();

        // Nota: le RegExp ritornate nell'array $regs contengono il carattere pipe (|) che è riservato
        //       come carattere separatore delle rules, specifica le rules con un array per evitare l'errore:
        //         preg_match(): No ending delimiter '/' found
        $selValidated = Validator::make([ 'cat-levels' => implode(',', $request['tools-category-level']),
                                          'cat-recipients' => implode(',', $request['tools-category-recipient']),
                                          'cat-usages' => implode(',', $request['tools-category-usage']),
                                          'cat-selections' => implode(',', $request['tools-category-selection']),
                                          'cat-scopes' => $request['tools-category-scope'] ],  // End of data.
                                        [ 'cat-levels' => [ 'required', "regex:{$regs['cat_levels']}" ],
                                          'cat-recipients' => [ 'required', "regex:{$regs['cat_recipients']}" ],
                                          'cat-usages' => [ 'required', "regex:{$regs['cat_usages']}" ],
                                          'cat-selections' => [ 'nullable', "regex:{$regs['cat_selections']}" ],
                                          'cat-scopes' => "required|in:{$regs['cat_scopes']}" ],  // End of rules.
                                        [],  // End of messages.
                                        [ 'cat-levels' => '«' . __('admin/adm-tools.tool-level') . '»',
                                          'cat-recipients' => '«' . __('admin/adm-tools.tool-recipient') . '»',
                                          'cat-usages' => '«' . __('admin/adm-tools.tool-usage') . '»',
                                          'cat-selections' => '«' . __('admin/adm-tools.tool-selection') . '»',
                                          'cat-scopes' => '«' . __('admin/adm-tools.tool-scope') . '»' ]  // End of attributes.
                                       )->validate();

        $validated = $request->validate([
            // La prima RegExp contiene il carattere 'pipe' (|) che è riservato come carattere
            // separatore delle rules, specifica le rules con un array per evitare l'errore:
            //   preg_match(): No ending delimiter '/' found
            'tools-name-id' => [ 'required', 'regex:/^A4(?!000$|0000)\\d{3,4}$/', 'max:8' ],
            'tools-title-id' => 'required|regex:/^[A-Za-z]+$/|max:64',
            'tools-active' => 'nullable|in:on',
            'tools-related-tools' => 'nullable|array',
        ]);

        // Esegui una transazione per modificare le tabelle `tool` e `related_tools`.
        DB::transaction(function() use ($selTool, $validated, $selValidated) {
            $active = $validated['tools-active'] ?? 'N';
            if ($active == 'on') $active = 'Y';

            DB::update('UPDATE `tool`' .
                        ' SET `name_id` = :nameId, `title_id` = :titleId, `active` = :active,' .
                            ' `cat_levels` = :catLevels, `cat_recipients` = :catRecipients, `cat_usages` = :catUsages,' .
                            ' `cat_selections` = :catSelections, `cat_scopes` = :catScopes' .
                        ' WHERE `id` = :id',
                       [ 'nameId' => $validated['tools-name-id'], 'titleId' => $validated['tools-title-id'], 'active' => $active,
                         'catLevels' => $selValidated['cat-levels'], 'catRecipients' => $selValidated['cat-recipients'],
                         'catUsages' => $selValidated['cat-usages'], 'catSelections' => $selValidated['cat-selections'],
                         'catScopes' => $selValidated['cat-scopes'], 'id' => $selTool ]);

            // Elimina tutti i tool relazionati al tool $selTag.
            DB::delete('DELETE FROM `related_tools` WHERE `source_tool` = :src', [ 'src' => $selTool ]);

            // Inserisci i nuovi tool relazionati al tool $selTag.
            $relared = $validated['tools-related-tools'] ?? [];
            foreach ($relared as $tool) {
                DB::insert('INSERT INTO `related_tools` (`source_tool`, `related_tool`)' .
                                                 ' VALUE(:src, :related)',
                           [ 'src' => $selTool, 'related' => $tool ]);
            }
        });

        return AdminToolsController::getTools($selTool, true);
    }

    public function add(Request $request): JsonResponse
    {
        $regs = AdminToolsController::getMultiSelectRegs();

        // Nota: le RegExp ritornate nell'array $regs contengono il carattere pipe (|) che è riservato
        //       come carattere separatore delle rules, specifica le rules con un array per evitare l'errore:
        //         preg_match(): No ending delimiter '/' found
        $selValidated = Validator::make([ 'cat-levels' => implode(',', $request['tools-category-level']),
                                          'cat-recipients' => implode(',', $request['tools-category-recipient']),
                                          'cat-usages' => implode(',', $request['tools-category-usage']),
                                          'cat-selections' => implode(',', $request['tools-category-selection']),
                                          'cat-scopes' => $request['tools-category-scope'] ],  // End of data.
                                        [ 'cat-levels' => [ 'required', "regex:{$regs['cat_levels']}" ],
                                          'cat-recipients' => [ 'required', "regex:{$regs['cat_recipients']}" ],
                                          'cat-usages' => [ 'required', "regex:{$regs['cat_usages']}" ],
                                          'cat-selections' => [ 'nullable', "regex:{$regs['cat_selections']}" ],
                                          'cat-scopes' => "required|in:{$regs['cat_scopes']}" ],  // End of rules.
                                        [],  // End of messages.
                                        [ 'cat-levels' => '«' . __('admin/adm-tools.tool-level') . '»',
                                          'cat-recipients' => '«' . __('admin/adm-tools.tool-recipient') . '»',
                                          'cat-usages' => '«' . __('admin/adm-tools.tool-usage') . '»',
                                          'cat-selections' => '«' . __('admin/adm-tools.tool-selection') . '»',
                                          'cat-scopes' => '«' . __('admin/adm-tools.tool-scope') . '»' ]  // End of attributes.
                                       )->validate();

        $validated = $request->validate([
            // La prima RegExp contiene il carattere 'pipe' (|) che è riservato come carattere
            // separatore delle rules, specifica le rules con un array per evitare l'errore:
            //   preg_match(): No ending delimiter '/' found
            'tools-name-id' => [ 'required', 'regex:/^A4(?!000$|0000)\\d{3,4}$/', 'max:8' ],
            'tools-title-id' => 'required|regex:/^[A-Za-z]+$/|max:64',
            'tools-active' => 'nullable|in:on',
            'tools-related-tools' => 'nullable|array',
        ]);

        // L'id deve corrispondere al valore del 'name-id' seguente al prefisso "A4".
        $selTool = (int) substr($validated['tools-name-id'], 2);

        // Esegui una transazione per modificare le tabelle `tool` e `related_tools`.
        DB::transaction(function() use ($selTool, $validated, $selValidated) {
            $active = $validated['tools-active'] ?? 'N';
            if ($active == 'on') $active = 'Y';

            DB::insert('INSERT INTO `tool`' .
                        ' (`id`, `name_id`, `title_id`, `cat_levels`, `cat_recipients`,' .
                         ' `cat_usages`, `cat_selections`, `cat_scopes`, `active`)' .
                         ' VALUE(:id, :nameId, :titleId, :catLevels, :catRecipients,' .
                               ' :catUsages, :catSelections, :catScopes, :active)',
                       [ 'id' => $selTool, 'nameId' => $validated['tools-name-id'], 'titleId' => $validated['tools-title-id'],
                         'catLevels' => $selValidated['cat-levels'], 'catRecipients' => $selValidated['cat-recipients'],
                         'catUsages' => $selValidated['cat-usages'], 'catSelections' => $selValidated['cat-selections'],
                         'catScopes' => $selValidated['cat-scopes'], 'active' => $active ]);

            // Elimina tutti i tool relazionati al tool $selTag.
            DB::delete('DELETE FROM `related_tools` WHERE `source_tool` = :src', [ 'src' => $selTool ]);

            // Inserisci i nuovi tool relazionati al tool $selTag.
            $relared = $validated['tools-related-tools'] ?? [];
            foreach ($relared as $tool) {
                DB::insert('INSERT INTO `related_tools` (`source_tool`, `related_tool`)' .
                                                 ' VALUE(:src, :related)',
                           [ 'src' => $selTool, 'related' => $tool ]);
            }
        });

        return AdminToolsController::getTools($selTool, true);
    }

    public function delete(Request $request): JsonResponse
    {
        $selTool = (int) $request['tools-tool-list'] ?? 0;
        $reloadTagNames = $request['reload-tag-names'] ?? 'yes';

        $del = DB::delete('DELETE FROM `tool` WHERE `id` = :id', [ 'id' => $selTool ]);

        return AdminToolsController::getTools(($del > 0) ? 0 : $selTool, $del > 0);
    }
}
