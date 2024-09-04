<?php

return [

    // Deutsch.
    // Stringhe per la pagina 'languages' di amministrazione.

    'title' => 'Sprachen',
    'description' => 'Verwaltung von Sprachen.',

    'language' => 'Sprache',
    'update-button-tooltip' => 'Ändern Sie die in der «:language» ComboBox ausgewählte Sprache.',
    'add-button-tooltip' => 'Eine neue Sprache hinzufügen.',
    'delete-button-tooltip' => 'Löschen Sie die in der «:language» ComboBox ausgewählte Sprache.',

    'language-data' => 'Um eine neue Sprache hinzuzufügen, müssen alle Felder gültig sein.',
    'language-name' => 'Name der Sprache',
    'language-name-tooltip' => 'Bitte füllen Sie dieses Feld mit mindestens einem alphabetischen Zeichen aus (Anfangs- und Endräume werden entfernt).',
    'language-code' => 'Sprachcode',
    'language-code-tooltip' => 'Geben Sie den ISO 639-1 Code der Sprache ein (2 Kleinbuchstaben).',
    'language-order' => 'Priorität der Sprache',
    'language-order-tooltip' => 'Ein kleinerer numerischer Wert zeigt eine höhere Priorität an.',

    // Errori SQL (salvati nell'attributo "data-sql-error" del div#languages-errors).
    // Nota: se il value di 'errMsg' deve contenere dei single o double-quote letterali, inserire
    //       rispettivamente i caratteri ’ o ” (saranno convertiti dalla funzione ajaxError() in "admin.js").
    'sql-error' => "[{ 'match':'language.PRIMARY','errMsg':" .
                      "'<b>Doppelter Sprachcode</b>: Jede Sprache muss einen eindeutigen Code haben.' },
                     { 'match':'language.uq_language_name','errMsg':" .
                      "'<b>Doppelter Sprachname</b>: Jede Sprache muss einen eindeutigen Namen haben.' },
                     { 'match':'ON DELETE RESTRICT','errMsg':" .
                      "'<b>Sprache wird verwendet</b>: Sie können eine Sprache, die in mindestens einer Tabelle verwendet wird, nicht löschen.' }]",

    // Delete languages dialogBox.
    'delete-title' => 'Sprache löschen',
    'delete-body' => 'Sind Sie sicher, dass Sie die ausgewählte Sprache löschen möchten?<br /><br />Wenn die Sprache, die Sie löschen möchten, in mindestens einer Tabelle verwendet wird, wird der Vorgang abgebrochen und eine Fehlermeldung angezeigt.',

];
