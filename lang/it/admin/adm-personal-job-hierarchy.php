<?php

return [

    // Italiano.
    // Stringhe per la pagina 'personal-job-hierarchy' di amministrazione.

    'title' => 'Le mie Nomenclature Job',
    'description' => 'Gestione della gerarchia delle Nomenclature personali applicabili ai «<span class="a4-text-shade-100 font-bold">Job</span>».',

    'hierarchy-names-tooltip' => 'Nome della Nomenclatura corrente.',
    'hierarchy-names-label' => 'Nome della Nomenclatura',

    'new-hierarchy-name' => 'Nome della nuova Nomenclatura',
    'new-hierarchy-name-tooltip' => 'Se questo campo è lasciato vuoto, il nome della Nomenclatura rimane invariato quando si preme «:update».&#10;Per creare una nuova Nomenclatura, il nome deve essere differente da quelli già esistenti.',
    'new-hierarchy-name-error' => 'Questo nome è già utilizzato.',

    'update-button-tooltip' => 'Modifica la Nomenclatura selezionata nel comboBox «:name».',
    'delete-button-tooltip' => 'Elimina la Nomenclatura selezionata nel comboBox «:name».',
    'add-button-tooltip' => 'Aggiungi una nuova Nomenclatura con il nome specificato nel campo di testo «:newname».',

    'add-level-button-tooltip' => 'Aggiungi un livello di Nomenclatura, massimo 4 livelli.',
    'preview-label' => 'Anteprima',

    'level-number-tooltip' => 'Livello :level',
    'level-short' => 'L',
    'level-info-tooltip' => "Questo campo sarà abbigatorio nella pagina dei «Job», l'eventuale contenuto digitato in questa anteprima viene ignorato.",

    'level-min-languages-tooltip' => 'Si prega di compilare almeno una lingua per questo livello.',
    'delete-level-tooltip' => 'Elimina questo livello di Nomenclatura.',

    // Errori SQL (salvati nell'attributo "data-sql-error" del div#personal-job-hierarchy-errors).
    // Nota: se il value di 'errMsg' deve contenere dei single o double-quote letterali, inserire
    //       rispettivamente i caratteri ’ o ” (saranno convertiti dalla funzione ajaxError() in "admin.js").
    'sql-error' => "[{ 'match':'employee_hierarchy.uq_employee_hierarchy_name','errMsg':" .
                      "'<b>Nome della Nomenclatura duplicato</b>: esiste già una «Nomenclatura» con questo nome.' }," .
                    "{ 'match':'empl_hierarchy_lang.uq_empl_hierarchy_lang_name','errMsg':" .
                      "'<b>Nome di Livello duplicato</b>: più livelli hanno lo stesso «Nome di Livello» per la stessa lingua.' }]",

    // Delete job nomenclature modal dialogBox.
    'delete-title' => 'Elimina Nomenclatura Job',
    'delete-body' => 'Sei sicuro di voler eliminare la Nomenclatura Job selezionata?',

];
