<?php

return [

    // Italiano.
    // Stringhe per la pagina 'employees' di amministrazione.

    'title' => 'Impiegati',
    'title-tooltip' => "Nome dell'Organizzazione",
    'description' => 'Gestione degli Impiegati.',

    'employee' => 'Impiegato',
    'employee-tooltip' => "Nome, cognome e e-mail dell'Impiegato corrente.",
    'update-button-tooltip' => "Modifica i dati dell'Impiegato selezionato nel comboBox «:employee».",
    'add-button-tooltip' => 'Aggiungi un nuovo Impiegato.',
    'delete-button-tooltip' => "Elimina i dati dell'Impiegato selezionato nel comboBox «:employee».",

    'firstname' => 'Nome',
    'lastname' => 'Cognome',
    'acronym' => 'Acronimo',
    'employee-id' => 'ID',
    'mobile-phone' => 'Cellulare',
    'phone' => 'Telefono',
    'email' => 'E-mail',
    'language' => 'Lingua',
    'language-tooltip' => 'Lingua personale predefinita.',
    'curr-password' => 'Password corrente',
    'curr-password-tooltip' => 'Digitare la Password corrente se si vuole modificarla.',
    'new-password' => 'Nuova Password',
    'new-password-tooltip' => 'Nuova Password, lasciare il campo vuoto se non si vuole modificarla.',
    'job-title' => 'Titolo di lavoro',
    'role' => 'Ruolo',
    'failed-passwords' => 'Password errate',
    'failed-passwords-tooltip' => "Numero di Password errate inserite consecutivamente (massimo 5 prima del blocco dell'Impiegato).  Questo campo è in sola lettura, cliccare il bottone «:reset» per riabilitare l'accesso dell'Impiegato selezionato.",
    'reset-failed-passwords' => 'Resetta',
    'reset-failed-passwords-tooltip' => "Resetta il numero di Password errate e riabilita l'accesso dell'Impiegato selezionato.",
    'status' => 'Stato',

    'employee-photo' => "<span>Trascina qui la<br />foto dell'Impiegato<br />oppure clicca<br />in quest'area</span>",
    'employee-photo-tooltip' => "Trascina qui la foto dell'Impiegato oppure clicca in quest'area.&#10;Formati immagine supportati: JPG, PNG, GIF, SVG.",
    'employee-photo-delete' => "Elimina la foto dell'Impiegato selezionato.",

    'tools-visibility' => 'Visibilità dei Tool',
    'tools-visibility-choices' =>  [
        'write' => ['tooltip' => 'Tool accessibile in lettura e scrittura.', 'label' => 'W'],
        'read' => ['tooltip' => 'Tool accessibile solo in lettura.', 'label' => 'R'],
        'none' => ['tooltip' => 'Tool non accessibile.', 'label' => 'X'],
    ],

    // Errori SQL (salvati nell'attributo "data-sql-error" del div#employees-errors).
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

    // Delete employees dialogBox.
    'delete-title' => 'Elimina Impiegato',
    'delete-body' => "Sei sicuro di voler eliminare l'Impiegato selezionato?",

];
