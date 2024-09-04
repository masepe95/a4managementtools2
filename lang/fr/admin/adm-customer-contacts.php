<?php

return [

    // Français.
    // Stringhe per la pagina 'customer-contacts' di amministrazione.

    'title' => "Contacts de l'Organisation",
    'title-tooltip' => "Nom de l'Organisation",
    'description' => "Gestion des contacts de l'Organisation.",

    'contact' => 'Contact',
    'contact-tooltip' => 'Nom, prénom et e-mail du contact sélectionné.',
    'update-button-tooltip' => 'Modifier le contact sélectionné dans le comboBox «:contact».',
    'add-button-tooltip' => 'Ajouter un nouveau contact.',
    'delete-button-tooltip' => 'Supprimer le contact sélectionné dans le comboBox «:contact».',

    'firstname' => 'Prénom',
    'lastname' => 'Nom',
    'email' => 'E-mail',
    'additional-name' => 'Nom additionnel',
    'mobile-phone' => 'Portable',
    'phone' => 'Téléphone',
    'job-title' => 'Titre du travail',
    'notes' => 'Notes personnelles',

    // Errori SQL (salvati nell'attributo "data-sql-error" del div#customer-contacts-errors).
    // Nota: se il value di 'errMsg' deve contenere dei single o double-quote letterali, inserire
    //       rispettivamente i caratteri ’ o ” (saranno convertiti dalla funzione ajaxError() in "admin.js").
    'sql-error' => "[{ 'match':'contact.uq_contact','errMsg':" .
                      "'<b>Contact en double</b>: un contact avec le même «Prénom», «Nom» et adresse «E-mail» existe déjà.' }]",

    // Delete contact modal dialogBox.
    'delete-title' => 'Supprimer le Contact',
    'delete-body' => 'Etes-vous sûr de vouloir supprimer le Contact sélectionné?',

];
