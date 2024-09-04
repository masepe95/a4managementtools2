<?php

return [

    // English.
    // Stringhe per la pagina 'languages' di amministrazione.

    'title' => 'Languages',
    'description' => 'Management of languages.',

    'language' => 'Language',
    'update-button-tooltip' => 'Update the language selected in the «:language» comboBox.',
    'add-button-tooltip' => 'Add a new language.',
    'delete-button-tooltip' => 'Delete the language selected in the «:language» comboBox.',

    'language-data' => 'To add a new language, all fields must be valid.',
    'language-name' => 'Language name',
    'language-name-tooltip' => 'Please fill this field with at least one alphabetic character (any initial and trailing spaces are removed).',
    'language-code' => 'Language code',
    'language-code-tooltip' => 'Enter the ISO 639-1 code of the language (2 lowercase letters).',
    'language-order' => 'Language priority',
    'language-order-tooltip' => 'A smaller numeric value indicates a higher priority.',

    // Errori SQL (salvati nell'attributo "data-sql-error" del div#languages-errors).
    // Nota: se il value di 'errMsg' deve contenere dei single o double-quote letterali, inserire
    //       rispettivamente i caratteri ’ o ” (saranno convertiti dalla funzione ajaxError() in "admin.js").
    'sql-error' => "[{ 'match':'language.PRIMARY','errMsg':" .
                      "'<b>Duplicated Language code</b>: each Language must have a unique Code.' },
                     { 'match':'language.uq_language_name','errMsg':" .
                      "'<b>Duplicated Language name</b>: each Language must have a unique Name.' },
                     { 'match':'ON DELETE RESTRICT','errMsg':" .
                      "'<b>Language is in use</b>: you cannot delete a Language used in at least one table.' }]",

    // Delete languages dialogBox.
    'delete-title' => 'Delete Language',
    'delete-body' => 'Are you sure you want to delete the selected Language?<br /><br />If the Language you are about to delete is in use in at least one table, the operation will be aborted and an error will be displayed.',

];
