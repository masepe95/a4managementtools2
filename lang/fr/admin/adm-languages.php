<?php

return [

    // Français.
    // Stringhe per la pagina 'languages' di amministrazione.

    'title' => 'Langues',
    'description' => 'Gestion des langues.',

    'language' => 'Langue',
    'update-button-tooltip' => 'Modifier la langue sélectionnée dans la comboBox «:language».',
    'add-button-tooltip' => 'Ajoutez une nouvelle langue.',
    'delete-button-tooltip' => 'Supprimez la langue sélectionnée dans la comboBox «:language».',

    'language-data' => 'Pour ajouter une nouvelle langue, tous les champs doivent être valides.',
    'language-name' => 'Nom de la langue',
    'language-name-tooltip' => 'Veuillez remplir ce champ avec au moins un caractère alphabétique (tous les espaces initial ou final sont éliminés).',
    'language-code' => 'Code de la langue',
    'language-code-tooltip' => 'Entrez le code ISO 639-1 de la langue (2 lettres minuscules).',
    'language-order' => 'Priorité de la langue',
    'language-order-tooltip' => 'Une valeur numérique plus petite indique une priorité plus élevée.',

    // Errori SQL (salvati nell'attributo "data-sql-error" del div#languages-errors).
    // Nota: se il value di 'errMsg' deve contenere dei single o double-quote letterali, inserire
    //       rispettivamente i caratteri ’ o ” (saranno convertiti dalla funzione ajaxError() in "admin.js").
    'sql-error' => "[{ 'match':'language.PRIMARY','errMsg':" .
                      "'<b>Code de la langue dupliqué</b>: chaque Langue doit avoir un Code unique.' },
                     { 'match':'language.uq_language_name','errMsg':" .
                      "'<b>Nom de la langue dupliqué</b>: chaque Langue doit avoir un Nom unique.' },
                     { 'match':'ON DELETE RESTRICT','errMsg':" .
                      "'<b>La langue est utilisée</b>: vous ne pouvez pas supprimer une langue utilisée dans au moins une table.' }]",

    // Delete languages dialogBox.
    'delete-title' => 'Supprimer la langue',
    'delete-body' => "Êtes-vous sûr de vouloir supprimer la langue sélectionnée?<br /><br />Si la langue que vous êtes sur le point de supprimer est utilisée dans au moins une table, l'opération sera annulée et une erreur s'affichera.",

];
