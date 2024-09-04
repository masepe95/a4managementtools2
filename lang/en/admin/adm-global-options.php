<?php

return [

    // English.
    // Stringhe per la pagina 'global-options' di amministrazione.

    'title' => 'Global Options',
    'description' => 'Global settings valid for all Clients.',

    'default-language' => 'Default language',
    'default-language-tooltip' => 'Default language if a custom one is not set.',
    'signup-pending-timeout' => 'Signup timeout (minutes)',
    'signup-pending-timeout-tooltip' => 'Maximum time for signup confirmation (in minutes).&#10;Please enter a numerical value (minimum 10).',
    'min-password-length' => 'Minimum password length (characters)',
    'min-password-length-tooltip' => 'Please enter a numerical value (minimum 8 characters).',
    'max-password-failures' => 'Maximum incorrect passwords',
    'max-password-failures-tooltip' => 'Once this limit is exceeded, user access is blocked and reactivated after the time specified in the field «:recovering» or explicitly by the administrator.&#10;If set to 0, the incorrect password limit is disabled.',
    'max-password-failures-error' => 'Please enter a numerical value (minimum 0).',
    'recovering-access-delay' => 'Access recovery time (minutes)',
    'recovering-access-delay-tooltip' => 'If a value greater than 0 is set, access is automatically reactivated after this time; if the value is 0, user access must be restored by the administrator.',
    'recovering-access-delay-error' => 'Please enter a numerical value (minimum 0).',
    'support-email' => 'Support email',
    'support-email-tooltip' => 'Please correctly fill out this field or leave it empty.',
    'maintenance' => 'Maintenance',
    'maintenance-tooltip' => 'Maintenance status.',
    'maintenance-on' => 'Under Maintenance',
    'maintenance-redirect' => 'Redirect',
    'maintenance-off' => 'Active Site',
    'redirect-url' => 'Redirect URL',
    'redirect-url-tooltip' => "Redirect address if the comboBox «:maintenance» is set with the ':redirect' option.",
    'banner' => 'Maintenance Banner',
    'banner-tooltip' => 'Enable or disable the informational banner for a maintenance period.',
    'banner-yes' => 'Yes',
    'banner-no' => 'No',
    'maintenance-start' => 'Maintenance Start',
    'maintenance-start-tooltip' => 'Start of the maintenance period.',
    'maintenance-end' => 'Maintenance End',
    'maintenance-end-tooltip' => 'End of the maintenance period.',

];
