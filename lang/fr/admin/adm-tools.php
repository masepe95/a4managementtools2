<?php

return [

    // Français.
    // Stringhe per la pagina 'tools' di amministrazione.

    'title' => 'Tools',
    'description' => 'Gestion des «<span class="a4-text-shade-100 font-bold">Tool</span>».',

    'tool' => 'Tool',
    'update-button-tooltip' => 'Modifier le Tool sélectionné dans le comboBox «:tool».',
    'add-button-tooltip' => 'Ajoutez un nouveau Tool.',
    'delete-button-tooltip' => 'Supprimez le Tool sélectionné dans le comboBox «:tool».',

    'tool-id' => 'ID',
    'tool-id-tooltip' => 'Format: A4xxx (xxx = 001 - 999) ou A4xxxx (xxxx = 0001 - 9999).',
    'tool-title' => 'Titre',
    'tool-title-tooltip' => 'Lettres majuscules et minuscules uniquement, aucun espace autorisé.',
    'tool-active' => 'Activé',
    'tool-inactive' => 'Inactive',
    'related-tools' => 'Tool associés',
    'related-tools-selected' => 'tool sélectionnés',

    'tool-level' => 'Niveaux',
    'tool-level-executive' => 'Exécutif',
    'tool-level-advanced' => 'Avancé',
    'tool-level-intermediate' => 'Intermédiaire',

    'tool-recipient' => 'Destinataires',
    'tool-recipient-management' => 'Management',
    'tool-recipient-marketing' => 'Marketing',
    'tool-recipient-operations' => 'Opérations',
    'tool-recipient-rd' => 'Recherche et développement',

    'tool-usage' => 'Usage',
    'tool-usage-strategy' => 'Stratégie',
    'tool-usage-assessment' => 'Évaluation',
    'tool-usage-correctives' => 'Correctifs',
    'tool-usage-simplification' => 'Simplification',
    'tool-usage-delegation' => 'Délégation',
    'tool-usage-motivation' => "Motivation et constitution d'équipe",

    'tool-selection' => 'Sélection',
    'tool-selection-a-plus' => 'A+++',
    'tool-selection-eco' => 'Eco',
    'tool-selection-quick' => 'Quick',
    'tool-selection-top' => 'TOP',

    'tool-scope' => 'Ambito',
    'tool-scope-company-management' => "Gestion d'entreprise",
    'tool-scope-management' => 'Management',
    'tool-scope-team-management' => "Gestion d'équipe",
    'tool-scope-professional-development' => 'Développement professionnel',
    'tool-scope-individual-development' => 'Développement individuel et bien-être',

    // Errori SQL (salvati nell'attributo "data-sql-error" del div#tools-errors).
    // Nota: se il value di 'errMsg' deve contenere dei single o double-quote letterali, inserire
    //       rispettivamente i caratteri ’ o ” (saranno convertiti dalla funzione ajaxError() in "admin.js").
    'sql-error' => "[{ 'match':'tool.PRIMARY','errMsg':" .
                      "'<b>ID dupliqué</b>: un autre Tool utilise déjà cet «ID».' }," .
                    "{ 'match':'tool.uq_tool_title_id','errMsg':" .
                      "'<b>Titre dupliqué</b>: un autre Tool utilise déjà cet «Titre».' }," .
                    "{ 'match':'tool.chk_tool_title_id','errMsg':" .
                      "'<b>Titre vide</b>: le «Titre» de le Tool ne peut pas être vide.' }]",

    // Delete tools dialogBox.
    'delete-title' => 'Supprimer le Tool',
    'delete-body' => 'Etes-vous sûr de vouloir supprimer le Tool sélectionné?',

];
