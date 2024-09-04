<?php

return [

    // English.
    // Stringhe per la pagina 'personal-tools' di amministrazione.

    'title' => 'Personal Tools',
    'description' => 'Management of personal Tools.',

    'employee' => 'Employee',
    'employee-tooltip' => 'Name, surname and email of the selected employee.',

    'tools-visibility' => "Visibility of Employee's Personal Tools",
    'tools-visibility-tooltip' => 'The underlined Tools are currently available or temporarily disabled, otherwise, they are not currently available to the selected Employee.',
    'tools-visibility-choices' =>  [
        'Y' => ['tooltip' => 'Tool available.', 'label' => 'Y'],
        'N' => ['tooltip' => 'Tool temporarily disabled.', 'label' => 'D'],
        'none' => ['tooltip' => 'Tool not available.', 'label' => 'N'],
    ],
    'job-count' => '{0} (No jobs)|{1} (1 job)|[2,*] (:count jobs)',

    // Personal tools' modal warning.
    'modal-title' => 'Automatic deletion of Jobs',
    'modal-body1' => 'You are about to deactivate one or more «<span class="a4-text-shade-100 font-bold">Tools</span>» of the impersonated employee.<br />For at least one of these <span class="a4-text-shade-100 font-bold">Personal Tools</span> there are «<span class="a4-text-shade-100 font-bold">Jobs</span>» that will be automatically deleted.',
    'modal-body2' => 'Do you want to proceed with the update, deactivation of the <span class="a4-text-shade-100 font-bold">Personal Tools</span> and consequent elimination of the related <span class="a4-text-shade-100 font-bold">Jobs</span>?',

];
