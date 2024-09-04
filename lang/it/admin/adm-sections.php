<?php

return [

    // Italiano.
    // Stringhe per la pagina 'sections' di amministrazione.

    'title' => 'Organigramma',
    'title-tooltip' => "Nome dell'Organizzazione",
    'description' => 'Organizzazione degli impiegati: in questa pagina è possibile definire un numero arbitrario di livelli gerarchici e unità, ogni livello e unità avrà un nome (multilingua). <span id="org-info-exp-arrow" class="cursor-pointer" data-title="Mostra di più." data-title-less="Mostra di meno."><svg class="inline h-4 w-4 stroke-neutral-800 hover:a4-stroke-shade-300 transition-transform duration-500 ease-in-out" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"></path></svg></span><div id="org-extra-info" style="display: none;">Ogni livello può contenere un numero qualsiasi di unità (con nome multilingua), vedi «<span class="a4-text-shade-100 font-bold hover:underline hover:cursor-pointer" data-te-toggle="modal" data-te-target="#section-sample-preview" title="Clicca per mostrare un esempio di organizzazione gerarchica.">esempio</span>».<br /><span class="font-bold">Nota</span>: ad eccezione delle unità del livello <span class="font-bold">1</span>, tutte le altre devono specificare la propria unità parente nel livello immediatamente superiore.<br />Una volta completata la struttura gerarchica, nella pagina «<span class="menu-link a4-text-shade-100 font-bold hover:underline hover:cursor-pointer" data-link-page="adm-employees-sections" title="Vai alla pagina \'Organigramma impiegati\'.">Organigramma impiegati</span>» è possibile associare gli impiegati ad una o più unità dell\'Organigramma.<br /><span class="font-bold">Nota</span>: nel caso vengano eliminati dei livelli o delle unità, ricontrollare e rivedere le associazioni degli impiegati nella pagina «<span class="menu-link a4-text-shade-100 font-bold hover:underline hover:cursor-pointer" data-link-page="adm-employees-sections" title="Vai alla pagina \'Organigramma impiegati\'.">Organigramma impiegati</span>».</div>',

    'add-level-tooltip' => "Aggiungi un livello all'Organigramma.",

    'level-label' => 'Livello',
    'level-section-label' => 'Unità del Livello',
    'level-delete-tooltip' => 'Elimina questo livello di Organigramma.',
    'add-section-tooltip' => "Aggiungi una nuova unità a questo livello dell'Organigramma.",
    'level-error-tooltip' => "Si prega di compilare almeno una lingua per il nome del livello e un minimo di un'unità.",
    'section-error-tooltip' => "Si prega di compilare almeno una lingua per il nome dell'unità.",
    'section-label' => 'Unità',
    'section-delete-tooltip' => 'Elimina questa unità.',
    'parent-section-label' => 'Unità parente.',

    // Sections' modal preview.
    'modal-title' => 'Esempio di organizzazione gerarchica',
    'modal-body1' => 'Questo esempio mostra lo schema di un\'organizzazione gerarchica con tre livelli (<span class="text-green-400 font-bold">Divisions</span>, <span class="text-green-400 font-bold">Departments</span> e <span class="text-green-400 font-bold">Teams</span>). Il primo livello <span class="text-green-400 font-bold">Division</span> include un\'unica unità (<span class="a4-text-shade-100 font-bold">Europe Division</span>), il secondo livello <span class="text-green-400 font-bold">Departments</span> include due unità (<span class="a4-text-shade-100 font-bold">Chemical department</span> e <span class="a4-text-shade-100 font-bold">Electronics department</span>), infine, il terzo livello <span class="text-green-400 font-bold">Teams</span> include cinque unità (<span class="a4-text-shade-100 font-bold">Research team</span>, <span class="a4-text-shade-100 font-bold">Development team</span>, <span class="a4-text-shade-100 font-bold">New technologies team</span>, <span class="a4-text-shade-100 font-bold">Electronic components team</span> e <span class="a4-text-shade-100 font-bold">Marketing team</span>).',
    'modal-body2' => "Per ogni unità deve essere specificata un'unità parente nel livello superiore.",
    'modal-body3' => 'La pagina «<span class="a4-text-shade-100 font-bold">Organigramma impiegati</span>» permette di associare gli impiegati ad una o più unità dell\'organigramma.',

    // Errori SQL (salvati nell'attributo "data-sql-error" del div#sections-errors).
    // Nota: se il value di 'errMsg' deve contenere dei single o double-quote letterali, inserire
    //       rispettivamente i caratteri ’ o ” (saranno convertiti dalla funzione ajaxError() in "admin.js").
    'sql-error' => "[{ 'match':'section_level_lang.uq_section_level_lang_name','errMsg':" .
                      "'<b>Nome di Livello duplicato</b>: più livelli hanno lo stesso «Nome di Livello» per la stessa lingua.' }," .
                    "{ 'match':'section_lang.uq_section_lang_name','errMsg':" .
                      "'<b>Nome di Unità duplicato</b>: più unità hanno lo stesso «Nome di Unità» per la stessa lingua.' }," .
                    "{ 'match':'Error','errMsg':" .
                      "'<b>Formato invalido</b>: il formato delle Sezioni non è valido.' }]",

];
