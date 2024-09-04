<?php

return [

    // English.
    // Stringhe per la pagina 'tags' di amministrazione.

    'title' => 'Tags',
    'description' => 'Management of Tags, after creating all the desired Tags, associate them with the «<span class="a4-text-shade-100 font-bold">tool</span>» on the «<span class="menu-link a4-text-shade-100 font-bold hover:underline hover:cursor-pointer" data-link-page="adm-tools-tags" title="Go to the \'Tool/Tags\' page.">Tool/Tags</span>» page.',

    'tag' => 'Tag',
    'tag-tooltip' => 'Current Tag.',
    'update-button-tooltip' => 'Update the selected Tag in the «:tag» comboBox.',
    'add-button-tooltip' => 'Add a new Tag.',
    'delete-button-tooltip' => 'Delete the selected Tag in the «:tag» comboBox.',

    'tag-minimum-language' => 'To add a new Tag, fill in at least one name in one language.',

    // Errori SQL (salvati nell'attributo "data-sql-error" del div#tags-errors).
    // Nota: se il value di 'errMsg' deve contenere dei single o double-quote letterali, inserire
    //       rispettivamente i caratteri ’ o ” (saranno convertiti dalla funzione ajaxError() in "admin.js").
    'sql-error' => "[{ 'match':'tag_lang.uq_tag_lang_tag_name','errMsg':" .
                      "'<b>Duplicated Tag name</b>: each Tag name must be unique, even between different languages.' }]",

    // Delete tags dialogBox.
    'delete-title' => 'Delete Tag',
    'delete-body' => 'Are you sure you want to delete the selected Tag?',

];
