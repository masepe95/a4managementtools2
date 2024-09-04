<?php

return [

    // Français.
    // Stringhe per la pagina 'personal-groups' di amministrazione.

    'title' => "Mes Groupes d'Utilisateurs",
    'description' => 'Les Groupes d\'Utilisateurs personnels peuvent être utilisés pour attribuer rapidement la visibilité de ses propres «<span class="a4-text-shade-100 font-bold">jobs</span>» à des Groupes prédéfinis de collègues.',

    'group-names-tooltip' => 'Nom du Groupe actuel.',
    'group-names-label' => "Nom du Groupe d'Utilisateurs",

    'new-group-name' => "Nom du nouveau Groupe d'Utilisateurs",
    'new-group-name-tooltip' => "Si ce champ est laissé vide, le nom du Groupe reste inchangé lorsque l'on appuie sur «:update».&#10;Pour créer un nouveau Groupe, le nom doit être différent de celui des Groupes existants.",
    'new-group-name-error' => 'Ce nom est déjà utilisé.',

    'group-list-selected' => 'utilisateurs sélectionnés',
    'group-list-tooltip' => 'Sélectionne les Utilisateurs à inclure dans le Groupe sélectionné ou dans un nouveau Groupe.',
    'group-list' => 'Utilisateurs du Groupe',

    'update-button-tooltip' => "Modifie le Groupe d'Utilisateurs sélectionné dans le comboBox «:name».",
    'delete-button-tooltip' => "Supprime le Groupe d'Utilisateurs sélectionné dans le comboBox «:name».",
    'add-button-tooltip' => "Ajoutez un nouveau Groupe d'Utilisateurs avec le nom spécifié dans le champ de texte «:newname».",

    // Errori SQL (salvati nell'attributo "data-sql-error" del div#personal-groups-errors).
    // Nota: se il value di 'errMsg' deve contenere dei single o double-quote letterali, inserire
    //       rispettivamente i caratteri ’ o ” (saranno convertiti dalla funzione ajaxError() in "admin.js").
    'sql-error' => "[{ 'match':'personal_group.uq_personal_group_group_name','errMsg':" .
                      "'<b>Nom de groupe en double</b>: vous avez déjà utilisé ce nom de «Groupe d’Utilisateurs».' }]",

    // Delete user group modal dialogBox.
    'delete-title' => "Supprimer le Groupe d'Utilisateurs",
    'delete-body' => "Etes-vous sûr de vouloir supprimer le Groupe d'Utilisateurs sélectionné?",

];
