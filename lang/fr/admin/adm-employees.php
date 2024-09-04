<?php

return [

    // Français.
    // Stringhe per la pagina 'employees' di amministrazione.

    'title' => 'Employés',
    'title-tooltip' => "Nom de l'Organisation",
    'description' => 'Gestion des Employés.',

    'employee' => 'Employé',
    'employee-tooltip' => 'Nom, prénom et email du salarié sélectionné.',
    'update-button-tooltip' => "Modifier les données de l'Employé sélectionné dans la comboBox «:employee».",
    'add-button-tooltip' => 'Ajouter un nouveau Employé.',
    'delete-button-tooltip' => "Supprimer les données de l'Employé sélectionné dans la comboBox «:employee».",

    'firstname' => 'Prénom',
    'lastname' => 'Nom',
    'acronym' => 'Acronyme',
    'employee-id' => "Id de l'Employé",
    'mobile-phone' => 'Portable',
    'phone' => 'Téléphone',
    'email' => 'E-mail',
    'language' => 'Langue',
    'language-tooltip' => 'Langue personnelle par défaut.',
    'curr-password' => 'Mot de passe actuel',
    'curr-password-tooltip' => 'Entrez le mot de passe actuel si vous souhaitez le modifier.',
    'new-password' => 'Nouveau mot de passe',
    'new-password-tooltip' => 'Nouveau mot de passe, laissez le champ vide si vous ne souhaitez pas le modifier.',
    'job-title' => 'Titre du travail',
    'role' => 'Rôle',
    'failed-passwords' => 'Mots de passe incorrects',
    'failed-passwords-tooltip' => "Nombre de mots de passe incorrects saisis consécutivement (5 au maximum avant que l'Employé ne soit bloqué).  Ce champ est en lecture seule, cliquez sur le bouton «:reset» pour réactiver l'accès de l'Employé sélectionné.",
    'reset-failed-passwords' => 'Réinitialise',
    'reset-failed-passwords-tooltip' => "Réinitialise le nombre de mots de passe incorrects et réactive l'accès pour l'Employé sélectionné.",
    'status' => 'Status',

    'employee-photo' => "<span>Glissez-déposez<br />la photo de l'Employé ici<br />ou cliquez dessus</span>",
    'employee-photo-tooltip' => "Glissez-déposez la photo de l'Employé ici ou cliquez dessus.&#10;Formats d'image supportés: JPG, PNG, GIF, SVG.",
    'employee-photo-delete' => "Effacer la photo de l'Employé sélectionné.",

    'tools-visibility' => 'Visibilité des outils',
    'tools-visibility-choices' =>  [
        'write' => ['tooltip' => "Tool accessible pour la lecture et l'écriture.", 'label' => 'W'],
        'read' => ['tooltip' => 'Tool accessible en lecture uniquement.', 'label' => 'R'],
        'none' => ['tooltip' => 'Tool non accessible.', 'label' => 'X'],
    ],

    // Errori SQL (salvati nell'attributo "data-sql-error" del div#employees-errors).
    // Nota: se il value di 'errMsg' deve contenere dei single o double-quote letterali, inserire
    //       rispettivamente i caratteri ’ o ” (saranno convertiti dalla funzione ajaxError() in "admin.js").
    // Nota: l'errore della key 'uq_employee_email_password' va inserita prima della 'uq_employee_email',
    //       in caso contrario, indexof() ritornerebbe sempre la entry 'uq_employee_email'.
    'sql-error' => "[{ 'match':'employee.uq_employee_email_password','errMsg':" .
                      "'<b>Mot de passe invalide</b>: veuillez utiliser un autre «Mot de passe».' }," .
                    "{ 'match':'employee.uq_employee_email','errMsg':" .
                      "'<b>E-mail dupliqué</b>: un autre collaborateur utilise déjà cette adresse «E-mail».' }," .
                    "{ 'match':'employee.uq_employee_acronym','errMsg':" .
                      "'<b>Acronyme dupliqué</b>: un autre collaborateur utilise déjà cet «Acronyme».' }," .
                    "{ 'match':'employee.uq_employee_employee_id','errMsg':" .
                      "'<b>ID dupliqué</b>: un autre collaborateur utilise déjà cet «ID».' }]",

    // Delete employees dialogBox.
    'delete-title' => "Supprimer l'Employé",
    'delete-body' => "Etes-vous sûr de vouloir supprimer l'Employé sélectionné?",

];
