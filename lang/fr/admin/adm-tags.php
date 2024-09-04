<?php

return [

    // Français.
    // Stringhe per la pagina 'tags' di amministrazione.

    'title' => 'Tags',
    'description' => 'Gestion des Tags, après avoir créé toutes les Tags souhaitées, associez-les aux «<span class="a4-text-shade-100 font-bold">tools</span>» sur la page «<span class="menu-link a4-text-shade-100 font-bold hover:underline hover:cursor-pointer" data-link-page="adm-tools-tags" title="Accédez à la page \'Tool/Tags\'.">Tool/Tags</span>».',

    'tag' => 'Tag',
    'tag-tooltip' => 'Tag actuelle.',
    'update-button-tooltip' => 'Modifier le Tag sélectionné dans la comboBox «:tag».',
    'add-button-tooltip' => 'Ajoutez un nouveau Tag.',
    'delete-button-tooltip' => 'Supprimez le Tag sélectionné dans la comboBox «:tag».',

    'tag-minimum-language' => 'Pour ajouter un nouveaux Tag, remplissez au moins un nom dans une langue.',

    // Errori SQL (salvati nell'attributo "data-sql-error" del div#tags-errors).
    // Nota: se il value di 'errMsg' deve contenere dei single o double-quote letterali, inserire
    //       rispettivamente i caratteri ’ o ” (saranno convertiti dalla funzione ajaxError() in "admin.js").
    'sql-error' => "[{ 'match':'tag_lang.uq_tag_lang_tag_name','errMsg':" .
                      "'<b>Nom de Tag dupliqué</b>: chaque nom de Tag doit être unique, même entre différentes langues.' }]",

    // Delete tags dialogBox.
    'delete-title' => 'Supprimer le Tag',
    'delete-body' => 'Etes-vous sûr de vouloir supprimer le Tag sélectionné?',

];
