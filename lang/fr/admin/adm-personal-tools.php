<?php

return [

    // Français.
    // Stringhe per la pagina 'personal-tools' di amministrazione.

    'title' => 'Tool Personnels',
    'description' => 'Gestion des Tools Personnels.',

    'employee' => 'Employé',
    'employee-tooltip' => 'Nom, prénom et email du salarié sélectionné.',

    'tools-visibility' => "Visibilité des Tools Personnels de l'employés",
    'tools-visibility-tooltip' => "Les Tools soulignés sont actuellement disponibles ou temporairement désactivés, sinon ils ne sont pas actuellement disponibles pour l'Employé sélectionné.",
    'tools-visibility-choices' =>  [
        'Y' => ['tooltip' => 'Tool disponible.', 'label' => 'Y'],
        'N' => ['tooltip' => 'Tool temporairement désactivé.', 'label' => 'D'],
        'none' => ['tooltip' => 'Tool non disponible.', 'label' => 'N'],
    ],
    'job-count' => '{0} (Aucun job)|{1} (1 job)|[2,*] (:count jobs)',

    // Personal tools' modal warning.
    'modal-title' => 'Suppression automatique des Jobs',
    'modal-body1' => 'Vous êtes sur le point de désactiver un ou plusieurs «<span class="a4-text-shade-100 font-bold">Tools</span>» de l\'employé impersonné.<br />Pour au moins un de ces <span class="a4-text-shade-100 font-bold">Tools Personnels</span>, certaines «<span class="a4-text-shade-100 font-bold">Jobs</span>» seront automatiquement supprimées.',
    'modal-body2' => 'Souhaitez-vous procéder à la mise à jour, à la désactivation des <span class="a4-text-shade-100 font-bold">Tools Personnels</span> et par conséquent à l\'élimination des <span class="a4-text-shade-100 font-bold">Jobs</span> associées?',

];
