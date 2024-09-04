<?php

return [

    // Deutsch.
    // Stringhe per la pagina 'global-options' di amministrazione.

    'title' => 'Globale Optionen',
    'description' => 'Globale Einstellungen gültig für alle Kunden.',

    'default-language' => 'Standardsprache',
    'default-language-tooltip' => 'Standardsprache, falls keine individuelle festgelegt ist.',
    'signup-pending-timeout' => 'Anmelde-Timeout (Minuten)',
    'signup-pending-timeout-tooltip' => 'Maximale Zeit für die Bestätigung der Anmeldung (in Minuten).&#10;Bitte geben Sie einen numerischen Wert ein (mindestens 10).',
    'min-password-length' => 'Mindestlänge des Passworts (Zeichen)',
    'min-password-length-tooltip' => 'Bitte geben Sie einen numerischen Wert ein (mindestens 8 Zeichen).',
    'max-password-failures' => 'Maximale Anzahl falscher Passwörter',
    'max-password-failures-tooltip' => 'Nach Überschreiten dieses Limits wird der Benutzerzugang gesperrt und nach der im Feld «:recovering» angegebenen Zeit oder explizit durch den Administrator wieder aktiviert.&#10;Wenn auf 0 gesetzt, ist das Limit für falsche Passwörter deaktiviert.',
    'max-password-failures-error' => 'Bitte geben Sie einen numerischen Wert ein (mindestens 0).',
    'recovering-access-delay' => 'Zeit zur Wiederherstellung des Zugangs (Minuten)',
    'recovering-access-delay-tooltip' => 'Wird ein Wert über 0 eingestellt, wird der Zugang nach dieser Zeit automatisch wieder aktiviert; ist der Wert 0, muss der Benutzerzugang vom Administrator wiederhergestellt werden.',
    'recovering-access-delay-error' => 'Bitte geben Sie einen numerischen Wert ein (mindestens 0).',
    'support-email' => 'Support-E-Mail',
    'support-email-tooltip' => 'Bitte füllen Sie dieses Feld korrekt aus oder lassen Sie es leer.',
    'maintenance' => 'Wartung',
    'maintenance-tooltip' => 'Wartungsstatus.',
    'maintenance-on' => 'In Wartung',
    'maintenance-redirect' => 'Weiterleitung',
    'maintenance-off' => 'Seite aktiv',
    'redirect-url' => 'Weiterleitungs-URL',
    'redirect-url-tooltip' => "Weiterleitungsadresse, wenn das «:maintenance» comboBox mit der ':redirect' Option eingestellt ist.",
    'banner' => 'Wartungsbanner',
    'banner-tooltip' => 'Aktivieren oder deaktivieren Sie das Informationsbanner für einen Wartungszeitraum.',
    'banner-yes' => 'Ja',
    'banner-no' => 'Nein',
    'maintenance-start' => 'Beginn der Wartung',
    'maintenance-start-tooltip' => 'Beginn des Wartungszeitraums.',
    'maintenance-end' => 'Ende der Wartung',
    'maintenance-end-tooltip' => 'Ende des Wartungszeitraums.',

];
