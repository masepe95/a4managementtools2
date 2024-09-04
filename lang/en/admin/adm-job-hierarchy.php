<?php

return [

    // English.
    // Stringhe per la pagina 'job-hierarchy' di amministrazione.

    'title' => 'Job Nomenclatures',
    'title-tooltip' => 'Name of the Organization',
    'description' => 'Management of the hierarchy of nomenclatures applicable to «<span class="a4-text-shade-100 font-bold">job</span>».',

    'hierarchy-names-tooltip' => 'Name of the current nomenclature.',
    'hierarchy-names-label' => 'Nomenclature name',

    'new-hierarchy-name' => 'Name of the new nomenclature',
    'new-hierarchy-name-tooltip' => 'If this field is left empty, the nomenclature name remains unchanged when you press the «:update» button.&#10;To create a new nomenclature, the name must be different from those already existing.',
    'new-hierarchy-name-error' => 'This name is already in use.',

    'update-button-tooltip' => 'Update the selected Nomenclature in the «:name» comboBox.',
    'delete-button-tooltip' => 'Delete the selected Nomenclature in the «:name» comboBox.',
    'add-button-tooltip' => 'Add a new nomenclature with the name specified in the «:newname» text field.',

    'add-level-button-tooltip' => 'Add a nomenclature level, maximum 4 levels.',
    'preview-label' => 'Preview',

    'level-number-tooltip' => 'Level :level',
    'level-short' => 'L',
    'level-info-tooltip' => 'This field will be mandatory on the «job» page; any content entered in this preview is ignored.',

    'level-min-languages-tooltip' => 'Please fill in at least one language for this level.',
    'delete-level-tooltip' => 'Delete this nomenclature level.',

    // Errori SQL (salvati nell'attributo "data-sql-error" del div#job-hierarchy-errors).
    // Nota: se il value di 'errMsg' deve contenere dei single o double-quote letterali, inserire
    //       rispettivamente i caratteri ’ o ” (saranno convertiti dalla funzione ajaxError() in "admin.js").
    'sql-error' => "[{ 'match':'customer_hierarchy.uq_customer_hierarchy_name','errMsg':" .
                      "'<b>Duplicated Nomenclature name</b>: a «Job Nomenclature» with this name already exist.' }," .
                    "{ 'match':'cust_hierarchy_lang.uq_cust_hierarchy_lang_name','errMsg':" .
                      "'<b>Duplicated Level Name</b>: multiple levels have the same «Level Name» for the same language.' }]",

    // Delete job nomenclature modal dialogBox.
    'delete-title' => 'Delete Job Nomenclature',
    'delete-body' => 'Are you sure you want to delete the selected Job Nomenclature?',

];
