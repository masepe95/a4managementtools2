<?php

return [

    // Deutsch.
    // Stringhe per la pagina 'employees' di amministrazione.

    'title' => 'Mitarbeiters',
    'title-tooltip' => 'Name der Organisation',
    'description' => 'Mitarbeiterführung.',

    'employee' => 'Mitarbeiter',
    'employee-tooltip' => 'Vor- und Nachname sowie E-Mail-Adresse des ausgewählten Mitarbeiters.',
    'update-button-tooltip' => 'Aktualisiere den Daten des ausgewählten Mitarbeiters in der «:employee» ComboBox.',
    'add-button-tooltip' => 'Füge einen neuen Mitarbeiter hinzu.',
    'delete-button-tooltip' => 'Lösche den Daten des ausgewählten Mitarbeiters in der «:employee» ComboBox.',

    'firstname' => 'Vorname',
    'lastname' => 'Nachname',
    'acronym' => 'Akronym',
    'employee-id' => 'ID',
    'mobile-phone' => 'Mobiltelefon',
    'phone' => 'Telefon',
    'email' => 'E-mail',
    'language' => 'Sprache',
    'language-tooltip' => 'Standard-Personalsprache.',
    'curr-password' => 'Aktuelles Passwort',
    'curr-password-tooltip' => 'Geben Sie das aktuelle Passwort ein, wenn Sie es ändern möchten.',
    'new-password' => 'Neues Passwort',
    'new-password-tooltip' => 'Neues Passwort, lassen Sie das Feld leer, wenn Sie es nicht ändern möchten.',
    'job-title' => 'Arbeitstitel',
    'role' => 'Rolle',
    'failed-passwords' => 'Falsche Passwörter',
    'failed-passwords-tooltip' => 'Anzahl der nacheinander eingegebenen falschen Passwörter (maximal 5, bevor der Mitarbeiter gesperrt wird).  Dieses Feld ist schreibgeschützt,  Klicken Sie auf die Schaltfläche «:reset», um den Zugang für den ausgewählten Mitarbeiter wieder zu aktivieren.',
    'reset-failed-passwords' => 'Zurücksetzen',
    'reset-failed-passwords-tooltip' => 'Setzt die Anzahl der fehlerhaften Passwörter zurück und schaltet den Zugang für den ausgewählten Mitarbeiter wieder frei.',
    'status' => 'Status',

    'employee-photo' => '<span>Ziehen Sie das Foto<br />des Mitarbeiters hierher<br />oder klicken Sie<br />in diesen Bereich</span>',
    'employee-photo-tooltip' => 'Ziehen Sie das Foto des Mitarbeiters hierher oder klicken Sie in diesen Bereich.&#10;Unterstützte Bildformate: JPG, PNG, GIF, SVG.',
    'employee-photo-delete' => 'Löscht das Foto des ausgewählten Mitarbeiters.',

    'tools-visibility' => 'Sichtbarkeit von Tools',
    'tools-visibility-choices' =>  [
        'write' => ['tooltip' => 'Tool zugänglich zum Lesen und Schreiben.', 'label' => 'W'],
        'read' => ['tooltip' => 'Tool nur zum Lesen zugänglich.', 'label' => 'R'],
        'none' => ['tooltip' => 'Tool nicht zugänglich.', 'label' => 'X'],
    ],

    // Errori SQL (salvati nell'attributo "data-sql-error" del div#employees-errors).
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

    // Delete employees dialogBox.
    'delete-title' => 'Mitarbeiter löschen',
    'delete-body' => 'Sind Sie sicher, dass Sie den ausgewählten Mitarbeiter löschen möchten?',

];
