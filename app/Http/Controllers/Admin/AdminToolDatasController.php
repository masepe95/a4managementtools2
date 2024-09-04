<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class AdminToolDatasController extends Controller
{
    private static function getToolDatas($selTool, $selLang, $reloadToolNames): JsonResponse
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

        // Ritorna tutti i dati del tool selezionato e nella lingua selezionata.
        $datas = DB::select('SELECT * FROM `tool_lang_data` WHERE `id` = :tool AND `lang` = :lang',
                            [ 'tool' => $selTool, 'lang' => $selLang ]);

        if (count($datas) === 1) $datas = $datas[0];

        $dts = [];
        foreach ($datas as $key => $value) {
            if ($key != 'id' && $key != 'lang') $dts[$key] = $value;
        }

        $toolOpts = '';
        $inactive = ' (' . __('admin/adm-tools.tool-inactive') . ')';

        // Costruisci le <option> della lista di tools.
        foreach ($tools as $tool) {
            $sel = ($tool->id == $selTool) ? ' selected=""' : '';

            $name = htmlentities($tool->name_id . '.' . $tool->title_id, ENT_QUOTES, 'UTF-8');
            if ($tool->active != 'Y') $name .= $inactive;
            $toolOpts .= "<option value=\"{$tool->id}\"$sel>$name</option>";
        }

        return response()->json([ 'toolOpts' => ($reloadToolNames) ? $toolOpts : '',
                                  'reloaded' => $reloadToolNames, 'datas' => $dts ]);
    }

    public function index(Request $request): JsonResponse
    {
        $selTool = (int) $request['tool-datas-tool'] ?? 0;
        $selLang = $request['tool-datas-lang'] ?? '';
        $reloadToolNames = $request['reload-tool-names'] ?? 'yes';

        return AdminToolDatasController::getToolDatas($selTool, $selLang, $reloadToolNames == 'yes');
    }

    public function store(Request $request): JsonResponse
    {
        $selTool = (int) $request['tool-datas-tool'] ?? 0;
        $selLang = $request['tool-datas-lang'] ?? '';
        $reloadToolNames = $request['reload-tool-names'] ?? 'yes';

        $cols = [
            [ 'col' => 'alphabetical_index', 'name' => 'data-alphabetical-index' ],
            [ 'col' => 'sub_title', 'name' => 'data-subtitle' ],
            [ 'col' => 'introduction', 'name' => 'data-introduction' ],
            [ 'col' => 'presentation', 'name' => 'data-presentation' ],
            [ 'col' => 'potential', 'name' => 'data-potential' ],
            [ 'col' => 'solved_problem', 'name' => 'data-solved-problem' ],
            [ 'col' => 'instructions', 'name' => 'data-instructions-for-use' ],
            [ 'col' => 'advanced_techniques', 'name' => 'data-advanced-techniques' ],
            [ 'col' => 'risks_and_remedies', 'name' => 'data-risks-and-remedies' ],
            [ 'col' => 'mistakes', 'name' => 'data-mistakes' ],
            [ 'col' => 'insight_1', 'name' => 'data-insight-1' ],
            [ 'col' => 'insight_2', 'name' => 'data-insight-2' ],
            [ 'col' => 'insight_3', 'name' => 'data-insight-3' ],
            [ 'col' => 'insight_4', 'name' => 'data-insight-4' ],
            [ 'col' => 'insight_5', 'name' => 'data-insight-5' ],
            [ 'col' => 'provocation_1', 'name' => 'data-provocation-1' ],
            [ 'col' => 'provocation_2', 'name' => 'data-provocation-2' ],
            [ 'col' => 'opportunities', 'name' => 'data-opportunities' ],
            [ 'col' => 'key_results', 'name' => 'data-key-results' ],
        ];

        $dts = []; $bDelete = true;

        // Costruisci l'array con le nuove stringhe per tutte le colonne della tabella `tool_lang_data`.
        foreach ($cols as $data) {
            $vl = $request[$data['name']] ?? '';
            if ($bDelete && strlen($vl) > 0) $bDelete = false;

            $dts[$data['col']] = $vl;
        }

        // Esegui una transazione per modificare la tabella `tool_lang_data`.
        DB::transaction(function() use ($selTool, $selLang, $dts, $bDelete) {
            if ($bDelete) {
                // Elimina la row del tool e lingua selezionate se tutte le colonne sono empty.
                DB::delete('DELETE FROM `tool_lang_data` WHERE `id` = :tool AND `lang` = :lang',
                           [ 'tool' => $selTool, 'lang' => $selLang ]);
            }
            else {
                // Utilizza lo statement 'INSERT with ON DUPLICATE KEY UPDATE'.
                // La PK è (`id`, `lang`).
                $sql = 'INSERT INTO `tool_lang_data` (`id`,`lang`,`alphabetical_index`,`sub_title`,`introduction`,';
                $sql .= '`presentation`,`potential`,`solved_problem`,`instructions`,`advanced_techniques`,';
                $sql .= '`risks_and_remedies`,`mistakes`,`insight_1`,`insight_2`,`insight_3`,`insight_4`,';
                $sql .= '`insight_5`,`provocation_1`,`provocation_2`,`opportunities`,`key_results`) ';
                $sql .= 'VALUES(:id,:lang,:alpha,:subTitle,:introduction,:presentation,:potential,';
                $sql .= ':solved,:instructions,:advanced,:risks,:mistakes,:insight_1,:insight_2,:insight_3,';
                $sql .= ':insight_4,:insight_5,:provocation_1,:provocation_2,:opportunities,:key_results) AS new ';
                $sql .= 'ON DUPLICATE KEY UPDATE `alphabetical_index`=new.`alphabetical_index`,`sub_title`=new.`sub_title`,';
                $sql .= '`introduction`=new.`introduction`,`presentation`=new.`presentation`,`potential`=new.`potential`,';
                $sql .= '`solved_problem`=new.`solved_problem`,`instructions`=new.`instructions`,';
                $sql .= '`advanced_techniques`=new.`advanced_techniques`,`risks_and_remedies`=new.`risks_and_remedies`,';
                $sql .= '`mistakes`=new.`mistakes`,`insight_1`=new.`insight_1`,`insight_2`=new.`insight_2`,';
                $sql .= '`insight_3`=new.`insight_3`,`insight_4`=new.`insight_4`,`insight_5`=new.`insight_5`,';
                $sql .= '`provocation_1`=new.`provocation_1`,`provocation_2`=new.`provocation_2`,';
                $sql .= '`opportunities`=new.`opportunities`,`key_results`=new.`key_results`';

                DB::insert($sql,
                           [ 'id' => $selTool, 'lang' => $selLang, 'alpha' => $dts['alphabetical_index'],
                             'subTitle' => $dts['sub_title'], 'introduction' => $dts['introduction'],
                             'presentation' => $dts['presentation'], 'potential' => $dts['potential'],
                             'solved' => $dts['solved_problem'], 'instructions' => $dts['instructions'],
                             'advanced' => $dts['advanced_techniques'], 'risks' => $dts['risks_and_remedies'],
                             'mistakes' => $dts['mistakes'], 'insight_1' => $dts['insight_1'], 'insight_2' => $dts['insight_2'],
                             'insight_3' => $dts['insight_3'], 'insight_4' => $dts['insight_4'], 'insight_5' => $dts['insight_5'],
                             'provocation_1' => $dts['provocation_1'], 'provocation_2' => $dts['provocation_2'],
                             'opportunities' => $dts['opportunities'], 'key_results' => $dts['key_results']
                           ]);
            }
        });

        return AdminToolDatasController::getToolDatas($selTool, $selLang, $reloadToolNames == 'yes');
    }
}
