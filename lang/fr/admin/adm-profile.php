<?php

return [

    // Français.
    // Stringhe per la pagina 'profile' di amministrazione.

    'title' => 'Mes Données Personnelles',
    'description' => 'Gestion de votre Profil.',

    'firstname' => 'Prénom',
    'lastname' => 'Nom',
    'acronym' => 'Acronyme',
    'employee-id' => "Id de l'employé",
    'mobile-phone' => 'Portable',
    'phone' => 'Téléphone',
    'email' => 'E-mail',
    'language' => 'Langue',
    'language-tooltip' => 'Langue Personnelle par défaut.',
    'curr-password' => 'Mot de passe actuel',
    'curr-password-tooltip' => 'Entrez le mot de passe actuel si vous souhaitez le modifier.',
    'new-password' => 'Nouveau mot de passe',
    'new-password-tooltip' => 'Nouveau mot de passe, laissez le champ vide si vous ne souhaitez pas le modifier.',
    'job-title' => 'Titre du travail',
    'role' => 'Rôle',

    'profile-photo' => '<span>Glissez-déposez<br />votre photo ici<br />ou cliquez dessus</span>',
    'profile-photo-tooltip' => "Glissez-déposez votre photo ici ou cliquez dessus.&#10;Formats d'image supportés: JPG, PNG, GIF, SVG.",
    'profile-photo-delete' => 'Effacer votre photo.',

    // Errori SQL (salvati nell'attributo "data-sql-error" del div#profile-errors).
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

];
