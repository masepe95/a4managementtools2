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

    'accepted' => 'Il campo :attribute deve essere accettato.',
    'accepted_if' => 'Il campo :attribute deve essere accettato quando :other è :value.',
    'active_url' => 'Il campo :attribute deve essere un URL valido.',
    'after' => 'Il campo :attribute deve essere una data successiva a :date.',
    'after_or_equal' => 'Il campo :attribute deve essere una data uguale o successiva a :date.',
    'alpha' => 'Il campo :attribute deve contenere solo lettere.',
    'alpha_dash' => 'Il campo :attribute deve contenere solo lettere, numeri, trattini e underscore.',
    'alpha_num' => 'Il campo :attribute deve contenere solo lettere e numeri.',
    'array' => 'Il campo :attribute deve essere un array.',
    'ascii' => 'Il campo :attribute deve contenere solo caratteri alfanumerici e simboli a byte singolo.',
    'before' => 'Il campo :attribute deve essere una data precedente a :date.',
    'before_or_equal' => 'Il campo :attribute deve essere una data precedente o uguale a :date.',
    'between' => [
        'array' => 'Il campo :attribute deve contenere un numero di elemente compreso tra :min e :max.',
        'file' => 'Il campo :attribute deve essere compreso tra :min e :max kilobyte.',
        'numeric' => 'Il campo :attribute deve essere un valore compreso tra :min e :max.',
        'string' => 'Il campo :attribute deve avere un numero di caratteri compreso tra :min e :max.',
    ],
    'boolean' => 'Il campo :attribute deve essere vero o falso.',
    'confirmed' => 'La conferma del campo :attribute non corrisponde.',
    'current_password' => 'La password è incorretta.',
    'date' => 'Il campo :attribute deve essere una data valida.',
    'date_equals' => 'Il campo :attribute deve essere una data uguale a :date.',
    'date_format' => 'Il campo :attribute deve corrispondere al formato :format.',
    'decimal' => 'Il campo :attribute deve avere :decimal decimali.',
    'declined' => 'Il campo :attribute deve essere rifiutato.',
    'declined_if' => 'Il campo :attribute deve essere rifiutato quando :other è :value.',
    'different' => 'I campi :attribute e :other devono essere diversi.',
    'digits' => 'Il campo :attribute deve avere :digits cifre.',
    'digits_between' => 'Il campo :attribute deve avere tra :min e :max cifre.',
    'dimensions' => "Il campo :attribute ha dimensioni dell'immagine non valide.",
    'distinct' => 'Il campo :attribute ha un valore duplicato.',
    'doesnt_end_with' => 'Il campo :attribute non deve terminare con uno dei seguenti valori: :values.',
    'doesnt_start_with' => 'Il campo :attribute non deve iniziare con uno dei seguenti valori: :values.',
    'email' => 'Il campo :attribute deve essere un indirizzo email valido.',
    'ends_with' => 'Il campo :attribute deve terminare con uno dei seguenti valori: :values.',
    'enum' => 'Il :attribute selezionato non è valido.',
    'exists' => 'Il :attribute selezionato non è valido.',
    'file' => 'Il campo :attribute deve essere un file.',
    'filled' => 'Il campo :attribute deve avere un valore.',
    'gt' => [
        'array' => 'Il campo :attribute deve contenere più di :value elementi.',
        'file' => 'Il campo :attribute deve essere maggiore di :value kilobyte.',
        'numeric' => 'Il campo :attribute deve essere maggiore di :value.',
        'string' => 'Il campo :attribute deve contenere più di :value caratteri.',
    ],
    'gte' => [
        'array' => 'Il campo :attribute deve contenere :value elementi o più.',
        'file' => 'Il campo :attribute deve essere maggiore o uguale a :value kilobyte.',
        'numeric' => 'Il campo :attribute deve essere maggiore o uguale a :value.',
        'string' => 'Il campo :attribute deve contenere più o uguale a :value caratteri.',
    ],
    'image' => "Il campo :attribute deve essere un'immagine.",
    'in' => 'Il :attribute selezionato non è valido.',
    'in_array' => 'Il campo :attribute deve esistere in :other.',
    'integer' => 'Il campo :attribute deve essere un numero intero.',
    'ip' => 'Il campo :attribute deve essere un indirizzo IP valido.',
    'ipv4' => 'Il campo :attribute deve essere un indirizzo IPv4 valido.',
    'ipv6' => 'Il campo :attribute deve essere un indirizzo IPv6 valido.',
    'json' => 'Il campo :attribute deve essere una stringa JSON valida.',
    'lowercase' => 'Il campo :attribute deve essere in minuscolo.',
    'lt' => [
        'array' => 'Il campo :attribute deve contenere meno di :value elementi.',
        'file' => 'Il campo :attribute deve essere inferiore a :value kilobyte.',
        'numeric' => 'Il campo :attribute deve essere inferiore a :value.',
        'string' => 'Il campo :attribute deve contenere meno di :value caratteri.',
    ],
    'lte' => [
        'array' => 'Il campo :attribute non deve contenere più di :value elementi.',
        'file' => 'Il campo :attribute deve essere inferiore o uguale a :value kilobyte.',
        'numeric' => 'Il campo :attribute deve essere inferiore o uguale a :value.',
        'string' => 'Il campo :attribute deve contenere meno o uguale a :value caratteri.',
    ],
    'mac_address' => 'Il campo :attribute deve essere un indirizzo MAC valido.',
    'max' => [
        'array' => 'Il campo :attribute non deve contenere più di :max elementi.',
        'file' => 'Il campo :attribute non deve essere maggiore di :max kilobyte.',
        'numeric' => 'Il campo :attribute non deve essere maggiore di :max.',
        'string' => 'Il campo :attribute non deve essere maggiore di :max caratteri.',
    ],
    'max_digits' => 'Il campo :attribute non deve avere più di :max cifre.',
    'mimes' => 'Il campo :attribute deve essere un file di tipo: :values.',
    'mimetypes' => 'Il campo :attribute deve essere un file di tipo: :values.',
    'min' => [
        'array' => 'Il campo :attribute deve avere almeno :min elementi.',
        'file' => 'Il campo :attribute deve essere di almeno :min kilobyte.',
        'numeric' => 'Il campo :attribute deve essere almeno :min.',
        'string' => 'Il campo :attribute deve contenere almeno :min caratteri.',
    ],
    'min_digits' => 'Il campo :attribute deve avere almeno :min cifre.',
    'missing' => 'Il campo :attribute deve essere assente.',
    'missing_if' => 'Il campo :attribute deve essere assente quando :other è :value.',
    'missing_unless' => 'Il campo :attribute deve essere assente a meno che :other non sia :value.',
    'missing_with' => 'Il campo :attribute deve essere assente quando :values è presente.',
    'missing_with_all' => 'Il campo :attribute deve essere assente quando :values sono presenti.',
    'multiple_of' => 'Il campo :attribute deve essere un multiplo di :value.',
    'not_in' => 'Il :attribute selezionato non è valido.',
    'not_regex' => 'Il formato del campo :attribute non è valido.',
    'numeric' => 'Il campo :attribute deve essere un numero.',
    'password' => [
        'letters' => 'Il campo :attribute deve contenere almeno una lettera.',
        'mixed' => 'Il campo :attribute deve contenere almeno una lettera maiuscola e una lettera minuscola.',
        'numbers' => 'Il campo :attribute deve contenere almeno un numero.',
        'symbols' => 'Il campo :attribute deve contenere almeno un simbolo.',
        'uncompromised' => 'Il :attribute fornito è comparso in una violazione dei dati. Scegliere un :attribute diverso.',
    ],
    'present' => 'Il campo :attribute deve essere presente.',
    'prohibited' => 'Il campo :attribute è proibito.',
    'prohibited_if' => 'Il campo :attribute è proibito quando :other è :value.',
    'prohibited_unless' => 'Il campo :attribute è proibito a meno che :other sia tra :values.',
    'prohibits' => 'Il campo :attribute vieta la presenza di :other.',
    'regex' => 'Il formato del campo :attribute non è valido.',
    'required' => 'Il campo :attribute è obbligatorio.',
    'required_array_keys' => 'Il campo :attribute deve contenere voci per: :values.',
    'required_if' => 'Il campo :attribute è obbligatorio quando :other è :value.',
    'required_if_accepted' => 'Il campo :attribute è obbligatorio quando :other è accettato.',
    'required_unless' => 'Il campo :attribute è obbligatorio a meno che :other sia tra :values.',
    'required_with' => 'Il campo :attribute è obbligatorio quando :values è presente.',
    'required_with_all' => 'Il campo :attribute è obbligatorio quando :values sono presenti.',
    'required_without' => 'Il campo :attribute è obbligatorio quando :values non è presente.',
    'required_without_all' => 'Il campo :attribute è obbligatorio quando nessuno tra :values è presente.',
    'same' => 'Il campo :attribute deve corrispondere a :other.',
    'size' => [
        'array' => 'Il campo :attribute deve contenere :size elementi.',
        'file' => 'Il campo :attribute deve essere di :size kilobyte.',
        'numeric' => 'Il campo :attribute deve essere :size.',
        'string' => 'Il campo :attribute deve contenere :size caratteri.',
    ],
    'starts_with' => 'Il campo :attribute deve iniziare con uno dei seguenti: :values.',
    'string' => 'Il campo :attribute deve essere una stringa.',
    'timezone' => 'Il campo :attribute deve essere un fuso orario valido.',
    'unique' => ':attribute è già stato preso.',
    'uploaded' => 'Il caricamento di :attribute è fallito.',
    'uppercase' => 'Il campo :attribute deve essere in maiuscolo.',
    'url' => 'Il campo :attribute deve essere un URL valido.',
    'ulid' => 'Il campo :attribute deve essere un ULID valido.',
    'uuid' => 'Il campo :attribute deve essere un UUID valido.',

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
            'size' => "Injection dell'id di gerarchia.",
        ],
        'hier-name-blocks' => [
            'size' => 'Il numero di livelli validi deve essere :size.',
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
