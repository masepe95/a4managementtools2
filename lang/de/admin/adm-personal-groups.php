<?php

return [

    // Deutsch.
    // Stringhe per la pagina 'personal-groups' di amministrazione.

    'title' => 'Meine Benutzergruppen',
    'description' => 'Persönliche Benutzergruppen können verwendet werden, um vordefinierten Gruppen von Kollegen schnell die Sichtbarkeit der eigenen «<span class="a4-text-shade-100 font-bold">Jobs</span>» zuzuweisen.',

    'group-names-tooltip' => 'Aktueller Gruppenname.',
    'group-names-label' => 'Name der Benutzergruppe',

    'new-group-name' => 'Name der neuen Benutzergruppe',
    'new-group-name-tooltip' => 'Wenn dieses Feld leer bleibt, bleibt der Gruppenname unverändert, wenn Sie auf «:update» klicken.&#10;Um eine neue Gruppe zu erstellen, muss sich der Name von den bestehenden Gruppen unterscheiden.',
    'new-group-name-error' => 'Dieser Name wird bereits verwendet.',

    'group-list-selected' => 'ausgewählte Benutzer',
    'group-list-tooltip' => 'Wählt die Benutzer aus, die in die ausgewählte Gruppe oder in eine neue Gruppe aufgenommen werden sollen.',
    'group-list' => 'Benutzer der Gruppe',

    'update-button-tooltip' => 'Ändert die in der ComboBox «:name» ausgewählte Benutzergruppe.',
    'delete-button-tooltip' => 'Löscht die im Kombinationsfeld «:name» gewählte Benutzergruppe.',
    'add-button-tooltip' => 'Hinzufügen einer neuen Benutzergruppe mit dem im Textfeld «:newname» angegebenen Namen.',

    // Errori SQL (salvati nell'attributo "data-sql-error" del div#personal-groups-errors).
    // Nota: se il value di 'errMsg' deve contenere dei single o double-quote letterali, inserire
    //       rispettivamente i caratteri ’ o ” (saranno convertiti dalla funzione ajaxError() in "admin.js").
    'sql-error' => "[{ 'match':'personal_group.uq_personal_group_group_name','errMsg':" .
                      "'<b>Doppelter Gruppenname</b>: Sie haben diesen «Benutzergruppen» Namen bereits verwendet.' }]",

    // Delete user group modal dialogBox.
    'delete-title' => 'Benutzergruppe löschen',
    'delete-body' => 'Sind Sie sicher, dass Sie die ausgewählte Benutzergruppe löschen möchten?',

];
