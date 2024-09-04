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

    'accepted' => 'Das :attribute Feld muss akzeptiert werden.',
    'accepted_if' => 'Das :attribute Feld muss akzeptiert werden, wenn :other :value ist.',
    'active_url' => 'Das :attribute Feld muss eine gültige URL sein.',
    'after' => 'Das :attribute Feld muss ein Datum nach dem :date sein.',
    'after_or_equal' => 'Das :attribute Feld muss ein Datum nach oder gleich dem :date sein.',
    'alpha' => 'Das :attribute Feld darf nur Buchstaben enthalten.',
    'alpha_dash' => 'Das :attribute Feld darf nur Buchstaben, Zahlen, Bindestriche und Unterstriche enthalten.',
    'alpha_num' => 'Das :attribute Feld darf nur Buchstaben und Zahlen enthalten.',
    'array' => 'Das :attribute Feld muss ein Array sein.',
    'ascii' => 'Das :attribute Feld darf nur einbyte alphanumerische Zeichen und Symbole enthalten.',
    'before' => 'Das :attribute Feld muss ein Datum vor dem :date sein.',
    'before_or_equal' => 'Das :attribute Feld muss ein Datum vor oder gleich dem :date sein.',
    'between' => [
        'array' => 'Das :attribute Feld muss zwischen :min und :max Elementen haben.',
        'file' => 'Das :attribute Feld muss zwischen :min und :max Kilobytes groß sein.',
        'numeric' => 'Das :attribute Feld muss zwischen :min und :max liegen.',
        'string' => 'Das :attribute Feld muss zwischen :min und :max Zeichen lang sein.',
    ],
    'boolean' => 'Das :attribute Feld muss wahr oder falsch sein.',
    'confirmed' => 'Die Bestätigung des :attribute Feldes stimmt nicht überein.',
    'current_password' => 'Das Passwort ist falsch.',
    'date' => 'Das :attribute Feld muss ein gültiges Datum sein.',
    'date_equals' => 'Das :attribute Feld muss ein Datum gleich dem :date sein.',
    'date_format' => 'Das :attribute Feld muss dem Format :format entsprechen.',
    'decimal' => 'Das :attribute Feld muss :decimal Dezimalstellen haben.',
    'declined' => 'Das :attribute Feld muss abgelehnt werden.',
    'declined_if' => 'Das :attribute Feld muss abgelehnt werden, wenn :other :value ist.',
    'different' => 'Das :attribute Feld und :other müssen unterschiedlich sein.',
    'digits' => 'Das :attribute Feld muss :digits Ziffern haben.',
    'digits_between' => 'Das :attribute Feld muss zwischen :min und :max Ziffern haben.',
    'dimensions' => 'Das :attribute Feld hat ungültige Bildabmessungen.',
    'distinct' => 'Das :attribute Feld hat einen doppelten Wert.',
    'doesnt_end_with' => 'Das :attribute Feld darf nicht mit einem der folgenden Werte enden: :values.',
    'doesnt_start_with' => 'Das :attribute Feld darf nicht mit einem der folgenden Werte beginnen: :values.',
    'email' => 'Das :attribute Feld muss eine gültige E-Mail-Adresse sein.',
    'ends_with' => 'Das :attribute Feld muss mit einem der folgenden Werte enden: :values.',
    'enum' => 'Das ausgewählte :attribute ist ungültig.',
    'exists' => 'Das ausgewählte :attribute ist ungültig.',
    'file' => 'Das :attribute Feld muss eine Datei sein.',
    'filled' => 'Das :attribute Feld muss einen Wert haben.',
    'gt' => [
        'array' => 'Das :attribute Feld muss mehr als :value Elemente haben.',
        'file' => 'Das :attribute Feld muss größer als :value Kilobytes sein.',
        'numeric' => 'Das :attribute Feld muss größer als :value sein.',
        'string' => 'Das :attribute Feld muss mehr als :value Zeichen haben.',
    ],
    'gte' => [
        'array' => 'Das :attribute Feld muss :value oder mehr Elemente haben.',
        'file' => 'Das :attribute Feld muss gleich oder größer als :value Kilobytes sein.',
        'numeric' => 'Das :attribute Feld muss gleich oder größer als :value sein.',
        'string' => 'Das :attribute Feld muss gleich oder mehr als :value Zeichen haben.',
    ],
    'image' => 'Das :attribute Feld muss ein Bild sein.',
    'in' => 'Das ausgewählte :attribute ist ungültig.',
    'in_array' => 'Das :attribute Feld muss in :other vorhanden sein.',
    'integer' => 'Das :attribute Feld muss eine ganze Zahl sein.',
    'ip' => 'Das :attribute Feld muss eine gültige IP-Adresse sein.',
    'ipv4' => 'Das :attribute Feld muss eine gültige IPv4-Adresse sein.',
    'ipv6' => 'Das :attribute Feld muss eine gültige IPv6-Adresse sein.',
    'json' => 'Das :attribute Feld muss ein gültiger JSON-String sein.',
    'lowercase' => 'Das :attribute Feld muss in Kleinbuchstaben sein.',
    'lt' => [
        'array' => 'Das :attribute Feld muss weniger als :value Elemente haben.',
        'file' => 'Das :attribute Feld muss kleiner als :value Kilobytes sein.',
        'numeric' => 'Das :attribute Feld muss kleiner als :value sein.',
        'string' => 'Das :attribute Feld muss weniger als :value Zeichen haben.',
    ],
    'lte' => [
        'array' => 'Das :attribute Feld darf nicht mehr als :value Elemente haben.',
        'file' => 'Das :attribute Feld muss kleiner oder gleich :value Kilobytes sein.',
        'numeric' => 'Das :attribute Feld muss kleiner oder gleich :value sein.',
        'string' => 'Das :attribute Feld muss kleiner oder gleich :value Zeichen sein.',
    ],
    'mac_address' => 'Das :attribute Feld muss eine gültige MAC-Adresse sein.',
    'max' => [
        'array' => 'Das :attribute Feld darf nicht mehr als :max Elemente haben.',
        'file' => 'Das :attribute Feld darf nicht größer als :max Kilobytes sein.',
        'numeric' => 'Das :attribute Feld darf nicht größer als :max sein.',
        'string' => 'Das :attribute Feld darf nicht mehr als :max Zeichen sein.',
    ],
    'max_digits' => 'Das :attribute Feld darf nicht mehr als :max Ziffern haben.',
    'mimes' => 'Das :attribute Feld muss eine Datei des Typs: :values sein.',
    'mimetypes' => 'Das :attribute Feld muss eine Datei des Typs: :values sein.',
    'min' => [
        'array' => 'Das :attribute Feld muss mindestens :min Elemente haben.',
        'file' => 'Das :attribute Feld muss mindestens :min Kilobytes groß sein.',
        'numeric' => 'Das :attribute Feld muss mindestens :min sein.',
        'string' => 'Das :attribute Feld muss mindestens :min Zeichen lang sein.',
    ],
    'min_digits' => 'Das :attribute Feld muss mindestens :min Ziffern haben.',
    'missing' => 'Das :attribute Feld muss fehlen.',
    'missing_if' => 'Das :attribute Feld muss fehlen, wenn :other :value ist.',
    'missing_unless' => 'Das :attribute Feld muss fehlen, es sei denn, :other ist :value.',
    'missing_with' => 'Das :attribute Feld muss fehlen, wenn :values vorhanden ist.',
    'missing_with_all' => 'Das :attribute Feld muss fehlen, wenn alle :values vorhanden sind.',
    'multiple_of' => 'Das :attribute Feld muss ein Vielfaches von :value sein.',
    'not_in' => 'Das ausgewählte :attribute ist ungültig.',
    'not_regex' => 'Das Format des :attribute Feldes ist ungültig.',
    'numeric' => 'Das :attribute Feld muss eine Zahl sein.',
    'password' => [
        'letters' => 'Das :attribute Feld muss mindestens einen Buchstaben enthalten.',
        'mixed' => 'Das :attribute Feld muss mindestens einen Groß- und einen Kleinbuchstaben enthalten.',
        'numbers' => 'Das :attribute Feld muss mindestens eine Zahl enthalten.',
        'symbols' => 'Das :attribute Feld muss mindestens ein Symbol enthalten.',
        'uncompromised' => 'Das angegebene :attribute ist in einem Datenleck aufgetreten. Bitte wählen Sie ein anderes :attribute.',
    ],
    'present' => 'Das :attribute Feld muss vorhanden sein.',
    'prohibited' => 'Das :attribute Feld ist verboten.',
    'prohibited_if' => 'Das :attribute Feld ist verboten, wenn :other :value ist.',
    'prohibited_unless' => 'Das :attribute Feld ist verboten, es sei denn, :other befindet sich in :values.',
    'prohibits' => 'Das :attribute Feld verbietet das Vorhandensein von :other.',
    'regex' => 'Das Format des :attribute Feldes ist ungültig.',
    'required' => 'Das :attribute Feld ist erforderlich.',
    'required_array_keys' => 'Das :attribute Feld muss Einträge für folgende Werte enthalten: :values.',
    'required_if' => 'Das :attribute Feld ist erforderlich, wenn :other :value ist.',
    'required_if_accepted' => 'Das :attribute Feld ist erforderlich, wenn :other akzeptiert ist.',
    'required_unless' => 'Das :attribute Feld ist erforderlich, es sei denn, :other befindet sich in :values.',
    'required_with' => 'Das :attribute Feld ist erforderlich, wenn :values vorhanden ist.',
    'required_with_all' => 'Das :attribute Feld ist erforderlich, wenn alle :values vorhanden sind.',
    'required_without' => 'Das :attribute Feld ist erforderlich, wenn :values nicht vorhanden ist.',
    'required_without_all' => 'Das :attribute Feld ist erforderlich, wenn keiner der :values vorhanden ist.',
    'same' => 'Das :attribute Feld und :other müssen übereinstimmen.',
    'size' => [
        'array' => 'Das :attribute Feld muss :size Elemente enthalten.',
        'file' => 'Das :attribute Feld muss :size Kilobyte groß sein.',
        'numeric' => 'Das :attribute Feld muss :size sein.',
        'string' => 'Das :attribute Feld muss :size Zeichen lang sein.',
    ],
    'starts_with' => 'Das :attribute Feld muss mit einem der folgenden beginnen: :values.',
    'string' => 'Das :attribute Feld muss ein String sein.',
    'timezone' => 'Das :attribute Feld muss eine gültige Zeitzone sein.',
    'unique' => 'Das :attribute wurde bereits vergeben.',
    'uploaded' => 'Das :attribute konnte nicht hochgeladen werden.',
    'uppercase' => 'Das :attribute Feld muss in Großbuchstaben sein.',
    'url' => 'Das :attribute Feld muss eine gültige URL sein.',
    'ulid' => 'Das :attribute Feld muss eine gültige ULID sein.',
    'uuid' => 'Das :attribute Feld muss eine gültige UUID sein.',

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
            'size' => 'Hierarchie-ID-Injektion.',
        ],
        'hier-name-blocks' => [
            'size' => 'Die Anzahl der gültigen Ebenen muss :size betragen.',
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
