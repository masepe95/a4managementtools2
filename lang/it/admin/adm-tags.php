<?php

return [

    // Italiano.
    // Stringhe per la pagina 'tags' di amministrazione.

    'title' => 'Tags',
    'description' => 'Gestione dei Tag, dopo aver creato tutti i Tag desiderati, associarli ai «<span class="a4-text-shade-100 font-bold">Tool</span>» nella pagina «<span class="menu-link a4-text-shade-100 font-bold hover:underline hover:cursor-pointer" data-link-page="adm-tools-tags" title="Vai alla pagina \'Tools/Tags\'.">Tools/Tags</span>».',

    'tag' => 'Tag',
    'tag-tooltip' => 'Tag corrente.',
    'update-button-tooltip' => 'Modifica il Tag selezionato nel comboBox «:tag».',
    'add-button-tooltip' => 'Aggiungi un nuovo Tag.',
    'delete-button-tooltip' => 'Elimina il Tag selezionato nel comboBox «:tag».',

    'tag-minimum-language' => 'Per aggiungere un nuovo Tag, compilare almeno un nome in una lingua.',

    // Errori SQL (salvati nell'attributo "data-sql-error" del div#tags-errors).
    // Nota: se il value di 'errMsg' deve contenere dei single o double-quote letterali, inserire
    //       rispettivamente i caratteri ’ o ” (saranno convertiti dalla funzione ajaxError() in "admin.js").
    'sql-error' => "[{ 'match':'tag_lang.uq_tag_lang_tag_name','errMsg':" .
                      "'<b>Nome Tag duplicato</b>: ogni nome di Tag deve essere univoco, anche tra lingue diverse.' }]",

    // Delete tags dialogBox.
    'delete-title' => 'Elimina Tag',
    'delete-body' => 'Sei sicuro di voler eliminare il Tag selezionato?',

];
