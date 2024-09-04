<?php

return [

    // Français.
    // Stringhe per la pagina 'personal-job-hierarchy' di amministrazione.

    'title' => 'Mes Nomenclatures des Job',
    'description' => 'Gestion de la hiérarchie des Nomenclatures personnelles applicables aux «<span class="a4-text-shade-100 font-bold">Job</span>».',

    'hierarchy-names-tooltip' => 'Nom de la Nomenclature actuelle.',
    'hierarchy-names-label' => 'Nom de la Nomenclature',

    'new-hierarchy-name' => 'Nom de la nouvelle Nomenclature',
    'new-hierarchy-name-tooltip' => 'Si ce champ est laissé vide, le nom de la Nomenclature reste inchangé lorsque vous appuyez sur le bouton «:update».&#10;Pour créer une nouvelle Nomenclature, le nom doit être différent de ceux déjà existants.',
    'new-hierarchy-name-error' => 'Ce nom est déjà utilisé.',

    'update-button-tooltip' => 'Actualiser la Nomenclature sélectionnée dans la liste déroulante «:name».',
    'delete-button-tooltip' => 'Supprimer la Nomenclature sélectionnée dans la liste déroulante «:name».',
    'add-button-tooltip' => 'Ajouter une nouvelle Nomenclature avec le nom spécifié dans le champ de texte «:newname».',

    'add-level-button-tooltip' => 'Ajouter un niveau de Nomenclature, maximum 4 niveaux.',
    'preview-label' => 'Avant-première',

    'level-number-tooltip' => 'Niveau :level',
    'level-short' => 'N',
    'level-info-tooltip' => 'Ce champ sera obligatoire dans la page des «Job», tout contenu saisi dans cet avant-première sera ignoré.',

    'level-min-languages-tooltip' => 'Veuillez remplir au moins une langue pour ce niveau.',
    'delete-level-tooltip' => 'Supprimer ce niveau de Nomenclature.',

    // Errori SQL (salvati nell'attributo "data-sql-error" del div#personal-job-hierarchy-errors).
    // Nota: se il value di 'errMsg' deve contenere dei single o double-quote letterali, inserire
    //       rispettivamente i caratteri ’ o ” (saranno convertiti dalla funzione ajaxError() in "admin.js").
    'sql-error' => "[{ 'match':'employee_hierarchy.uq_employee_hierarchy_name','errMsg':" .
                      "'<b>Nom de la Nomenclature dupliqué</b>: une «Nom de Nomenclature» portant ce nom existe déjà.' }," .
                    "{ 'match':'empl_hierarchy_lang.uq_empl_hierarchy_lang_name','errMsg':" .
                      "'<b>Nom de Niveau dupliqué</b>: plusieurs niveaux ont le même «Nom de Niveau» pour la même langue.' }]",

    // Delete job nomenclature modal dialogBox.
    'delete-title' => 'Supprimer la Nomenclature de Job',
    'delete-body' => 'Etes-vous sûr de vouloir supprimer la Nomenclature de Job sélectionnée?',

];
