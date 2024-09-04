<?php

return [

    // Italiano.
    // Stringhe per la pagina 'personal-tools' di amministrazione.

    'title' => 'Tool Personali',
    'description' => 'Gestione dei Tool Personali.',

    'employee' => 'Impiegato',
    'employee-tooltip' => "Nome, cognome e e-mail dell'impiegato selezionato.",

    'tools-visibility' => "Visibilità dei Tool Personali dell'Impiegato",
    'tools-visibility-tooltip' => "I Tool sottolineati sono attualmente disponibili o temporaneamente disabilitati, in caso contrario, non sono correntemente disponibili per l'Impiegato selezionato.",
    'tools-visibility-choices' =>  [
        'Y' => ['tooltip' => 'Tool disponibile.', 'label' => 'Y'],
        'N' => ['tooltip' => 'Tool temporaneamente disabilitato.', 'label' => 'D'],
        'none' => ['tooltip' => 'Tool non disponibile.', 'label' => 'N'],
    ],
    'job-count' => '{0} (Nessun A4ManagementDoc)|{1} (1 A4ManagementDoc)|[2,*] (:count A4ManagementDocs)',

    // Personal tools' modal warning.
    'modal-title' => 'Eliminazione automatica dei Job',
    'modal-body1' => 'Stai per disattivare uno o più «<span class="a4-text-shade-100 font-bold">Tool</span>» dell\'impiegato impersonato.<br />Per almeno uno di questi <span class="a4-text-shade-100 font-bold">Tool Personali</span> esistono dei «<span class="a4-text-shade-100 font-bold">Job Personali</span>» che saranno automaticamente eliminati.',
    'modal-body2' => 'Vuoi procedere con l\'aggiornamento, la disattivazione dei <span class="a4-text-shade-100 font-bold">Tool Personali</span> e conseguente eliminazione dei relativi <span class="a4-text-shade-100 font-bold">Job</span>?',

];
