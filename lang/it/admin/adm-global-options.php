<?php

return [

    // Italiano.
    // Stringhe per la pagina 'global-options' di amministrazione.

    'title' => 'Opzioni globali',
    'description' => 'Impostazioni globali valide per tutti i Clienti.',

    'default-language' => 'Lingua di default',
    'default-language-tooltip' => 'Lingua predefinita in mancanza di una personalizzata.',
    'signup-pending-timeout' => 'Timeout iscrizione (minuti)',
    'signup-pending-timeout-tooltip' => 'Tempo massimo per la conferma di iscrizione (in minuti).&#10;Si prega di compilare questo campo con un valore numerico (minimo 10).',
    'min-password-length' => 'Lunghezza minima password (caratteri)',
    'min-password-length-tooltip' => 'Si prega di compilare questo campo con un valore numerico (minimo 8 caratteri).',
    'max-password-failures' => 'Numero massimo password errate',
    'max-password-failures-tooltip' => "Superato questo limite, l'accesso dell'utente viene bloccato e si riattiva dopo il tempo specificato dal campo «:recovering» oppure esplicitamente dall'amministratore.&#10;Se impostato con 0, il limite di password errate è disabilitato.",
    'max-password-failures-error' => 'Si prega di compilare questo campo con un valore numerico (minimo 0).',
    'recovering-access-delay' => "Tempo di ripristino dell'accesso (minuti)",
    'recovering-access-delay-tooltip' => "Se si imposta un valore maggiore di 0, l'accesso si riattiva automaticamente trascorso questo tempo; se il valore è 0, l'accesso dell'utente deve essere ripristinato dall'amministratore.",
    'recovering-access-delay-error' => 'Si prega di compilare questo campo con un valore numerico (minimo 0).',
    'support-email' => 'E-mail di supporto',
    'support-email-tooltip' => 'Si prega di compilare correttamente questo campo o di lasciarlo vuoto.',
    'maintenance' => 'Manutenzione',
    'maintenance-tooltip' => 'Stato di manutenzione.',
    'maintenance-on' => 'Manutenzione',
    'maintenance-redirect' => 'Reindirizzamento',
    'maintenance-off' => 'Sito attivo',
    'redirect-url' => 'URL di reindirizzamento',
    'redirect-url-tooltip' => "Indirizzo di reindirizzamento se il comboBox «:maintenance» è impostato con l'opzione ':redirect'.",
    'banner' => 'Banner di manutenzione',
    'banner-tooltip' => 'Abilita o disabilita il banner informativo per un periodo di manutenzione.',
    'banner-yes' => 'Sì',
    'banner-no' => 'No',
    'maintenance-start' => 'Inizio manutenzione',
    'maintenance-start-tooltip' => 'Inizio del periodo di manutenzione.',
    'maintenance-end' => 'Fine manutenzione',
    'maintenance-end-tooltip' => 'Fine del periodo di manutenzione.',

];
