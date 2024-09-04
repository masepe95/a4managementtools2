<?php

return [

    // English.
    // Stringhe per la pagina 'customer-contacts' di amministrazione.

    'title' => 'Customer Organization Contacts',
    'title-tooltip' => 'Name of the Organization',
    'description' => "Management of the Customer Organization's Contacts.",

    'contact' => 'Contact',
    'contact-tooltip' => 'First name, last name, and email of the current contact.',
    'update-button-tooltip' => 'Update the selected contact in the «:contact» comboBox.',
    'add-button-tooltip' => 'Add a new contact.',
    'delete-button-tooltip' => 'Delete the selected contact in the «:contact» comboBox.',

    'firstname' => 'Firstname',
    'lastname' => 'Lastname',
    'email' => 'Email',
    'additional-name' => 'Additional Name',
    'mobile-phone' => 'Mobile Phone',
    'phone' => 'Phone',
    'job-title' => 'Job title',
    'notes' => 'Personal Notes',

    // Errori SQL (salvati nell'attributo "data-sql-error" del div#customer-contacts-errors).
    // Nota: se il value di 'errMsg' deve contenere dei single o double-quote letterali, inserire
    //       rispettivamente i caratteri ’ o ” (saranno convertiti dalla funzione ajaxError() in "admin.js").
    'sql-error' => "[{ 'match':'contact.uq_contact','errMsg':" .
                      "'<b>Duplicated contact</b>: a contact with the same «Firstname», «Lastname» and «Email» already exists.' }]",

    // Delete contact modal dialogBox.
    'delete-title' => 'Delete Contact',
    'delete-body' => 'Are you sure you want to delete the selected Contact?',

];
