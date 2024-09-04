<?php

return [

    // Deutsch.
    // Stringhe per la pagina 'profile' di amministrazione.

    'title' => 'Meine Persönlichen Daten',
    'description' => 'Profilverwaltung.',

    'firstname' => 'Vorname',
    'lastname' => 'Nachname',
    'acronym' => 'Akronym',
    'employee-id' => 'ID',
    'mobile-phone' => 'Mobiltelefon',
    'phone' => 'Telefon',
    'email' => 'E-Mail',
    'language' => 'Sprache',
    'language-tooltip' => 'Standard-Personalsprache.',
    'curr-password' => 'Aktuelles Passwort',
    'curr-password-tooltip' => 'Geben Sie das aktuelle Passwort ein, wenn Sie es ändern möchten.',
    'new-password' => 'Neues Passwort',
    'new-password-tooltip' => 'Neues Passwort, lassen Sie das Feld leer, wenn Sie es nicht ändern möchten.',
    'job-title' => 'Arbeitstitel',
    'role' => 'Rolle',

    'profile-photo' => '<span>Ziehe dein Foto<br />hierhin oder klicke<br />in diesen Bereich</span>',
    'profile-photo-tooltip' => 'Ziehe dein Foto hierhin oder klicke in diesen Bereich.&#10;Unterstützte Bildformate: JPG, PNG, GIF, SVG.',
    'profile-photo-delete' => 'Ihr Foto löschen.',

    // Errori SQL (salvati nell'attributo "data-sql-error" del div#profile-errors).
    // Nota: se il value di 'errMsg' deve contenere dei single o double-quote letterali, inserire
    //       rispettivamente i caratteri ’ o ” (saranno convertiti dalla funzione ajaxError() in "admin.js").
    // Nota: l'errore della key 'uq_employee_email_password' va inserita prima della 'uq_employee_email',
    //       in caso contrario, indexof() ritornerebbe sempre la entry 'uq_employee_email'.
    'sql-error' => "[{ 'match':'employee.uq_employee_email_password','errMsg':" .
                      "'<b>Ungültiges Passwort</b>: Bitte verwenden Sie ein anderes «Passwort».' }," .
                    "{ 'match':'employee.uq_employee_email','errMsg':" .
                      "'<b>Doppelte E-Mail</b>: Ein anderer Mitarbeiter verwendet bereits diese «E-Mail» Adresse.' }," .
                    "{ 'match':'employee.uq_employee_acronym','errMsg':" .
                      "'<b>Doppeltes Akronym</b>: Ein anderer Mitarbeiter verwendet dieses «Acronym» bereits.' }," .
                    "{ 'match':'employee.uq_employee_employee_id','errMsg':" .
                      "'<b>Doppelte ID</b>: Ein anderer Mitarbeiter verwendet diese «ID» bereits.' }]",

];
