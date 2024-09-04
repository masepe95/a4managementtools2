<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class AdminToolsTagsController extends Controller
{
    private static function getToolsTags($selTool, $selTag): JsonResponse
    {
        // Ritorna tutti i tools attivi (ritorna un array vuoto se nessun tool è stato trovato).
        $tools = DB::select('SELECT `id`, `name_id`, `title_id`' .
                             ' FROM `tool`' .
                             " WHERE `active` = 'Y'" .
                             ' ORDER BY `id`');

        // Se non c'è una selezione corrente ($selTool = 0), assumi come nuova selezione la prima
        // row della collection $tools (se esiste).
        if ($selTool <= 0) {
            if (count($tools) > 0) $selTool = $tools[0]->id;
        }
        else if (count($tools) > 0) {
            // Controlla che l' `id` $selTool esista nell'array $tools, in caso contrario,
            // assumi l' `id` della prima row della collection $tools (avviene durante il cambio
            // dell'Impersonated employee o a causa di una injection).
            $sel = $tools[0]->id;
            foreach ($tools as $tool) {
                if ($tool->id == $selTool) {
                    $sel = $selTool;
                    break;
                }
            }

            $selTool = $sel;
        }

        $lang = App::getLocale();

        // Ritorna tutti i tags (ritorna un array vuoto se nessuna tag è stata trovata).
        $tags = DB::select('SELECT tg.`tag_id`,' .
                                 ' (SELECT tl.`tag_name` FROM `tag_lang` tl' .
                                    ' JOIN `language` lg ON lg.`code` = tl.`lang_code`' .
                                    ' WHERE tl.`tag_id` = tg.`tag_id`' .
                                    ' ORDER BY IF(tl.`lang_code` = :lang, 0, lg.order) LIMIT 1) AS `tag_name`' .
                            ' FROM `tag` tg' .
                            ' ORDER BY `tag_name`',
                           [ 'lang' => $lang ]);

        // Se non c'è una selezione corrente ($selTag = 0), assumi come nuova selezione la prima
        // row della collection $tags (se esiste).
        if ($selTag <= 0) {
            if (count($tags) > 0) $selTag = $tags[0]->tag_id;
        }
        else if (count($tags) > 0) {
            // Controlla che il `tag_id` $selTag esista nell'array $tags, in caso contrario,
            // assumi il `tag_id` della prima row della collection $tags (avviene durante il
            // cambio dell'Impersonated employee o a causa di una injection).
            $sel = $tags[0]->tag_id;
            foreach ($tags as $tag) {
                if ($tag->tag_id == $selTag) {
                    $sel = $selTag;
                    break;
                }
            }

            $selTag = $sel;
        }


        // Ritorna i tags associati al tool selezionato (ritorna un array vuoto se nessuna associazione è stata trovata).
        $toolTags = DB::select('SELECT `tag_id`, `weight` FROM `tag_tool` WHERE `tool_id` = :tool', [ 'tool' => $selTool ]);
        $toolTagsArr = [];
        foreach ($toolTags as $tag) { $toolTagsArr[$tag->tag_id] = $tag->weight; }

        $totalTags = count($tags);
        $cntTags = count($toolTagsArr);

        // Ritorna i tools associati al tag selezionato (ritorna un array vuoto se nessuna associazione è stata trovata).
        $tagTools = DB::select('SELECT `tool_id`, `weight` FROM `tag_tool` WHERE `tag_id` = :tag', [ 'tag' => $selTag ]);
        $tagToolsArr = [];
        foreach ($tagTools as $tool) { $tagToolsArr[$tool->tool_id] = $tool->weight; }

        $totalTools = count($tools);
        $cntTools = count($tagToolsArr);

        // Testo di informazione per i dropdown "tool-tags-dropdown" e "tag-tools-dropdown".
        $tagsInfo = trans_choice('admin/adm-tools-tags.tag-info', $cntTags, [ 'count' => $cntTags, 'total' => $totalTags]);
        $toolsInfo = trans_choice('admin/adm-tools-tags.tool-info', $cntTools, [ 'count' => $cntTools, 'total' => $totalTools]);


        $toolOpts = ''; $tagToolsOpts = '';
        $weightLabel = htmlentities(__('admin/adm-tools-tags.tag-weight'), ENT_QUOTES, 'UTF-8');

        // Costruisci le <option> per l'associazione Tool => Tags.
        foreach ($tools as $tool) {
            $sel = ($tool->id == $selTool) ? ' selected=""' : '';
            $toolName = htmlentities($tool->name_id . '.' . $tool->title_id, ENT_QUOTES, 'UTF-8');
            $toolOpts .= "<option value=\"{$tool->id}\"$sel>$toolName</option>";

            // Costruisci la lista dei tools associati al tag selezionato.
            $chk = ''; $weightVal = '1.0'; $wDisabled = ' disabled';
            if (array_key_exists($tool->id, $tagToolsArr)) {
                $chk = ' checked=""';
                $weightVal = substr($tagToolsArr[$tool->id] . '.0', 0, 3);
                $wDisabled = '';
            }

            $tagToolsOpts .= '<li class="max-w-full px-4 py-2 hover:bg-neutral-100">' .
                               '<div class="grid grid-cols-[max(65%)_1fr_auto] gap-x-2"><div class="flex items-center">' .
                                 "<input id=\"tag-tools-{$tool->id}\" name=\"tag-tools-{$tool->id}\" type=\"checkbox\" value=\"on\" class=\"tools-tags-check\"$chk />" .
                                 "<label for=\"tag-tools-{$tool->id}\" class=\"inline-block ps-[0.15rem] whitespace-nowrap overflow-x-hidden text-ellipsis hover:cursor-pointer\">" .
                                 $toolName . '</label></div><div>&nbsp;</div>' .
                                 '<div class="flex items-center">' .
                                   "<span class=\"text-sm pr-[6px]\">$weightLabel</span>" .
                                   "<input type=\"range\" id=\"tool-weight-{$tool->id}\" name=\"tool-weight-{$tool->id}\" value=\"$weightVal\" min=\"0.1\" max=\"1\" step=\"0.1\" class=\"tag-weight-range\"$wDisabled />" .
                                   "<label for=\"tool-weight-{$tool->id}\" class=\"w-8 text-center inline-block text-sm text-neutral-700 dark:text-neutral-200\">" .
                                   $weightVal . '</label></div></div></li>';
        }


        $tagOpts = ''; $toolTagsOpts = '';

        // Costruisci le <option> per l'associazione Tag => Tools.
        foreach ($tags as $tag) {
            $sel = ($tag->tag_id == $selTag) ? ' selected=""' : '';
            $tagName = htmlentities($tag->tag_name, ENT_QUOTES, 'UTF-8');
            $tagOpts .= "<option value=\"{$tag->tag_id}\"$sel>$tagName</option>";

            // Costruisci la lista dei tags associati al tool selezionato.
            $chk = ''; $weightVal = '1.0'; $wDisabled = ' disabled';
            if (array_key_exists($tag->tag_id, $toolTagsArr)) {
                $chk = ' checked=""';
                $weightVal = substr($toolTagsArr[$tag->tag_id] . '.0', 0, 3);
                $wDisabled = '';
            }

            $toolTagsOpts .= '<li class="max-w-full px-4 py-2 hover:bg-neutral-100">' .
                               '<div class="grid grid-cols-[max(65%)_1fr_auto] gap-x-2"><div class="flex items-center">' .
                                 "<input id=\"tool-tags-{$tag->tag_id}\" name=\"tool-tags-{$tag->tag_id}\" type=\"checkbox\" value=\"on\" class=\"tools-tags-check\"$chk />" .
                                 "<label for=\"tool-tags-{$tag->tag_id}\" class=\"inline-block ps-[0.15rem] whitespace-nowrap overflow-x-hidden text-ellipsis hover:cursor-pointer\">" .
                                 $tagName . '</label></div><div>&nbsp;</div>' .
                                 '<div class="flex items-center">' .
                                   "<span class=\"text-sm pr-[6px]\">$weightLabel</span>" .
                                   "<input type=\"range\" id=\"tag-weight-{$tag->tag_id}\" name=\"tag-weight-{$tag->tag_id}\" value=\"$weightVal\" min=\"0.1\" max=\"1\" step=\"0.1\" class=\"tag-weight-range\"$wDisabled />" .
                                   "<label for=\"tag-weight-{$tag->tag_id}\" class=\"w-8 text-center inline-block text-sm text-neutral-700 dark:text-neutral-200\">" .
                                   $weightVal . '</label></div></div></li>';
        }

        return response()->json([ 'toolOpts' => $toolOpts, 'tagOpts' => $tagOpts,
                                  'toolTagsOpts' => $toolTagsOpts, 'tagToolsOpts' => $tagToolsOpts,
                                  'tagsInfo' => $tagsInfo, 'toolsInfo' => $toolsInfo ]);
    }

    public function index(Request $request): JsonResponse
    {
        $selTool = (int) $request['tool-to-tag-names'] ?? 0;
        $selTag = (int) $request['tag-to-tool-names'] ?? 0;

        return AdminToolsTagsController::getToolsTags($selTool, $selTag);
    }

    public function saveTool(Request $request): JsonResponse
    {
        // Il valore di $selTag serve solo come parametro di getToolsTags().
        $selTool = (int) $request['tool-to-tag-names'] ?? 0;
        $selTag = (int) $request['tag-to-tool-names'] ?? 0;

        // Salva i tags associati al tool selezionato.
        DB::transaction(function() use ($request, $selTool) {
            // Elimina tutte le references dei tags associati al tool $selTool.
            DB::delete('DELETE FROM `tag_tool` WHERE `tool_id` = :tool', [ 'tool' => $selTool ]);

            // Itera le variabili di POST e assumi i dati di assegnazione dei tags per il tool $selTool.
            $post = $request->post();
            foreach ($post as $key => $value) {
                // Assumi solo le variabili 'tool-tags-X' e 'tag-weight-X'.
                // Formato:
                //   tool-tags-X   =>  'on'
                //   tag-weight-X  =>  weightValue
                if (preg_match('/^tool-tags-(\d+)$/', $key, $mt) == 1 &&
                    $value === 'on' && array_key_exists("tag-weight-{$mt[1]}", $post)) {

                    $tagId = (int) $mt[1];
                    $weight = $post["tag-weight-$tagId"];

                    DB::insert('INSERT INTO `tag_tool` (`tag_id`, `tool_id`, `weight`)' .
                                               ' VALUES(:tagId, :toolId, :weight)',
                               [ 'tagId' => $tagId, 'toolId' => $selTool, 'weight' => $weight ]);
                }
            }
        });

        return AdminToolsTagsController::getToolsTags($selTool, $selTag);
    }

    public function saveTag(Request $request): JsonResponse
    {
        // Il valore di $selTool serve solo come parametro di getToolsTags().
        $selTool = (int) $request['tool-to-tag-names'] ?? 0;
        $selTag = (int) $request['tag-to-tool-names'] ?? 0;

        // Salva i tools associati al tag selezionato.
        DB::transaction(function() use ($request, $selTag) {
            // Elimina tutte le references dei tools associati al tag $selTag.
            DB::delete('DELETE FROM `tag_tool` WHERE `tag_id` = :tag', [ 'tag' => $selTag ]);

            // Itera le variabili di POST e assumi i dati di assegnazione dei tools per il tag $selTag.
            $post = $request->post();
            foreach ($post as $key => $value) {
                // Assumi solo le variabili 'tag-tools-X' e 'tool-weight-X'.
                // Formato:
                //   tag-tools-X    =>  'on'
                //   tool-weight-X  =>  weightValue
                if (preg_match('/^tag-tools-(\d+)$/', $key, $mt) == 1 &&
                    $value === 'on' && array_key_exists("tool-weight-{$mt[1]}", $post)) {

                    $toolId = (int) $mt[1];
                    $weight = $post["tool-weight-$toolId"];

                    DB::insert('INSERT INTO `tag_tool` (`tag_id`, `tool_id`, `weight`)' .
                                               ' VALUES(:tagId, :toolId, :weight)',
                               [ 'tagId' => $selTag, 'toolId' => $toolId, 'weight' => $weight ]);
                }
            }
        });

        return AdminToolsTagsController::getToolsTags($selTool, $selTag);
    }
}
