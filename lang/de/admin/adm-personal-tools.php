<?php

return [

    // Deutsch.
    // Stringhe per la pagina 'personal-tools' di amministrazione.

    'title' => 'Persönliche Tools',
    'description' => 'Verwaltung der persönlichen Tools.',

    'employee' => 'Mitarbeiter',
    'employee-tooltip' => 'Vor- und Nachname sowie E-Mail-Adresse der ausgewählten Mitarbeiter.',

    'tools-visibility' => 'Sichtbarkeit Persönlicher Tools der Mitarbeiter',
    'tools-visibility-tooltip' => 'Die unterstrichenen Tools sind derzeit verfügbar oder vorübergehend deaktiviert, andernfalls stehen sie dem ausgewählten Mitarbeiter derzeit nicht zur Verfügung.',
    'tools-visibility-choices' =>  [
        'Y' => ['tooltip' => 'Tool vorhanden.', 'label' => 'Y'],
        'N' => ['tooltip' => 'Tool vorübergehend deaktiviert.', 'label' => 'D'],
        'none' => ['tooltip' => 'Tool nicht verfügbar.', 'label' => 'N'],
    ],
    'job-count' => '{0} (Kein A4ManagementDoc)|{1} (1 A4ManagementDoc)|[2,*] (:count A4ManagementDocs)',

    // Personal tools' modal warning.
    'modal-title' => 'Automatisches Löschen von Jobs',
    'modal-body1' => 'Sie sind dabei, ein oder mehrere «<span class="a4-text-shade-100 font-bold">Tools</span>» der impersonierter Mitarbeiter zu deaktivieren.<br />Für mindestens eines dieser <span class="a4-text-shade-100 font-bold">Persönliche Tools</span> gibt es «<span class="a4-text-shade-100 font-bold">Jobs</span>», die automatisch gelöscht werden.',
    'modal-body2' => 'Möchten Sie mit der Aktualisierung, Deaktivierung der <span class="a4-text-shade-100 font-bold">Persönliche Tools</span> und der damit verbundenen Eliminierung der damit verbundenen <span class="a4-text-shade-100 font-bold">Jobs</span> fortfahren?',

];
