<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;

class AdminTagsController extends Controller
{
    private static function getTags($selTag, $reloadTagNames): JsonResponse
    {
        // Ritorna tutti i tags e i propri nomi multilingua (ritorna un array vuoto se nessun tag è stato trovato).
        // Se $reloadTagNames è false, ritorna solo il tag selezionato.
        // Nota: ordina i nomi dei tags per `order` della lingua, se il nome nella lingua corrente non è
        //       specificato, assumi il nome della lingua più prioritaria (tra quelle specificate).
        //       La scelta della lingua viene effettuata nel ciclo foreach($tags as $tag).
        // Nota: il valore di $selTag è un integer, quindi è sicuro, il binding non è necessario.
        //
        // Nota: la clausola ORDER BY controlla se nella colonna `names` c'è il nome del tag nella lingua corrente.
        //       Se la lingua esiste, ordina per quella stringa (seguente a 'en:', 'it:' ecc.).
        //       Altrimenti, ordina per la prima lingua di `names`(ordinate per priorità).
        // Nota: un eventuale nome in un'altra lingua, seguente al nome con cui si esegue l'ordinamento,
        //       non influenza l'ordinamento stesso grazie al separator '\f' (codice ASCII 12).

        // Aumenta il numero massimo di caratteri (default = 1024) concatenabili della funzione aggregata GROUP_CONCAT().
        DB::statement('SET SESSION group_concat_max_len = 1048576');  // 1 MB.

        $cl = App::getLocale();
        $where = ($reloadTagNames) ? '' : " WHERE tg.`tag_id` = :id";
        $binds = ($reloadTagNames) ? [] : [ 'id' => $selTag ];
        $tags = DB::select('SELECT tg.`tag_id`,' .
                                 " GROUP_CONCAT(tl.`lang_code`, ':', tl.`tag_name` ORDER BY lg.`order` SEPARATOR '\f') AS `names`" .
                            ' FROM `tag` tg LEFT JOIN `tag_lang` tl ON tl.`tag_id` = tg.`tag_id`' .
                            " LEFT JOIN `language` lg ON lg.`code` = tl.`lang_code`$where" .
                            ' GROUP BY tg.`tag_id`' .
                            " ORDER BY IF(POSITION('$cl:' IN `names`) > 0," .  // Controlla se esiste un nome nella lingua corrente.
                                        " SUBSTR(`names`, POSITION('$cl:' IN `names`) + 3)," .  // Ordina per la lingia corrente.
                                        ' SUBSTR(`names`, 4))', $binds);  // Ordina per la lingua prioritaria (la prima di `names`).

        // Se non c'è una selezione corrente ($selTag = 0), assumi come nuova
        // selezione la prima row della collection $tags (se esiste).
        if ($selTag <= 0) {
            if (count($tags) > 0) $selTag = $tags[0]->tag_id;
        }
        else if (count($tags) > 0) {
            // Controlla che il `tag_id` $selTag esista nell'array $tags, in caso contrario, assumi il
            // `tag_id` della prima row della collection $tags (avviene durante il cambio dell'Impersonated
            // employee o a causa di una injection).
            $sel = $tags[0]->tag_id;
            foreach ($tags as $tag) {
                if ($tag->tag_id == $selTag) {
                    $sel = $selTag;
                    break;
                }
            }

            $selTag = $sel;
        }

        $tagOpts = ''; $selected = '';
        $currLang = App::getLocale();

        foreach ($tags as $tag) {
            $sel = ($tag->tag_id == $selTag) ? ' selected=""' : '';
            if (strlen($sel) > 0) $selected = $tag->names ?? '';

            // Esplodi i nomi del tag corrente nelle lingue presenti.
            $langs = []; $firstLang = -1;
            $names = (is_null($tag->names)) ? [] : explode("\f", $tag->names);
            foreach ($names as $name) {
                // Aggiungi la entry corrente, esempio:
                //   $langs["en"] = "tagName";
                $lang = explode(":", $name);
                $langs[$lang[0]] = $lang[1];
                if ($firstLang === -1) $firstLang = $lang[0];
            }

            // Se il tag corrente ha un nome nella lingua corrente, assumino come nome visulizzato nel
            // <select#tag-tool-names>, altrimenti, assumi la prima lingua dell'array $langs.
            // L'array $langs risulta ordinato per priorità di lingue (vedi GROUP_CONCAT() della query precedente).
            $name = (array_key_exists($currLang, $langs)) ? $langs[$currLang] : ((count($langs) > 0) ? $langs[$firstLang] : '');
            $name = htmlentities($name, ENT_QUOTES, 'UTF-8');
            $tagOpts .= "<option value=\"{$tag->tag_id}\"$sel>$name</option>";
        }

        return response()->json([ 'tagOpts' => $tagOpts, 'selectedTag' => $selected, 'reloaded' => $reloadTagNames ]);
    }

    public function index(Request $request): JsonResponse
    {
        $selTag = (int) $request['tag-tool-names'] ?? 0;
        $reloadTagNames = $request['reload-tag-names'] ?? 'yes';

        return AdminTagsController::getTags($selTag, $reloadTagNames == 'yes');
    }

    public function edit(Request $request): JsonResponse
    {
        $selTag = (int) $request['tag-tool-names'] ?? 0;
        $reloadTagNames = $request['reload-tag-names'] ?? 'yes';

        // Ottieni i codici ISO 639-1 delle lingue supportate.
        $langs = DB::scalar('SELECT GROUP_CONCAT(`code`) FROM `language`');

        // Esegui una transazione per modificare la tabella `tag_lang`.
        DB::transaction(function() use ($request, $selTag, $langs) {
            // Elimina tutti i nomi multilingua del tag $selTag.
            DB::delete('DELETE FROM `tag_lang` WHERE `tag_id` = :tag', [ 'tag' => $selTag ]);

            // Inserisci i nuovi nomi multilingua.
            foreach ($request->post() as $key => $value) {
                // Assumi solo le variabili non null e con il language-code.
                // Nota: non serve controllare il language-code, se invalido, fallirà a causa della FK
                //       che referenzia la tabella `language`.
                if (!is_null($value) && preg_match("/^tag-name-([a-z]{2})$/", $key, $mt) === 1) {
                    $vld = $request->validate([ $key => 'required|max:255' ]);

                    DB::insert('INSERT INTO `tag_lang` (`tag_id`, `lang_code`, `tag_name`)' .
                                                ' VALUE(:id, :lang, :name)',
                               [ 'id' => $selTag, 'lang' => $mt[1], 'name' => $vld[$key] ]);
                }
            }
        });

        return AdminTagsController::getTags($selTag, $reloadTagNames == 'yes');
    }

    public function add(Request $request): JsonResponse
    {
        $selTag = 0;
        $reloadTagNames = $request['reload-tag-names'] ?? 'yes';

        // Ottieni i codici ISO 639-1 delle lingue supportate.
        $langs = DB::scalar('SELECT GROUP_CONCAT(`code`) FROM `language`');

        // Esegui una transazione per modificare la tabella `tag_lang`.
        DB::transaction(function() use ($request, &$selTag, $langs) {
            // Inserisci un nuovo tag (genera l'id tramite AUTO_INCREMENT).
            DB::insert('INSERT INTO `tag` () VALUES ()');

            // Ottiene l'id auto_increment appena inserito.
            $selTag = (int) DB::getPdo()->lastInsertId();

            // Popola l'array $values con i nuovi nomi multilingua.
            $values = [];
            foreach ($request->post() as $key => $value) {
                // Assumi solo le variabili non null e con il language-code.
                // Nota: non serve controllare il language-code, se invalido, fallirà a causa della FK
                //       che referenzia la tabella `language`.
                if (!is_null($value) && preg_match("/^tag-name-([a-z]{2})$/", $key, $mt) === 1) {
                    $vld = $request->validate([ $key => 'required|max:255' ]);

                    $values[] = [ 'lang' => $mt[1], 'name' => $vld[$key] ];
                }
            }

            if (count($values) > 0) {
                foreach($values as $value) {
                    DB::insert('INSERT INTO `tag_lang` (`tag_id`, `lang_code`, `tag_name`)' .
                                                        ' VALUE(:id, :lang, :name)',
                               [ 'id' => $selTag, 'lang' => $value['lang'], 'name' => $value['name'] ]);
                }
            }
            else DB::rollBack();  // Se non ci sono nomi da inserire, rollback dell'inserimento del tag $selTag.
        });

        // Nel caso di un rollback, non ritorna a lista dei tags.
        return AdminTagsController::getTags($selTag, $reloadTagNames == 'yes' && $selTag > 0);
    }

    public function delete(Request $request): JsonResponse
    {
        $selTag = (int) $request['tag-tool-names'] ?? 0;
        $reloadTagNames = $request['reload-tag-names'] ?? 'yes';

        $del = DB::delete('DELETE FROM `tag` WHERE `tag_id` = :id', [ 'id' => $selTag ]);

        return AdminTagsController::getTags(($del > 0) ? 0 : $selTag, $reloadTagNames == 'yes');
    }
}
