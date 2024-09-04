<?php

return [

    // Français.
    // Stringhe per la pagina 'global-options' di amministrazione.

    'title' => 'Options Globales',
    'description' => 'Paramètres globaux valables pour tous les Clients.',

    'default-language' => 'Langue par défaut',
    'default-language-tooltip' => "Langue par défaut en l'absence d'une personnalisée.",
    'signup-pending-timeout' => "Délai d'inscription (minutes)",
    'signup-pending-timeout-tooltip' => 'Temps maximum pour la confirmation d’inscription (en minutes).&#10;Veuillez saisir une valeur numérique (minimum 10).',
    'min-password-length' => 'Longueur minimale du mot de passe (caractères)',
    'min-password-length-tooltip' => 'Veuillez saisir une valeur numérique (minimum 8 caractères).',
    'max-password-failures' => 'Nombre maximal de mots de passe incorrects',
    'max-password-failures-tooltip' => "Une fois cette limite dépassée, l'accès de l'utilisateur est bloqué et réactivé après le temps spécifié dans le champ «:recovering» ou explicitement par l'administrateur.&#10;Si réglé sur 0, la limite de mots de passe incorrects est désactivée.",
    'max-password-failures-error' => 'Veuillez saisir une valeur numérique (minimum 0).',
    'recovering-access-delay' => "Délai de rétablissement de l'accès (minutes)",
    'recovering-access-delay-tooltip' => "Si une valeur supérieure à 0 est définie, l'accès est automatiquement réactivé après ce temps ; si la valeur est 0, l'accès de l'utilisateur doit être rétabli par l'administrateur.",
    'recovering-access-delay-error' => 'Veuillez saisir une valeur numérique (minimum 0).',
    'support-email' => 'E-mail de support',
    'support-email-tooltip' => 'Veuillez remplir correctement ce champ ou le laisser vide.',
    'maintenance' => 'Maintenance',
    'maintenance-tooltip' => 'État de maintenance.',
    'maintenance-on' => 'En Maintenance',
    'maintenance-redirect' => 'Redirection',
    'maintenance-off' => 'Site Actif',
    'redirect-url' => 'URL de redirection',
    'redirect-url-tooltip' => "Adresse de redirection si le comboBox «:maintenance» est réglé avec l'option ':redirect'.",
    'banner' => 'Bannière de maintenance',
    'banner-tooltip' => 'Activer ou désactiver la bannière informative pour une période de maintenance.',
    'banner-yes' => 'Oui',
    'banner-no' => 'No',
    'maintenance-start' => 'Début de la maintenance',
    'maintenance-start-tooltip' => 'Début de la période de maintenance.',
    'maintenance-end' => 'Fin de la maintenance',
    'maintenance-end-tooltip' => 'Fin de la période de maintenance.',

];
