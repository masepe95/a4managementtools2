<?php

return [

    // Deutsch.
    // Stringhe per la pagina 'customer-contacts' di amministrazione.

    'title' => 'Kontakte der Kundenorganisation',
    'title-tooltip' => 'Name der Organisation',
    'description' => 'Verwaltung der Kontakte der Kundenorganisation.',

    'contact' => 'Kontakt',
    'contact-tooltip' => 'Vorname, Nachname und E-Mail des aktuellen Kontakts.',
    'update-button-tooltip' => 'Bearbeiten Sie den im ComboBox «:contact» ausgewählten Kontakt.',
    'add-button-tooltip' => 'Einen neuen Kontakt hinzufügen.',
    'delete-button-tooltip' => 'Löschen Sie den im ComboBox «:contact» ausgewählten Kontakt.',

    'firstname' => 'Vorname',
    'lastname' => 'Nachname',
    'email' => 'E-Mail',
    'additional-name' => 'Zusätzlicher Name',
    'mobile-phone' => 'Handy',
    'phone' => 'Telefon',
    'job-title' => 'Berufsbezeichnung',
    'notes' => 'Persönliche Notizen',

    // Errori SQL (salvati nell'attributo "data-sql-error" del div#customer-contacts-errors).
    // Nota: se il value di 'errMsg' deve contenere dei single o double-quote letterali, inserire
    //       rispettivamente i caratteri ’ o ” (saranno convertiti dalla funzione ajaxError() in "admin.js").
    'sql-error' => "[{ 'match':'contact.uq_contact','errMsg':" .
                      "'<b>Doppelter Kontakt</b>: ein Kontakt mit demselben «Vorname», «Nachname» und derselben «E-Mail»-Adresse ist bereits vorhanden.' }]",

    // Delete contact modal dialogBox.
    'delete-title' => 'Kontakt löschen',
    'delete-body' => 'Sind Sie sicher, dass Sie den ausgewählten Kontakt löschen möchten?',

];
