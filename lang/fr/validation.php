<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'Le champ :attribute doit être accepté.',
    'accepted_if' => 'Le champ :attribute doit être accepté lorsque :other est :value.',
    'active_url' => 'Le champ :attribute doit être une URL valide.',
    'after' => 'Le champ :attribute doit être une date après :date.',
    'after_or_equal' => 'Le champ :attribute doit être une date après ou égale à :date.',
    'alpha' => 'Le champ :attribute doit contenir uniquement des lettres.',
    'alpha_dash' => 'Le champ :attribute ne doit contenir que des lettres, des chiffres, des tirets et des underscores.',
    'alpha_num' => 'Le champ :attribute doit contenir uniquement des lettres et des chiffres.',
    'array' => 'Le champ :attribute doit être un tableau.',
    'ascii' => "Le champ :attribute doit contenir uniquement des caractères alphanumériques et des symboles d'un octet.",
    'before' => 'Le champ :attribute doit être une date avant :date.',
    'before_or_equal' => 'Le champ :attribute doit être une date avant ou égale à :date.',
    'between' => [
        'array' => 'Le champ :attribute doit avoir entre :min et :max éléments.',
        'file' => 'Le champ :attribute doit être compris entre :min et :max kilooctets.',
        'numeric' => 'Le champ :attribute doit être compris entre :min et :max.',
        'string' => 'Le champ :attribute doit contenir entre :min et :max caractères.',
    ],
    'boolean' => 'Le champ :attribute doit être vrai ou faux.',
    'confirmed' => 'La confirmation du champ :attribute ne correspond pas.',
    'current_password' => 'Le mot de passe est incorrect.',
    'date' => 'Le champ :attribute doit être une date valide.',
    'date_equals' => 'Le champ :attribute doit être une date égale à :date.',
    'date_format' => 'Le champ :attribute doit correspondre au format :format.',
    'decimal' => 'Le champ :attribute doit avoir :decimal décimales.',
    'declined' => 'Le champ :attribute doit être refusé.',
    'declined_if' => 'Le champ :attribute doit être refusé lorsque :other est :value.',
    'different' => 'Le champ :attribute et :other doivent être différents.',
    'digits' => 'Le champ :attribute doit comporter :digits chiffres.',
    'digits_between' => 'Le champ :attribute doit comporter entre :min et :max chiffres.',
    'dimensions' => "Le champ :attribute a des dimensions d'image non valides.",
    'distinct' => 'Le champ :attribute a une valeur en double.',
    'doesnt_end_with' => "Le champ :attribute ne doit pas se terminer par l'un des éléments suivants : :values.",
    'doesnt_start_with' => "Le champ :attribute ne doit pas commencer par l'un des éléments suivants : :values.",
    'email' => 'Le champ :attribute doit être une adresse e-mail valide.',
    'ends_with' => "Le champ :attribute doit se terminer par l'un des éléments suivants : :values.",
    'enum' => 'La sélection de :attribute est invalide.',
    'exists' => 'La sélection de :attribute est invalide.',
    'file' => 'Le champ :attribute doit être un fichier.',
    'filled' => 'Le champ :attribute doit avoir une valeur.',
    'gt' => [
        'array' => 'Le champ :attribute doit comporter plus de :value éléments.',
        'file' => 'Le champ :attribute doit être supérieur à :value kilooctets.',
        'numeric' => 'Le champ :attribute doit être supérieur à :value.',
        'string' => 'Le champ :attribute doit contenir plus de :value caractères.',
    ],
    'gte' => [
        'array' => 'Le champ :attribute doit comporter :value éléments ou plus.',
        'file' => 'Le champ :attribute doit être supérieur ou égal à :value kilooctets.',
        'numeric' => 'Le champ :attribute doit être supérieur ou égal à :value.',
        'string' => 'Le champ :attribute doit contenir :value caractères ou plus.',
    ],
    'image' => 'Le champ :attribute doit être une image.',
    'in' => 'La sélection de :attribute est invalide.',
    'in_array' => 'Le champ :attribute doit exister dans :other.',
    'integer' => 'Le champ :attribute doit être un entier.',
    'ip' => 'Le champ :attribute doit être une adresse IP valide.',
    'ipv4' => 'Le champ :attribute doit être une adresse IPv4 valide.',
    'ipv6' => 'Le champ :attribute doit être une adresse IPv6 valide.',
    'json' => 'Le champ :attribute doit être une chaîne JSON valide.',
    'lowercase' => 'Le champ :attribute doit être en minuscules.',
    'lt' => [
        'array' => 'Le champ :attribute doit comporter moins de :value éléments.',
        'file' => 'Le champ :attribute doit être inférieur à :value kilooctets.',
        'numeric' => 'Le champ :attribute doit être inférieur à :value.',
        'string' => 'Le champ :attribute doit contenir moins de :value caractères.',
    ],
    'lte' => [
        'array' => 'Le champ :attribute ne doit pas comporter plus de :value éléments.',
        'file' => 'Le champ :attribute doit être inférieur ou égal à :value kilooctets.',
        'numeric' => 'Le champ :attribute doit être inférieur ou égal à :value.',
        'string' => 'Le champ :attribute doit contenir :value caractères ou moins.',
    ],
    'mac_address' => 'Le champ :attribute doit être une adresse MAC valide.',
    'max' => [
        'array' => 'Le champ :attribute ne doit pas comporter plus de :max éléments.',
        'file' => 'Le champ :attribute ne doit pas dépasser :max kilooctets.',
        'numeric' => 'Le champ :attribute ne doit pas être supérieur à :max.',
        'string' => 'Le champ :attribute ne doit pas dépasser :max caractères.',
    ],
    'max_digits' => 'Le champ :attribute ne doit pas contenir plus de :max chiffres.',
    'mimes' => 'Le champ :attribute doit être un fichier de type :values.',
    'mimetypes' => 'Le champ :attribute doit être un fichier de type :values.',
    'min' => [
        'array' => 'Le champ :attribute doit contenir au moins :min éléments.',
        'file' => 'Le champ :attribute doit avoir au moins :min kilo-octets.',
        'numeric' => 'Le champ :attribute doit être au moins de :min.',
        'string' => 'Le champ :attribute doit contenir au moins :min caractères.',
    ],
    'min_digits' => 'Le champ :attribute doit contenir au moins :min chiffres.',
    'missing' => 'Le champ :attribute doit être manquant.',
    'missing_if' => 'Le champ :attribute doit être manquant lorsque :other est :value.',
    'missing_unless' => 'Le champ :attribute doit être manquant sauf si :other est :value.',
    'missing_with' => 'Le champ :attribute doit être manquant lorsque :values est présent.',
    'missing_with_all' => 'Le champ :attribute doit être manquant lorsque :values sont présents.',
    'multiple_of' => 'Le champ :attribute doit être un multiple de :value.',
    'not_in' => "Le :attribute sélectionné n'est pas valide.",
    'not_regex' => "Le format du champ :attribute n'est pas valide.",
    'numeric' => 'Le champ :attribute doit être un nombre.',
    'password' => [
        'letters' => 'Le champ :attribute doit contenir au moins une lettre.',
        'mixed' => 'Le champ :attribute doit contenir au moins une lettre majuscule et une lettre minuscule.',
        'numbers' => 'Le champ :attribute doit contenir au moins un chiffre.',
        'symbols' => 'Le champ :attribute doit contenir au moins un symbole.',
        'uncompromised' => 'Le :attribute donné est apparu dans une fuite de données. Veuillez choisir un autre :attribute.',
    ],
    'present' => 'Le champ :attribute doit être présent.',
    'prohibited' => 'Le champ :attribute est interdit.',
    'prohibited_if' => 'Le champ :attribute est interdit lorsque :other est :value.',
    'prohibited_unless' => 'Le champ :attribute est interdit sauf si :other est dans :values.',
    'prohibits' => 'Le champ :attribute interdit la présence de :other.',
    'regex' => "Le format du champ :attribute n'est pas valide.",
    'required' => 'Le champ :attribute est obligatoire.',
    'required_array_keys' => 'Le champ :attribute doit contenir des entrées pour :values.',
    'required_if' => 'Le champ :attribute est obligatoire lorsque :other est :value.',
    'required_if_accepted' => 'Le champ :attribute est obligatoire lorsque :other est accepté.',
    'required_unless' => 'Le champ :attribute est obligatoire sauf si :other est dans :values.',
    'required_with' => 'Le champ :attribute est obligatoire lorsque :values est présent.',
    'required_with_all' => 'Le champ :attribute est obligatoire lorsque :values sont présents.',
    'required_without' => "Le champ :attribute est obligatoire lorsque :values n'est pas présent.",
    'required_without_all' => "Le champ :attribute est obligatoire lorsque aucun des :values n'est présent.",
    'same' => 'Le champ :attribute doit correspondre à :other.',
    'size' => [
        'array' => 'Le champ :attribute doit contenir :size éléments.',
        'file' => 'Le champ :attribute doit avoir :size kilo-octets.',
        'numeric' => 'Le champ :attribute doit être de :size.',
        'string' => 'Le champ :attribute doit contenir :size caractères.',
    ],
    'starts_with' => "Le champ :attribute doit commencer par l'un des éléments suivants : :values.",
    'string' => 'Le champ :attribute doit être une chaîne de caractères.',
    'timezone' => 'Le champ :attribute doit être un fuseau horaire valide.',
    'unique' => ':attribute a déjà été pris(e).',
    'uploaded' => 'Le chargement de :attribute a échoué.',
    'uppercase' => 'Le champ :attribute doit être en majuscules.',
    'url' => 'Le champ :attribute doit être une URL valide.',
    'ulid' => 'Le champ :attribute doit être un ULID valide.',
    'uuid' => 'Le champ :attribute doit être un UUID valide.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [  // Esempio di utilizzo fornito da Laravel.
            'rule-name' => 'custom-message',
        ],
        // Personal Job Hierarchy page.
        'hier-injected' => [
            'size' => "Injection d'identifiant de hiérarchie.",
        ],
        'hier-name-blocks' => [
            'size' => 'Le nombre de niveaux valides doit être de :size.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [
        // Profile page.
        'profile-firstname' => '«' . __('admin/adm-profile.firstname') . '»',
        'profile-lastname' => '«' . __('admin/adm-profile.lastname') . '»',
        'profile-acronym' => '«' . __('admin/adm-profile.acronym') . '»',
        'profile-id' => '«' . __('admin/adm-profile.employee-id') . '»',
        'profile-mobile-phone' => '«' . __('admin/adm-profile.mobile-phone') . '»',
        'profile-phone' => '«' . __('admin/adm-profile.phone') . '»',
        'profile-email' => '«' . __('admin/adm-profile.email') . '»',
        'profile-language-code' => '«' . __('admin/adm-profile.language') . '»',
        'profile-password' => '«' . __('admin/adm-profile.curr-password') . '»',
        'profile-password-new' => '«' . __('admin/adm-profile.new-password') . '»',

        // Personal Groups page.
        'user-new-grp-name' => '«' . __('admin/adm-personal-groups.new-group-name') . '»',
        'users-group-list' => '«' . __('admin/adm-personal-groups.group-list') . '»',

        // Personal Job Hierarchy page.
        'personal-new-job-hierarchy-name' => '«' . __('admin/adm-personal-job-hierarchy.new-hierarchy-name') . '»',
        'phier-level-count' => '«Level count»',

        // Customer page.
        'customer-name' => '«' . __('admin/adm-customer.name') . '»',
        'customer-company-uid' => '«' . __('admin/adm-customer.company-uid') . '»',
        'customer-address1' => '«' . __('admin/adm-customer.address1') . '»',
        'customer-address2' => '«' . __('admin/adm-customer.address2') . '»',
        'customer-city' => '«' . __('admin/adm-customer.city') . '»',
        'customer-zip' => '«' . __('admin/adm-customer.zip') . '»',
        'customer-country-state' => '«' . __('admin/adm-customer.country-state') . '»',
        'customer-vat' => '«' . __('admin/adm-customer.vat') . '»',
        'customer-number-users' => '«' . __('admin/adm-customer.number-users') . '»',
        'customer-type' => '«' . __('admin/adm-customer.customer-type') . '»',
        'customer-status' => '«' . __('admin/adm-customer.customer-status') . '»',
        'customer-use-saml' => '«' . __('admin/adm-customer.use-saml') . '»',

        // Customer Contacts page.
        'contact-firstname' => '«' . __('admin/adm-customer-contacts.firstname') . '»',
        'contact-lastname' => '«' . __('admin/adm-customer-contacts.lastname') . '»',
        'contact-email' => '«' . __('admin/adm-customer-contacts.email') . '»',
        'contact-additional-name' => '«' . __('admin/adm-customer-contacts.additional-name') . '»',
        'contact-mobile-phone' => '«' . __('admin/adm-customer-contacts.mobile-phone') . '»',
        'contact-phone' => '«' . __('admin/adm-customer-contacts.phone') . '»',
        'contact-job-title' => '«' . __('admin/adm-customer-contacts.job-title') . '»',
        'contact-notes' => '«' . __('admin/adm-customer-contacts.notes') . '»',

        // Job Hierarchy page.
        'new-job-hierarchy-name' => '«' . __('admin/adm-job-hierarchy.new-hierarchy-name') . '»',
        'hier-level-count' => '«Level count»',

        // Employees page.
        'employee-firstname' => '«' . __('admin/adm-employees.firstname') . '»',
        'employee-lastname' => '«' . __('admin/adm-employees.lastname') . '»',
        'employee-acronym' => '«' . __('admin/adm-employees.acronym') . '»',
        'employee-employee-id' => '«' . __('admin/adm-employees.employee-id') . '»',
        'employee-mobile-phone' => '«' . __('admin/adm-employees.mobile-phone') . '»',
        'employee-phone' => '«' . __('admin/adm-employees.phone') . '»',
        'employee-email' => '«' . __('admin/adm-employees.email') . '»',
        'employee-language-code' => '«' . __('admin/adm-employees.language') . '»',
        'employee-password' => '«' . __('admin/adm-employees.curr-password') . '»',
        'employee-password-new' => '«' . __('admin/adm-employees.new-password') . '»',
        'employee-job-title' => '«' . __('admin/adm-employees.job-title') . '»',
        'employee-role' => '«' . __('admin/adm-employees.role') . '»',
        'employee-status' => '«' . __('admin/adm-employees.status') . '»',

        // Tools page.
        'tools-name-id' => '«' . __('admin/adm-tools.tool-id') . '»',
        'tools-title-id' => '«' . __('admin/adm-tools.tool-title') . '»',
        'tools-active' => '«' . __('admin/adm-tools.tool-active') . '»',

        // Languages page.
        'language-code' => '«' . __('admin/adm-languages.language-code') . '»',
        'language-name' => '«' . __('admin/adm-languages.language-name') . '»',
        'language-order' => '«' . __('admin/adm-languages.language-order') . '»',

    ],

];
