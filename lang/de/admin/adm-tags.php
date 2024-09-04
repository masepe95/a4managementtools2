<?php

return [

    // Deutsch.
    // Stringhe per la pagina 'tags' di amministrazione.

    'title' => 'Tags',
    'description' => 'Verwaltung von Tags, Nachdem Sie alle gewünschten Tags erstellt haben, verknüpfen Sie diese mit den «<span class="a4-text-shade-100 font-bold">tools</span>» auf der Seite «<span class="menu-link a4-text-shade-100 font-bold hover:underline hover:cursor-pointer" data-link-page="adm-tools-tags" title="Gehen Sie zur Seite \'Tool/Tags\'.">Tool/Tags</span>».',

    'tag' => 'Tag',
    'tag-tooltip' => 'Aktuelles Tag.',
    'update-button-tooltip' => 'Aktualisieren Sie das in der ComboBox «:tag» ausgewählte Tag.',
    'add-button-tooltip' => 'Fügen Sie ein neues Tag hinzu.',
    'delete-button-tooltip' => 'Löschen Sie das in der ComboBox «:tag» ausgewählte Tag.',

    'tag-minimum-language' => 'Um ein neues Tag hinzuzufügen, geben Sie mindestens einen Namen in einer Sprache ein.',

    // Errori SQL (salvati nell'attributo "data-sql-error" del div#tags-errors).
    // Nota: se il value di 'errMsg' deve contenere dei single o double-quote letterali, inserire
    //       rispettivamente i caratteri ’ o ” (saranno convertiti dalla funzione ajaxError() in "admin.js").
    'sql-error' => "[{ 'match':'tag_lang.uq_tag_lang_tag_name','errMsg':" .
                      "'<b>Doppelter Tag-Name</b>: Jeder Tag-Name muss eindeutig sein, auch zwischen verschiedenen Sprachen.' }]",

    // Delete tags dialogBox.
    'delete-title' => 'Tag löschen',
    'delete-body' => 'Sind Sie sicher, dass Sie das ausgewählte Tag löschen möchten?',

];
