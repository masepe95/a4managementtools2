<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class AdminSectionsController extends Controller
{
    private static function getSections($usr): JsonResponse
    {
        // Ritorna la lista dei livelli con i relativi nomi multilingua (ritorna un array vuoto se nessun
        // livello è stato trovato).
        // Nota: il campo `level` avrà un valore da 1 ad al massimo 4 (ordine dei livelli).
        // Nota: gli <input> per i nomi dei livelli (stringa `names`)
        //         formato: <lang>:<levelName>\f<lang>:<levelName> ...)
        //       verranno disposti con l'ordinamento definito dall'attributo "data-section-languages".
        //
        // Esempio:
        //   ┌───────┬──────────────────────────┐
        //   │ level │ names                    │
        //   ╞═══════╪══════════════════════════╡
        //   │     1 │ en:Level 1\fit:Livello 1 │
        //   │     2 │ fr:Niveau 2              │
        //   └───────┴──────────────────────────┘
        //
        // Nota: le expressioni (separate da virgola) all'interno della funzione GROUP_CONCAT() vengono
        //       automaticamente concatenate.

        // Aumenta il numero massimo di caratteri (default = 1024) concatenabili della funzione aggregata GROUP_CONCAT().
        DB::statement('SET SESSION group_concat_max_len = 1048576');  // 1 MB.

        $levels = DB::select('SELECT sl.`level`,' .
                                   " GROUP_CONCAT(DISTINCT sll.`lang_code`, ':', sll.`name` ORDER BY lg.`order` SEPARATOR '\f') AS `names`" .
                              ' FROM `section_level` sl' .
                              // Utilizzare LEFT JOIN anziché JOIN in caso non ci siano entries in `section_level_lang`.
                              ' LEFT JOIN `section_level_lang` sll ON sll.`customer_id` = sl.`customer_id` AND sll.`level` = sl.`level`' .
                              ' LEFT JOIN `language` lg ON lg.`code` = sll.`lang_code`' .  // Per l'ORDER BY in GROUP_CONCAT().
                              ' WHERE sl.`customer_id` = :cust' .
                              ' GROUP BY sl.`level`' .
                              ' ORDER BY sl.`level`',
                             [ 'cust' => $usr->customer_id ]);

        // Converti in html-entities gli eventuali caratteri speciali del campo `names`.
        foreach ($levels as $level) {
            $level->names = htmlentities($level->names, ENT_QUOTES, 'UTF-8');
        }

        // Nome del customer a cui appartengono le sezioni (unità).
        $customerName = DB::scalar('SELECT `name` FROM `customer` WHERE `id` = :cust', [ 'cust' => $usr->customer_id ]);


        // Ritorna le sezioni (unità), con i relativi nomi multilingua, associate ai livelli (ritorna un array
        // vuoto se nessuna sezione è stata trovata).
        // Nota: il campo `level` avrà un valore da 1 ad al massimo 4 (ordine dei livelli che referenzia
        //       lo stesso campo in $levels).
        // Nota: gli <input> per i nomi delle sezioni/unità (stringa `names`)
        //         formato: <lang>:<sectionName>\f<lang>:<sectionName> ...)
        //       verranno disposti con l'ordinamento definito dall'attributo "data-section-languages".
        //
        // Esempio:
        //   ┌────┬────────┬───────┬──────────────────────────┬───────────┐
        //   │ id │ parent │ level │ names                    │ employees │
        //   ╞════╪════════╪═══════╪══════════════════════════╪═══════════╡
        //   │  1 │   null │     1 │ fr:Unité 1\fde:Einheit 1 │       1,5 │  prima sezione (unità) del livello 1.
        //   │  2 │   null │     1 │ it:Unità 1               │      null │  seconda sezione (unità) del livello 1.
        //   │  3 │      1 │     2 │ en:Unit 2                │     14,22 │  prima sezione (unità) del livello 2.
        //   └────┴────────┴───────┴──────────────────────────┴───────────┘
        //
        $sections = DB::select('SELECT sc.`id`, sc.`parent_section_id` AS `parent`, sc.`level`,' .
                                     " GROUP_CONCAT(DISTINCT sl.`lang_code`, ':', sl.`name` ORDER BY lg.`order` SEPARATOR '\f') AS `names`," .
                                     " GROUP_CONCAT(DISTINCT se.`employee_id` SEPARATOR ',') AS `employees`" .
                                ' FROM `section` sc' .
                                // Utilizzare LEFT JOIN anziché JOIN in caso non ci siano entries in `section_lang`.
                                ' LEFT JOIN `section_lang` sl ON sl.`customer_id` = sc.`customer_id` AND sl.`section_id` = sc.`id`' .
                                ' LEFT JOIN `language` lg ON lg.`code` = sl.`lang_code`' .  // Per l'ORDER BY in GROUP_CONCAT().
                                // Utilizzare LEFT JOIN anziché JOIN in caso non ci siano assegnamenti ad employees in `section_employee`.
                                ' LEFT JOIN `section_employee` se ON se.`section_id` = sc.`id` AND se.`customer_id` = sc.`customer_id`' .
                                ' WHERE sc.`customer_id` = :cust' .
                                ' GROUP BY sc.`id`, sc.`parent_section_id`, sc.`level`, se.`section_id`' .
                                ' ORDER BY sc.`level`, sc.`id`',
                               [ 'cust' => $usr->customer_id ]);

        // Converti in html-entities gli eventuali caratteri speciali del campo `names`.
        foreach ($sections as $section) {
            $section->names = htmlentities($section->names, ENT_QUOTES, 'UTF-8');
        }

        return response()->json([ 'levels' => $levels, 'sections' => $sections, 'customer-name' => $customerName ]);
    }

    public function index(Request $request): JsonResponse
    {
        $usr = AdminController::getRealUser($request);

        return AdminSectionsController::getSections($usr);
    }

    public function store(Request $request): JsonResponse
    {
        $usr = AdminController::getRealUser($request);

        // Popola l'array $sections con il seguente formato (nel caso le variabili di POST non
        // siano in ordine crescente, il popolamento di questo array le riordina):
        //   Array (
        //     [1] => Array (           // Indice livello (1).
        //       [en] => Level 1        // Nome livello 1 (en => Level 1)
        //       [it] => Livello 1      // Nome livello 1 (it => Livello 1)
        //       [fr] =>                // Nome livello 1 (fr => null)
        //       [de] =>                // Nome livello 1 (de => null)
        //       [sections] => Array (
        //         [1] => Array (       // Indice sezione del livello 1 (1).
        //           [en] =>            // Nome sezione 1 (en => null)
        //           [it] =>            // Nome sezione 1 (it => null)
        //           [fr] => Unité 1    // Nome sezione 1 (fr => Unité 1)
        //           [de] => Einheit 1  // Nome sezione 1 (de => Einheit 1)
        //           [employees] => 1,2 // Indici degli impiegati associati a questa sezione (`section_employee`)
        //         )
        //
        //         [2] => Array (       // Indice sezione del livello 1 (2).
        //           [en] =>            // Nome sezione 2 (en => null)
        //           [it] => Unità 1    // Nome sezione 2 (it => Unità 1)
        //           [fr] =>            // Nome sezione 2 (fr => null)
        //           [de] =>            // Nome sezione 2 (de => null)
        //           [employees] => 1   // Indici degli impiegati associati a questa sezione
        //         )
        //       )
        //     )
        //
        //     [2] => Array (           // Indice livello (2).
        //       [en] =>                // Nome livello 2 (en => null)
        //       [it] =>                // Nome livello 2 (it => null)
        //       [fr] => Niveau 2       // Nome livello 2 (fr => Level 1)
        //       [de] =>                // Nome livello 2 (de => null)
        //       [sections] => Array (
        //         [3] => Array (       // Indice sezione del livello 2 (3).
        //           [en] => Unit 2     // Nome sezione 3 (en => Unit 2)
        //           [it] =>            // Nome sezione 3 (it => null)
        //           [fr] =>            // Nome sezione 3 (fr => null)
        //           [de] =>            // Nome sezione 3 (de => null)
        //           [parent] => 1      // Indice della sezione parente di questa sezione
        //           [employees] => 2   // Indici degli impiegati associati a questa sezione
        //         )
        //       )
        //     )
        //   )
        $sections = [];

        // Itera le variabili di POST.
        // Dati utilizzati:
        //   • org-level-<levelId>-<langCode>
        //   • org-section-<levelId>-<sectionId>-<langCode>
        //   • org-parent-<levelId>-<sectionId>
        //   • org-employees-<levelId>-<sectionId>
        foreach ($request->post() as $key => $value) {
            if (preg_match("/^org-(?:(level)-(\\d+)-([a-z]{2})|(section)-(\\d+)-(\\d+)-([a-z]{2})|(parent|employees)-(\\d+)-(\\d+))$/", $key, $mt) === 1) {
                //                   1       2      3          4         5      6      7          8                  9      10
                if ($mt[1] == 'level') $sections[$mt[2]][$mt[3]] = $value;
                elseif ($mt[4] == 'section') $sections[$mt[5]]['sections'][$mt[6]][$mt[7]] = $value;
                elseif ($mt[8] == 'parent') $sections[$mt[9]]['sections'][$mt[10]]['parent'] = $value;
                elseif ($mt[8] == 'employees') $sections[$mt[9]]['sections'][$mt[10]]['employees'] = $value;
            }
        }


        // Controllo di formato valido delle sezioni:
        //   • ogni livello deve avere almeno una lingua valida.
        //   • ogni livello deve avere almeno una sezione.
        //   • ogni sezione deve avere almeno una lingua valida.
        //
        // Nota: nel caso di aggiornamento tramite MySQL Workbench, il controllo di formato dei punti
        //       precedenti è responsabilità dell'amministatore.
        //       Non è, infatti, possibile implementare dei contraints che assicurino, per esempio,
        //       che dopo aver inserito un level nella tabella `section_level`, segua un inserimento
        //       di almeno una lingua nella tabella `section_level_lang`.
        //
        // Il resto dei controlli è svolto dal trigger BEFORE INSERT di `section` e dai constrains
        // UNIQUE delle tabelle `section_level`, `section_level_lang`, `section` e `section_lang`.
        //
        // Nota: il trigger BEFORE UPDATE di `section` è presente in caso di UPDATE tramite MySQL Workbench.

        // Itera i livelli.
        $lvlKeys = array_keys($sections);
        foreach ($lvlKeys as $lk) {
            $lvl = $sections[$lk];

            $bValid = false;

            // Itera i nomi multilingua del level corrente.
            $lvlNames = array_keys($lvl);
            foreach ($lvlNames as $nk) {
                // Considera solo i language-code (2 caratteri) con valore non null.
                // Nota: non serve controllare che il language-code sia valido, durante il successivo
                //       INSERT dovrà soddisfare i constraint FK con la tabella `language`.
                if (strlen($nk) != 2 || is_null($lvl[$nk])) continue;

                // Ok: almeno un nome di livello è valido.

                if (array_key_exists('sections', $lvl)) {
                    // Ok: esiste almeno una sezione per questo livello.

                    // Itera le sezioni del level corrente.
                    $sectKeys = array_keys($lvl['sections']);
                    foreach ($sectKeys as $sk) {
                        $sect = $lvl['sections'][$sk];

                        // Itera i nomi multilingua della sezione corrente.
                        $sectNames = array_keys($sect);
                        foreach ($sectNames as $nk) {
                            // Considera solo i language-code (2 caratteri) con valore non null.
                            if (strlen($nk) != 2 || is_null($sect[$nk])) continue;

                            // Ok: almeno un nome di sezione è valido, il formato di questo livello è valido.
                            $bValid = true;
                            break;
                        }

                        if ($bValid) break;  // Il formato di questo livello è valido.
                    }
                }
            }

            // Se questo livello non è valido, lancia un'exception.
            if (!$bValid) throw new Exception('Error: invalid Sections format.');
        }


        // Esegui una transazione per modificare le tabelle `section_level` e `empl_hierarchy_lang`.
        DB::transaction(function() use ($usr, $sections) {
            // Elimina l'intera struttura delle sezioni attuale, ogni level eliminato dalla tabella
            // `section_level` elimina automaticamente tutte le references nelle tabelle `section_level_lang`,
            // `section`, `section_lang` e `section_employee`.
            DB::delete('DELETE FROM `section_level` WHERE `customer_id` = :cust',
                       [ 'cust' => $usr->customer_id ]);

            // Costruisci la nuova struttura in base ai dati contenuti in $sections.
            $lvlKeys = array_keys($sections);

            // Itera i levels.
            foreach ($lvlKeys as $lk) {
                // Inserisci il level corrente.
                // Nota: l'entry in `section_level` deve essere creata prima dell'entry in `section`.
                DB::insert('INSERT INTO `section_level` (`customer_id`, `level`)  VALUES (:cust, :level)',
                           [ 'cust' => $usr->customer_id, 'level' => $lk ]);

                // Assegna per reference anziché per value.
                $lvl = &$sections[$lk];

                // Inserisci i nomi multilingua del level appena inserito.
                $lvlNames = array_keys($lvl);
                foreach ($lvlNames as $nk) {
                    // Considera solo i language-code (2 caratteri) con valore non null.
                    if (strlen($nk) != 2 || is_null($lvl[$nk])) continue;

                    DB::insert('INSERT INTO `section_level_lang` (`customer_id`, `level`, `lang_code`, `name`)' .
                                                       '  VALUES (:cust, :level, :lang, :name)',
                               [ 'cust' => $usr->customer_id, 'level' => $lk, 'lang' => $nk, 'name' => $lvl[$nk] ]);
                }

                if (array_key_exists('sections', $lvl)) {
                    // Inserisci le sezioni di questo level.
                    $sectKeys = array_keys($lvl['sections']);
                    foreach ($sectKeys as $sk) {
                        // Assegna per reference anziché per value, lo statement
                        //   $sect['sectId'] = $newSect;  (vedi di seguito)
                        // deve poter essere utilizzato per modificare dei valori nell'array
                        // originale, non in una copia.
                        $sect = &$lvl['sections'][$sk];

                        $parent_id = null;

                        if ($lk > 1) {
                            // Determina l'id effettivo della sezione parente.
                            if (array_key_exists('parent', $sect)) {
                                $pr = (int) $sect['parent'];
                                if (array_key_exists($lk - 1, $sections) &&
                                    array_key_exists('sections', $sections[$lk - 1]) &&
                                    array_key_exists($pr, $sections[$lk - 1]['sections']) &&
                                    array_key_exists('sectId', $sections[$lk - 1]['sections'][$pr])) {

                                    $parent_id = (int) $sections[$lk - 1]['sections'][$pr]['sectId'];
                                }
                            }
                        }

                        // Inserisci la sezione corrente.
                        // Se il level è 1, allora l'id del parente deve essere null.
                        // Se il level è maggiore di 1, allora l'id del parente deve essere valido.
                        DB::insert('INSERT INTO `section` (`customer_id`, `parent_section_id`, `level`)' .
                                                 ' VALUES (:cust, :parent, :level)',
                                   [ 'cust' => $usr->customer_id, 'parent' => $parent_id, 'level' => $lk ]);

                        // Ottiene l'id auto_increment del level appena inserito.
                        $newSect = (int) DB::getPdo()->lastInsertId();

                        $sect['sectId'] = $newSect;  // Memorizza l'id effettivo di questa sezione.

                        // Inserisci i nomi multilingua della sezione appena inserita.
                        $sectNames = array_keys($sect);
                        foreach ($sectNames as $nk) {
                            // Considera solo i language-code (2 caratteri) con valore non null.
                            if (strlen($nk) != 2 || is_null($sect[$nk])) continue;

                            DB::insert('INSERT INTO `section_lang` (`section_id`, `customer_id`, `lang_code`, `name`)' .
                                                         '  VALUES (:sect, :cust, :lang, :name)',
                                       [ 'sect' => $newSect, 'cust' => $usr->customer_id, 'lang' => $nk, 'name' => $sect[$nk] ]);
                        }

                        // Ripristina eventuali associazioni tra la sezione appena inserita e gli
                        // employees nella tabella `section_employee`.
                        if (array_key_exists('employees', $sect)) {
                            // Genera l'array di id degli employees dalla lista (separata da virgole).
                            $empArr = explode(",", $sect['employees']);
                            foreach ($empArr as $em) {
                                DB::insert('INSERT INTO `section_employee` (`section_id`, `customer_id`, `employee_id`)' .
                                                                 '  VALUES (:sect, :cust, :emp)',
                                           [ 'sect' => $newSect, 'cust' => $usr->customer_id, 'emp' => $em ]);
                            }
                        }
                    }
                }
            }
        });

        return AdminSectionsController::getSections($usr);
    }
}
