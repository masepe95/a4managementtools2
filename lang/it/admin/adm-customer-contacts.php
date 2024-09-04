<?php

return [

    // Italiano.
    // Stringhe per la pagina 'customer-contacts' di amministrazione.

    'title' => 'Contatti Organizzazione',
    'title-tooltip' => "Nome dell'Organizzazione",
    'description' => "Gestione dei contatti dell'Organizzazione.",

    'contact' => 'Contatto',
    'contact-tooltip' => 'Nome, cognome e e-mail del contatto corrente.',
    'update-button-tooltip' => 'Modifica il contatto selezionato nel comboBox «:contact».',
    'add-button-tooltip' => 'Aggiungi un nuovo contatto.',
    'delete-button-tooltip' => 'Elimina il contatto selezionato nel comboBox «:contact».',

    'firstname' => 'Nome',
    'lastname' => 'Cognome',
    'email' => 'E-mail',
    'additional-name' => 'Nome addizionale',
    'mobile-phone' => 'Cellulare',
    'phone' => 'Telefono',
    'job-title' => 'Titolo di lavoro',
    'notes' => 'Note personali',

    // Errori SQL (salvati nell'attributo "data-sql-error" del div#customer-contacts-errors).
    // Nota: se il value di 'errMsg' deve contenere dei single o double-quote letterali, inserire
    //       rispettivamente i caratteri ’ o ” (saranno convertiti dalla funzione ajaxError() in "admin.js").
    'sql-error' => "[{ 'match':'contact.uq_contact','errMsg':" .
                      "'<b>Contatto duplicato</b>: un contatto con lo stesso «Nome», «Cognome» ed «E-mail» esiste già.' }]",

    // Delete contact modal dialogBox.
    'delete-title' => 'Elimina Contatto',
    'delete-body' => 'Sei sicuro di voler eliminare il Contatto selezionato?',

];
