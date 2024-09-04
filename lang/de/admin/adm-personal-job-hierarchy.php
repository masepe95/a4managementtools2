<?php

return [

    // Deutsch.
    // Stringhe per la pagina 'personal-job-hierarchy' di amministrazione.

    'title' => 'Meine Berufsbezeichnungen',
    'description' => 'Verwaltung der Hierarchie der persönlichen Berufsbezeichnungen, die auf «<span class="a4-text-shade-100 font-bold">Beruf</span>» anwendbar sind.',

    'hierarchy-names-tooltip' => 'Name der aktuellen Berufsbezeichnung.',
    'hierarchy-names-label' => 'Bezeichnung der Berufsbezeichnung',

    'new-hierarchy-name' => 'Name der neuen Struktur',
    'new-hierarchy-name-tooltip' => 'Wenn dieses Feld leer gelassen wird, bleibt der Name der Berufsbezeichnung beim Drücken der «:update» Schaltfläche unverändert.&#10;Um eine neue Berufsbezeichnung zu erstellen, muss der Name von den bereits vorhandenen abweichen.',
    'new-hierarchy-name-error' => 'Dieser Name wird bereits verwendet.',

    'update-button-tooltip' => 'Aktualisiere die ausgewählte Berufsbezeichnung im «:name» Dropdown-Menü.',
    'delete-button-tooltip' => 'Lösche die ausgewählte Berufsbezeichnung im «:name» Dropdown-Menü.',
    'add-button-tooltip' => 'Füge eine neue Berufsbezeichnung mit dem im Textfeld «:newname» angegebenen Namen hinzu.',

    'add-level-button-tooltip' => 'Füge eine Berufsbezeichnungsebene hinzu, maximal 4 Ebenen.',
    'preview-label' => 'Vorschau',

    'level-number-tooltip' => 'Ebene :level',
    'level-short' => 'E',
    'level-info-tooltip' => 'Dieses Feld wird auf der «Beruf»-Seite obligatorisch sein; jeglicher Inhalt, der in dieser Vorschau eingegeben wird, wird ignoriert.',

    'level-min-languages-tooltip' => 'Bitte füllen Sie mindestens eine Sprache für diese Ebene aus.',
    'delete-level-tooltip' => 'Lösche diese Berufsbezeichnungsebene.',

    // Errori SQL (salvati nell'attributo "data-sql-error" del div#personal-job-hierarchy-errors).
    // Nota: se il value di 'errMsg' deve contenere dei single o double-quote letterali, inserire
    //       rispettivamente i caratteri ’ o ” (saranno convertiti dalla funzione ajaxError() in "admin.js").
    'sql-error' => "[{ 'match':'employee_hierarchy.uq_employee_hierarchy_name','errMsg':" .
                      "'<b>Doppelter Strukturname</b>: Es existiert bereits eine «Berufsbezeichnung» mit diesem Namen.' }," .
                    "{ 'match':'empl_hierarchy_lang.uq_empl_hierarchy_lang_name','errMsg':" .
                      "'<b>Doppelter Ebenenname</b>: Mehrere Ebenen haben denselben «Ebenennamen» für dieselbe Sprache.' }]",

    // Delete job nomenclature modal dialogBox.
    'delete-title' => 'Berufsbezeichnungen löschen',
    'delete-body' => 'Sind Sie sicher, dass Sie die ausgewählte Berufsbezeichnungen löschen möchten?',

];
