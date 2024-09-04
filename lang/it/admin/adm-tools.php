<?php

return [

    // Italiano.
    // Stringhe per la pagina 'tools' di amministrazione.

    'title' => 'Tools',
    'description' => 'Gestione dei «<span class="a4-text-shade-100 font-bold">Tool</span>».',

    'tool' => 'Tool',
    'update-button-tooltip' => 'Modifica il Tool selezionato nel comboBox «:tool».',
    'add-button-tooltip' => 'Aggiungi un nuovo Tool.',
    'delete-button-tooltip' => 'Elimina il Tool selezionato nel comboBox «:tool».',

    'tool-id' => 'ID',
    'tool-id-tooltip' => 'Formato: A4xxx (xxx = 001 - 999) oppure A4xxxx (xxxx = 0001 - 9999).',
    'tool-title' => 'Titolo',
    'tool-title-tooltip' => 'Solo lettere maiuscole e minuscole, non sono ammessi spazi.',
    'tool-active' => 'Attivo',
    'tool-inactive' => 'Inattivo',
    'related-tools' => 'Tool correlati',
    'related-tools-selected' => 'tool selezionati',

    'tool-level' => 'Livelli',
    'tool-level-executive' => 'Esecutivo',
    'tool-level-advanced' => 'Avanzato',
    'tool-level-intermediate' => 'Intermedio',

    'tool-recipient' => 'Destinatari',
    'tool-recipient-management' => 'Management',
    'tool-recipient-marketing' => 'Marketing',
    'tool-recipient-operations' => 'Operations',
    'tool-recipient-rd' => 'Ricerca e sviluppo',

    'tool-usage' => 'Utilizzo',
    'tool-usage-strategy' => 'Strategia',
    'tool-usage-assessment' => 'Valutazione',
    'tool-usage-correctives' => 'Correttivi',
    'tool-usage-simplification' => 'Semplificazione',
    'tool-usage-delegation' => 'Delega',
    'tool-usage-motivation' => 'Motivazione e Team Building',

    'tool-selection' => 'Selezione',
    'tool-selection-a-plus' => 'A+++',
    'tool-selection-eco' => 'Eco',
    'tool-selection-quick' => 'Quick',
    'tool-selection-top' => 'TOP',

    'tool-scope' => 'Ambito',
    'tool-scope-company-management' => 'Direzione aziendale',
    'tool-scope-management' => 'Management',
    'tool-scope-team-management' => 'Gestione del team',
    'tool-scope-professional-development' => 'Sviluppo professionale',
    'tool-scope-individual-development' => 'Sviluppo individuale e benessere',

    // Errori SQL (salvati nell'attributo "data-sql-error" del div#tools-errors).
    // Nota: se il value di 'errMsg' deve contenere dei single o double-quote letterali, inserire
    //       rispettivamente i caratteri ’ o ” (saranno convertiti dalla funzione ajaxError() in "admin.js").
    'sql-error' => "[{ 'match':'tool.PRIMARY','errMsg':" .
                      "'<b>ID duplicato</b>: un altro Tool sta già utilizzando questo «ID».' }," .
                    "{ 'match':'tool.uq_tool_title_id','errMsg':" .
                      "'<b>Titolo duplicato</b>: un altro Tool sta già utilizzando questo «Titolo».' }," .
                    "{ 'match':'tool.chk_tool_title_id','errMsg':" .
                      "'<b>Titolo vuoto</b>: il «Titolo» del Tool non può essere vuoto.' }]",

    // Delete tools dialogBox.
    'delete-title' => 'Elimina Tool',
    'delete-body' => 'Sei sicuro di voler eliminare il Tool selezionato?',

];
