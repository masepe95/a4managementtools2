<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\AdminController;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\App;

class AdminCustomerController extends Controller
{
    private static function getCountries($countryId): string
    {
        // Controlla se esiste la colonna corrispondente alla lingua corrente.
        // Se non esiste, ritorna il nome della nazione dalla colonna `country_name`.
        // Nota: il binding non funziona con la query "SHOW COLUMNS FROM", né con il placeholder
        //       tramite il carattere ?, né con un placehloder nominale (ad esempio: :colName).
        //       La variabile $langColName è comunque sicura (language code) e può essere concatenata
        //       senza pericoli.
        $langColName = App::getLocale();
        $langCol = DB::select("SHOW COLUMNS FROM `country` LIKE '$langColName'");
        if (count($langCol) <= 0) $langColName = 'country_name';

        // Ritorna tutte le countries:
        //   • code3 (PK).
        //   • nome della colonna nella lingua corrente (o `country_name` se la colonna non esiste).
        //   • il campo calcolato `ord` (1 per le countries da listare per prime, "Suggested languages counties"
        //     e 0 per quelle seguenti, "Worldwide", entrambi i gruppi sono ordinati alfabeticamente).
        // Nota: nel caso `code3` sia 'gbr' e la lingua sia 'en', ritorna il nome della nazione dalla
        //       colonna `country_name` anziché dalla colonna `en`, quindi
        //         United Kingdom
        //           anziché
        //         United Kingdom of Great Britain and Northern Ireland
        $countries = DB::select("SELECT `code3`, `code3` IN ('che', 'ita', 'fra', 'deu') `ord`," .
                                      " IF(`code3` = 'gbr' AND '$langColName' = 'en', `country_name`, `$langColName`) AS `cntr`" .
                                 ' FROM `country` ORDER BY `ord` DESC, `cntr`');

        // Converti in html-entities gli eventuali caratteri speciali del campo `cntr`.
        // Costruisci la stringa delle <option> della lista di countries.
        $countryOpts = '<option value="" hidden></option>'; $ord = -1;
        $grps = [ __('admin/adm-customer.worldwide-countries'), __('admin/adm-customer.suggested-countries') ];
        foreach ($countries as $country) {
            $country->cntr = htmlentities($country->cntr, ENT_QUOTES, 'UTF-8');

            if ($country->ord != $ord) {
                if ($ord != -1) $countryOpts .= '</optgroup>';  // Un <optgroup> è già stato aperto, chiudilo.
                $ord = $country->ord;
                $typ = $grps[$ord];
                $countryOpts .= "<optgroup label=\"$typ\">";
            }

            $sel = (strcasecmp($country->code3, $countryId) == 0) ? ' selected=""' : '';
            $countryOpts .= "<option value=\"{$country->code3}\" title=\"{$country->cntr}\"$sel>{$country->cntr}</option>";
        }

        if ($ord != -1) $countryOpts .= '</optgroup>';  // Chiudi l'ultimo <optgroup> se ne è stato aperto almeno uno.

        return $countryOpts;
    }

    public function index(Request $request): JsonResponse
    {
        $usr = AdminController::getRealUser($request);
        $cust = Customer::find($usr->customer_id);

        $logo = $cust->logo_file;
        if (!is_null($logo)) {
            $logo = GetImage::getImageInfo($logo);
            if ($logo == '') $logo = null;
        }

        $data = ['customer-name' => $cust->name, 'customer-company-uid' => $cust->company_uid,
                 'customer-address1' => $cust->address1, 'customer-address2' => $cust->address2,
                 'customer-city' => $cust->city, 'customer-zip' => $cust->zip,
                 'customer-vat' => $cust->vat, 'customer-number-users' => $cust->number_of_users,
                 'customer-logo-image' => $logo];

        $adminData = [];
        if ($request->user()->role == 'siteAdmin') {  // Ruolo dello user effettivo (non quello eventualmente impersonato).
            // Ritorna lo stato di tutti i tools attivi (`active` = 'yes').
            // La colonna `enabled` può assumere i seguenti valori:
            //   • null = il customer dell'impiegato (eventualmente impersonato) non ha accesso al relativo tool.
            //   • 'Y'  = il customer dell'impiegato (eventualmente impersonato) ha accesso al relativo tool.
            //   • 'N'  = l'accesso del customer dell'impiegato (eventualmente impersonato) è attualmente disabilitato.
            // La colonna `cntJobs` ritorna il numero di job per ogni tool del customer corrente.
            $tools = DB::select("SELECT tl.`id`, tl.`name_id`, tl.`title_id`, ct.`enabled`," .
                                             ' (SELECT COUNT(job.`tool_id`) FROM `job`' .
                                                ' WHERE job.`tool_id` = ct.`tool_id` AND job.`customer_id` = ct.`customer_id`) AS `cntJobs`' .
                                 ' FROM `tool` tl LEFT JOIN `customer_tool` ct ON ct.`tool_id` = tl.`id` AND ct.`customer_id` = :cust' .
                                 " WHERE tl.`active` = 'Y' ORDER BY tl.`id`",
                                [ 'cust' => $cust->id ]);

            if ($cust->customer_type == 'siteOwner') {
                $typeOpts = '<option value="siteOwner">' . __('admin/adm-customer.customer-type-site-admin') . '</option>';
                $statusOpts = '<option value="enabled">' . __('admin/adm-customer.customer-status-enabled') . '</option>';
            }
            else {
                $sel = ($cust->customer_type == 'freeCustomer') ? ' selected=""' : '';
                $typeOpts = "<option value=\"freeCustomer\"$sel>" . __('admin/adm-customer.customer-type-free-account') . '</option>';
                $sel = ($cust->customer_type == 'regularCustomer') ? ' selected=""' : '';
                $typeOpts .= "<option value=\"regularCustomer\"$sel>" . __('admin/adm-customer.customer-type-regular-account') . '</option>';

                $sel = ($cust->customer_status == 'enabled') ? ' selected=""' : '';
                $statusOpts = "<option value=\"enabled\"$sel>" . __('admin/adm-customer.customer-status-enabled') . '</option>';
                $sel = ($cust->customer_status == 'disabled') ? ' selected=""' : '';
                $statusOpts .= "<option value=\"disabled\"$sel>" . __('admin/adm-customer.customer-status-disabled') . '</option>';
            }

            $adminData = ['customer-type' => $typeOpts, 'customer-status' => $statusOpts,
                          'customer-use-saml' => $usr->use_saml, 'customer-tools' => $tools ];
        }

        $selState = (int) $cust->country_state_id ?? 0;

        // Ritorna il codice della nazione a cui appartiene lo stato $selState.
        // Nota: questa query potrebbe ritornare direttamente anche gli stati (vedi $states) più avanti,
        //       ma, per performance, le due queries sono separate per evitare di ritornare la collection
        //       di stati se non necessaria (il valore di `code3`, invece, è necessario in ogni caso).
        $countryCode = DB::select('SELECT `code3` FROM `country_state` WHERE `id` = :id', [ 'id' => $selState ]);
        $countryCode = (count($countryCode) > 0) ? strtolower($countryCode[0]->code3) : 0;

        if ($countryCode !== 0) {
            $countryId = $countryCode;
            $stateId = $selState;
        }
        else $countryId = $stateId = 0;

        // Ritorna la lista delle nazioni solo durante il primo caricamento delle pagine di amministrazioni.
        if ($request['country-loaded'] != 'no') $countryOpts = '';
        else $countryOpts = AdminCustomerController::getCountries($countryId);

        // Non ritornare gli stati della nazione corrente se non è cambiata.
        $newCountryCode = ($request['customer-country'] == $countryCode) ? '' : $countryCode;

        // Aumenta il numero massimo di caratteri (default = 1024) concatenabili della funzione aggregata GROUP_CONCAT().
        DB::statement('SET SESSION group_concat_max_len = 1048576');  // 1 MB.

        // Ritorna i `level_name` distinti degli stati della nazione a cui appartiene lo stato $countryCode.
        $levelNames = DB::select('SELECT GROUP_CONCAT(DISTINCT `level_name`) AS `names` FROM `country_state`' .
                                  ' WHERE `code3`= :id GROUP BY `code3`',
                                [ 'id' => $newCountryCode ]);

        // Array dei nomi tradotti di `level_name`.
        $stateTypes = __('admin/adm-customer.state-types');

        // Ordina i nomi di `level_name` in base al nome tradotto.
        $cmpCallback = function($a, $b) use ($stateTypes) {
            if ($stateTypes[$a] == $stateTypes[$b]) return 0;
            return ($stateTypes[$a] < $stateTypes[$b]) ? -1 : 1;
        };

        // Costruisci un FIND_IN_SET() per ordinare i `level_name` in base alla lingua corrente.
        $nameArr = (count($levelNames) > 0) ? explode(',', $levelNames[0]->names) : [];
        usort($nameArr, $cmpCallback);
        $flds = (count($nameArr) > 0) ? "FIND_IN_SET(`level_name`,'" . implode(",", $nameArr) . "')" : '`level_name`';

        // Ritorna i nomi degli stati della nazione a cui appartiene lo stato $countryCode.
        $states = DB::select('SELECT `id`, `subdiv_name`, `level_name`' .
                              ' FROM `country_state`' .
                              " WHERE `code3` = :id ORDER BY $flds, `subdiv_name`",
                             [ 'id' => $newCountryCode ]);


        $stateOpts = ''; $lvlName = '_$_';
        $stateTypes = __('admin/adm-customer.state-types');

        foreach ($states as $state) {
            // Converti in html-entities gli eventuali caratteri speciali del campo `subdiv_name`.
            $state->subdiv_name = htmlentities($state->subdiv_name, ENT_QUOTES, 'UTF-8');

            $name = (is_null($state->level_name)) ? ' ' : htmlentities($stateTypes[$state->level_name], ENT_QUOTES, 'UTF-8');
            if ($name != $lvlName) {
                if ($lvlName != '_$_') $stateOpts .= '</optgroup>';  // Un <optgroup> è già stato aperto, chiudilo.
                $lvlName = $name;
                $stateOpts .= "<optgroup label=\"$lvlName\">";
            }

            $sel = ($state->id == $stateId) ? ' selected=""' : '';
            $stateOpts .= "<option value=\"{$state->id}\" title=\"{$state->subdiv_name}\"$sel>{$state->subdiv_name}</option>";
        }

        if ($lvlName != '_$_') $stateOpts .= '</optgroup>';  // Chiudi l'ultimo <optgroup> se ne è stato aperto almeno uno.

        return response()->json([ 'customer' => $data, 'admin' => $adminData,
                                  'countries' => $countryOpts, 'newCountryId' => $countryCode,
                                  'states' => $stateOpts, 'newStateId' => $stateId ]);
    }

    public function store(Request $request): JsonResponse
    {
        // Ottieni il customer id dell'utente corrente, eventualmente impersonato.
        $custId = AdminController::getRealUser($request)->customer_id;

        // Esegui una transazione per modificare le tabelle `customer` e `customer_tool`.
        DB::transaction(function() use ($request, $custId) {
            // Ottieni gli enumerativi del campo `number_of_users`.
            // Ritorna un row con le colonne: `Field`, `Type`, `Null`, `Key`, `Default` e `Extra`.
            // La colonna `Type` ritorna una stringa di tipo:
            //   enum('usr1','usr10','usr50','usr100','usr500','usr1000','usr2000','usr3000', ... )
            $nUsers = DB::select("SHOW COLUMNS FROM `customer` LIKE 'number_of_users'");
            $nUsers = str_replace("'", '', trim($nUsers[0]->Type, 'enum()'));

            // Valida i dati limitati all'accesso dei 'customerAdmin'.
            $validated = $request->validate([
                'customer-name' => 'required|max:64',
                'customer-company-uid' => 'nullable|max:32',
                'customer-address1' => 'nullable|max:128',
                'customer-address2' => 'nullable|max:128',
                'customer-city' => 'nullable|max:64',
                'customer-zip' => 'nullable|max:32',
                'customer-country-state' => 'nullable|numeric',
                'customer-vat' => 'nullable|max:128',
                'customer-number-users' => "nullable|in:$nUsers",
            ]);

            // NON utilizzare Customer::find($usr->customer_id)->save(), una parte di dati del customer
            // può essere salvata solo se l'utente originale è un 'siteAdmin'.
            // Se si salvano i dati tramite il metodo save() del customer, tutti i valori delle colonne
            // dell'oggetto customer vengono aggiornati indiscriminatamente, anche eventuali valori injected.
            //
            // Nota: quando un campo di un form è disabilitato ("#customer-country-state" potrebbe esserlo),
            //       la relativa variabile POST non viene inviata.
            //       In tal caso, la validazione ha comunque successo (se il valore è definito come nullable),
            //       ma l'array $validated non riceve il valore null e la sua key risulta inesistente.
            //       Il campo 'customer-country-state' viene passato ai binding tramite l'array $request per
            //       evitare l'errore 'Undefined array key "customer-country-state"'.
            DB::update('UPDATE `customer` SET `name` = :name, `company_uid` = :companyId, `address1` = :addr1, `address2` = :addr2,' .
                            ' `city` = :city, `zip` = :zip, `country_state_id` = :stateId, `vat` = :vat, `number_of_users` = :nUsers' .
                        ' WHERE `id` = :id',
                    [ 'name' => $validated['customer-name'], 'companyId' => $validated['customer-company-uid'],
                        'addr1' => $validated['customer-address1'], 'addr2' => $validated['customer-address2'],
                        'city' => $validated['customer-city'], 'zip' => $validated['customer-zip'],
                        'stateId' => $request['customer-country-state'], 'vat' => $validated['customer-vat'],
                        'nUsers' => $validated['customer-number-users'], 'id' => $custId ]);

            // Esegui l'aggiornamento dei dati riservati ai 'siteAdmin' solo se l'utente originale lo è.
            if ($request->user()->role == 'siteAdmin') {  // Ruolo dello user effettivo, non quello eventualmente impersonato!
                // Ottieni gli enumerativi dei campi `customer_type`, `customer_status` e `use_saml`.
                $custType = DB::select("SHOW COLUMNS FROM `customer` LIKE 'customer_type'");
                $custType = str_replace("'", '', trim($custType[0]->Type, 'enum()'));

                $custStatus = DB::select("SHOW COLUMNS FROM `customer` LIKE 'customer_status'");
                $custStatus = str_replace("'", '', trim($custStatus[0]->Type, 'enum()'));

                $useSaml = DB::select("SHOW COLUMNS FROM `customer` LIKE 'use_saml'");
                $useSaml = str_replace("'", '', trim($useSaml[0]->Type, 'enum()'));

                $validated = $request->validate([
                    'customer-type' => "nullable|in:$custType",
                    'customer-status' => "nullable|in:$custStatus",
                    'customer-use-saml' => "required|in:$useSaml",
                ]);

                // I campi 'customer-type' e 'customer-status' potrebbero essere null (da non modificare).
                // Costruisci la query dinamicamente.
                $binds = [ 'useSaml' => $validated['customer-use-saml'], 'id' => $custId ];
                $query = 'UPDATE `customer` SET `use_saml` = :useSaml';

                // Nota: verifica la key 'customer-type' nell'array $request, se il relativo <select>
                //       è disabilitato, il suo valore non viene inviato con le variabili POST e quindi
                //       non può essere presente nell'array $validated perché non è il valore ad essere
                //       nullo, ma è la key a non essere presente.
                //       In questo caso, i valori inesistenti non devono essere modificati.
                if (!is_null($request['customer-type'])) {
                    $query .= ', `customer_type` = :custType';
                    $binds['custType'] = $validated['customer-type'];
                }

                if (!is_null($request['customer-status'])) {
                    $query .= ', `customer_status` = :custStatus';
                    $binds['custStatus'] = $validated['customer-status'];
                }

                DB::update($query . ' WHERE `id` = :id', $binds);

                // Itera i dati di POST e assumi i dati di assegnazione dei tool per il customer corrente.
                $assignValues = [ 'yes', 'no', 'disabled' ];
                foreach ($request->post() as $key => $value) {
                    // Assumi solo le variabili con un valore non null e valido con il formato della $key
                    // corrispondente al pattern definito dalla RegExp (A4000/A40000 non accettato).
                    if (preg_match('/^cust-tool-a4(?!000$|0000)(\d{3,4})$/', $key, $mt) == 1 &&
                        !is_null($value) && in_array($value, $assignValues)) {

                        // Se $value è 'no', il tool non è assegnato, elimina il link dalla tabella `customer_tool`.
                        if ($value == 'no') DB::delete('DELETE FROM `customer_tool`' .
                                                        ' WHERE `customer_id` = :custId AND `tool_id` = :toolId ',
                                                       [ 'custId' => $custId, 'toolId' => (int) $mt[1] ]);
                        else {
                            // Utilizza lo statement 'INSERT with ON DUPLICATE KEY UPDATE'.
                            // La PK è (`customer_id`, `tool_id`).
                            $vl = ($value == 'yes') ? 'Y' : 'N';
                            DB::insert('INSERT INTO `customer_tool` (`customer_id`, `tool_id`, `enabled`)' .
                                                          ' VALUES(:custId, :toolId, :enab) AS new' .
                                        ' ON DUPLICATE KEY UPDATE `enabled` = new.`enabled`',
                                       [ 'custId' => $custId, 'toolId' => (int) $mt[1], 'enab' => $vl ]);
                        }
                    }
                }
            }
        });

        // Lo store è andato a buon fine, ritorna il nuovo stato di 'assigned' al customer corrente per tutti i tools.
        $tools = [];
        if ($request->user()->role == 'siteAdmin') {  // Ruolo dello user effettivo, non quello eventualmente impersonato!
            // Ritorna lo stato di tutti i tools attivi (`active` = 'yes').
            // La colonna `enabled` può assumere i seguenti valori:
            //   • null = il customer dell'impiegato (eventualmente impersonato) non ha accesso al relativo tool.
            //   • 'Y'  = il customer dell'impiegato (eventualmente impersonato) ha accesso al relativo tool.
            //   • 'N'  = l'accesso del customer dell'impiegato (eventualmente impersonato) è attualmente disabilitato.
            // La colonna `cntJobs` ritorna il numero di job per ogni tool del customer corrente.
            $tools = DB::select("SELECT tl.`id`, tl.`name_id`, tl.`title_id`, ct.`enabled`," .
                                            ' (SELECT COUNT(job.`tool_id`) FROM `job`' .
                                                ' WHERE job.`tool_id` = ct.`tool_id` AND job.`customer_id` = ct.`customer_id`) AS `cntJobs`' .
                                 ' FROM `tool` tl LEFT JOIN `customer_tool` ct ON ct.`tool_id` = tl.`id` AND ct.`customer_id` = :cust' .
                                 " WHERE tl.`active` = 'Y' ORDER BY tl.`id`",
                                [ 'cust' => $custId ]);
        }

        return response()->json([ 'tools' => $tools ]);
    }

    public function uploadLogo(Request $request): JsonResponse
    {
        // Carica il logo del customer impostando il campo `logo_file` con il parametro 'customerLogo'.
        $usr = AdminController::getRealUser($request);
        $cust = Customer::find($usr->customer_id);

        $file = $request->file('customerLogo');  // Path del file temporaneo (es.: 'C:\PHP8\uploadtemp\phpBDD3.tmp').
        $cust->logo_file = File::get($file);     // Equivalente alla funzione file_get_contents($file).
        $cust->save();

        File::delete($file);  // Elimina il file temporaneo caricato sul server.

        $logo = $cust->logo_file;
        if (!is_null($logo)) {
            $logo = GetImage::getImageInfo($logo);
            if ($logo == '') $logo = null;
        }

        return response()->json([ 'logo' => $logo ]);
    }

    public function deleteLogo(Request $request): JsonResponse
    {
        // Elimina il logo del customer impostando il campo `logo_file` con il valore null.
        $usr = AdminController::getRealUser($request);
        $cust = Customer::find($usr->customer_id);
        $cust->logo_file = null;
        $cust->save();

        return response()->json([]);
    }

    public function changeCountry(Request $request): JsonResponse
    {
        $countryId = $request['customer-country'] ?? '';

        // Aumenta il numero massimo di caratteri (default = 1024) concatenabili della funzione aggregata GROUP_CONCAT().
        DB::statement('SET SESSION group_concat_max_len = 1048576');  // 1 MB.

        // Ritorna i `level_name` distinti degli stati della nazione a cui appartiene lo stato $countryCode.
        $levelNames = DB::select('SELECT GROUP_CONCAT(DISTINCT `level_name`) AS `names` FROM `country_state`' .
                                  ' WHERE `code3`= :id GROUP BY `code3`',
                                [ 'id' => $countryId ]);

        // Array dei nomi tradotti di `level_name`.
        $stateTypes = __('admin/adm-customer.state-types');

        // Ordina i nomi di `level_name` in base al nome tradotto.
        $cmpCallback = function($a, $b) use ($stateTypes) {
            if ($stateTypes[$a] == $stateTypes[$b]) return 0;
            return ($stateTypes[$a] < $stateTypes[$b]) ? -1 : 1;
        };

        // Costruisci un FIND_IN_SET() per ordinare i `level_name` in base alla lingua corrente.
        $nameArr = explode(',', $levelNames[0]->names);
        usort($nameArr, $cmpCallback);
        $flds = (count($nameArr) > 0) ? "FIND_IN_SET(`level_name`,'" . implode(",", $nameArr) . "')" : '`level_name`';

        // Ritorna i nomi degli stati della nazione $countryId.
        $states = DB::select('SELECT `id`, `subdiv_name`, `level_name`' .
                              ' FROM `country_state`' .
                              " WHERE `code3` = :id ORDER BY $flds, `subdiv_name`",
                             [ 'id' => $countryId ]);

        $stateOpts = ''; $lvlName = '_$_';

        foreach ($states as $state) {
            // Converti in html-entities gli eventuali caratteri speciali del campo `subdiv_name`.
            $state->subdiv_name = htmlentities($state->subdiv_name, ENT_QUOTES, 'UTF-8');

            $name = (is_null($state->level_name)) ? ' ' : htmlentities($stateTypes[$state->level_name], ENT_QUOTES, 'UTF-8');
            if ($name != $lvlName) {
                if ($lvlName != '_$_') $stateOpts .= '</optgroup>';  // Un <optgroup> è già stato aperto, chiudilo.
                $lvlName = $name;
                $stateOpts .= "<optgroup label=\"$lvlName\">";
            }

            $stateOpts .= "<option value=\"{$state->id}\" title=\"{$state->subdiv_name}\">{$state->subdiv_name}</option>";
        }

        if ($lvlName != '_$_') $stateOpts .= '</optgroup>';  // Chiudi l'ultimo <optgroup> se ne è stato aperto almeno uno.

        return response()->json([ 'states' => $stateOpts ]);
    }
}
