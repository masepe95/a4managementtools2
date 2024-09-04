<?php

return [

    // Italiano.
    // Stringhe per la pagina 'profile' di amministrazione.

    'title' => 'I miei Dati Personali',
    'description' => 'Gestione del tuo Profilo.',

    'firstname' => 'Nome',
    'lastname' => 'Cognome',
    'acronym' => 'Acronimo',
    'employee-id' => 'ID',
    'mobile-phone' => 'Cellulare',
    'phone' => 'Telefono',
    'email' => 'E-mail',
    'language' => 'Lingua',
    'language-tooltip' => 'Lingua Personale predefinita.',
    'curr-password' => 'Password corrente',
    'curr-password-tooltip' => 'Digitare la password corrente se si vuole modificarla.',
    'new-password' => 'Nuova Password',
    'new-password-tooltip' => 'Nuova Password, lasciare il campo vuoto se non si vuole modificarla.',
    'job-title' => 'Titolo di lavoro',
    'role' => 'Ruolo',

    'profile-photo' => "<span>Trascina<br />la tua foto qui<br />oppure clicca<br />in quest'area</span>",
    'profile-photo-tooltip' => "Trascina la tua foto qui oppure clicca in quest'area.&#10;Formati immagine supportati: JPG, PNG, GIF, SVG.",
    'profile-photo-delete' => 'Elimina la tua foto.',

    // Errori SQL (salvati nell'attributo "data-sql-error" del div#profile-errors).
    // Nota: se il value di 'errMsg' deve contenere dei single o double-quote letterali, inserire
    //       rispettivamente i caratteri ’ o ” (saranno convertiti dalla funzione ajaxError() in "admin.js").
    // Nota: l'errore della key 'uq_employee_email_password' va inserita prima della 'uq_employee_email',
    //       in caso contrario, indexof() ritornerebbe sempre la entry 'uq_employee_email'.
    'sql-error' => "[{ 'match':'employee.uq_employee_email_password','errMsg':" .
                      "'<b>Password non valida</b>: utilizza un’altra «Password».' }," .
                    "{ 'match':'employee.uq_employee_email','errMsg':" .
                      "'<b>E-mail duplicata</b>: un altro collaboratore sta già utilizzando questo indirizzo «E-mail».' }," .
                    "{ 'match':'employee.uq_employee_acronym','errMsg':" .
                      "'<b>Acronimo duplicato</b>: un altro collaboratore sta già utilizzando questo «Acronimo».' }," .
                    "{ 'match':'employee.uq_employee_employee_id','errMsg':" .
                      "'<b>ID duplicato</b>: un altro collaboratore sta già utilizzando questo «ID».' }]",

];
