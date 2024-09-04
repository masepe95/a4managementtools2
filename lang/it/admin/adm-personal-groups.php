<?php

return [

    // Italiano.
    // Stringhe per la pagina 'personal-groups' di amministrazione.

    'title' => 'I miei Gruppi di Utenti',
    'description' => 'Gestione dei Gruppi Utenti personali, sono utilizzabili per assegnare velocemente la visibilità dei propri «<span class="a4-text-shade-100 font-bold">Job</span>» a Gruppi predefiniti di Utenti.',

    'group-names-tooltip' => 'Nome del Gruppo corrente.',
    'group-names-label' => 'Nome del Gruppo Utenti',

    'new-group-name' => 'Nome del nuovo Gruppo Utenti',
    'new-group-name-tooltip' => 'Se questo campo è lasciato vuoto, il nome del Gruppo rimane invariato quando si preme «:update».&#10;Per creare un nuovo Gruppo, il nome deve essere differente da quelli già esistenti.',
    'new-group-name-error' => 'Questo nome è già utilizzato.',

    'group-list-selected' => 'Utenti selezionati',
    'group-list-tooltip' => 'Seleziona gli Utenti da includere nel Gruppo selezionato o in un nuovo Gruppo.',
    'group-list' => 'Utenti del Gruppo',

    'update-button-tooltip' => 'Modifica il Gruppo Utenti selezionato nel comboBox «:name».',
    'delete-button-tooltip' => 'Elimina il Gruppo Utenti selezionato nel comboBox «:name».',
    'add-button-tooltip' => 'Aggiungi un nuovo Gruppo Utenti con il nome specificato nel campo di testo «:newname».',

    // Errori SQL (salvati nell'attributo "data-sql-error" del div#personal-groups-errors).
    // Nota: se il value di 'errMsg' deve contenere dei single o double-quote letterali, inserire
    //       rispettivamente i caratteri ’ o ” (saranno convertiti dalla funzione ajaxError() in "admin.js").
    'sql-error' => "[{ 'match':'personal_group.uq_personal_group_group_name','errMsg':" .
                      "'<b>Nome di gruppo duplicato</b>: hai già utilizzato questo nome di «Gruppo Utenti».' }]",

    // Delete user group modal dialogBox.
    'delete-title' => 'Elimina Gruppo Utenti',
    'delete-body' => 'Sei sicuro di voler eliminare il Gruppo di Utenti selezionato?',

];
