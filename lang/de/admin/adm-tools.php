<?php

return [

    // Deutsch.
    // Stringhe per la pagina 'tools' di amministrazione.

    'title' => 'Tools',
    'description' => '«<span class="a4-text-shade-100 font-bold">Tool</span>» Management.',

    'tool' => 'Tool',
    'update-button-tooltip' => 'Aktualisiere den ausgewählten Tool im ComboBox «:tool».',
    'add-button-tooltip' => 'Füge einen neuen Tool hinzu.',
    'delete-button-tooltip' => 'Lösche den ausgewählten Tool im ComboBox «:tool».',

    'tool-id' => 'ID',
    'tool-id-tooltip' => 'Format: A4xxx (xxx = 001 - 999) oder A4xxxx (xxxx = 0001 - 9999).',
    'tool-title' => 'Titel',
    'tool-title-tooltip' => 'Nur Groß- und Kleinbuchstaben, keine Leerzeichen erlaubt.',
    'tool-active' => 'Aktiv',
    'tool-inactive' => 'Inaktiv',
    'related-tools' => 'Verwandte Tools',
    'related-tools-selected' => 'ausgewählte Tools',

    'tool-level' => 'Ebenen',
    'tool-level-executive' => 'Exekutive',
    'tool-level-advanced' => 'Fortschrittlich',
    'tool-level-intermediate' => 'Dazwischenliegend',

    'tool-recipient' => 'Empfänger',
    'tool-recipient-management' => 'Management',
    'tool-recipient-marketing' => 'Marketing',
    'tool-recipient-operations' => 'Operationen',
    'tool-recipient-rd' => 'Forschung und Entwicklung',

    'tool-usage' => 'Verwendung',
    'tool-usage-strategy' => 'Strategie',
    'tool-usage-assessment' => 'Bewertung',
    'tool-usage-correctives' => 'Korrekturen',
    'tool-usage-simplification' => 'Vereinfachung',
    'tool-usage-delegation' => 'Delegation',
    'tool-usage-motivation' => 'Motivation und Teambuilding',

    'tool-selection' => 'Auswahl',
    'tool-selection-a-plus' => 'A+++',
    'tool-selection-eco' => 'Eco',
    'tool-selection-quick' => 'Quick',
    'tool-selection-top' => 'TOP',

    'tool-scope' => 'Umfang',
    'tool-scope-company-management' => 'Firmenmanagement',
    'tool-scope-management' => 'Management',
    'tool-scope-team-management' => 'Team Management',
    'tool-scope-professional-development' => 'Berufliche Weiterentwicklung',
    'tool-scope-individual-development' => 'Individuelle Entwicklung und Wohlbefinden',

    // Errori SQL (salvati nell'attributo "data-sql-error" del div#tools-errors).
    // Nota: se il value di 'errMsg' deve contenere dei single o double-quote letterali, inserire
    //       rispettivamente i caratteri ’ o ” (saranno convertiti dalla funzione ajaxError() in "admin.js").
    'sql-error' => "[{ 'match':'tool.PRIMARY','errMsg':" .
                      "'<b>Doppelte ID</b>: Ein anderes Tool verwendet diese «ID» bereits.' }," .
                    "{ 'match':'tool.uq_tool_title_id','errMsg':" .
                      "'<b>Doppelter Titel</b>: Ein anderes Tool verwendet diese «Titel» bereits.' }," .
                    "{ 'match':'tool.chk_tool_title_id','errMsg':" .
                      "'<b>Leerer Titel</b>: Der «Titel» des Tools darf nicht leer sein.' }]",

    // Delete tools dialogBox.
    'delete-title' => 'Tool löschen',
    'delete-body' => 'Sind Sie sicher, dass Sie das ausgewählte Tool löschen möchten?',

];
