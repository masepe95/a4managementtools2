<?php

return [

    // English.
    // Stringhe per la pagina 'customer' di amministrazione.

    'title' => 'Customer',
    'title-tooltip' => 'Name of the Organization',
    'description' => 'Customer data management.',

    'name' => 'Customer Name',
    'company-uid' => 'Customer ID',
    'address1' => 'Address',
    'address2' => 'Additional Address',
    'city' => 'City',
    'zip' => 'ZIP Code',
    'country' => 'Country',
    'country-state' => 'State',
    'vat' => 'VAT',

    'number-users' => 'Number of Employees',
    'usr1' => 'One employee',
    'usr10' => 'Up to 10 employees',
    'usr50' => 'Up to 50 employees',
    'usr100' => 'Up to 100 employees',
    'usr500' => 'Up to 500 employees',
    'usr1000' => 'Up to 1,000 employees',
    'usr2000' => 'Up to 2,000 employees',
    'usr3000' => 'Up to 3,000 employees',
    'usr5000' => 'Up to 5,000 employees',
    'usr10000' => 'Up to 10,000 employees',
    'usr15000' => 'Up to 15,000 employees',
    'usr20000' => 'Up to 20,000 employees',
    'usrUnlimited' => 'Over 20,000 employees',

    'customer-logo' => '<span>Drag &amp; Drop<br />your logo here<br />or click in this area</span>',
    'customer-logo-tooltip' => 'Drag &amp; Drop your logo here or click in this area.&#10;Supported image formats: JPG, PNG, GIF, SVG.',
    'customer-logo-delete' => 'Delete your logo.',

    'super-admin-tooltip' => 'Setting visible only to Super Administrators.',
    'customer-tools' => 'Customer Tools',
    'customer-tools-choices' =>  [
        'yes' => ['tooltip' => 'This tool is assigned.', 'label' => 'A'],
        'no' => ['tooltip' => 'This tool is not assigned.', 'label' => 'N'],
        'disabled' => ['tooltip' => 'This tool is assigned but temporarily disabled.', 'label' => 'D'],
    ],
    'job-count' => '{0} (No jobs)|{1} (1 job)|[2,*] (:count jobs)',

    'customer-type' => 'Customer Account type',
    'customer-type-free-account' => 'Free Account',
    'customer-type-regular-account' => 'Regular Account',
    'customer-type-site-admin' => 'Site Administrator',

    'customer-status' => 'Customer status',
    'customer-status-enabled' => 'Enabled',
    'customer-status-disabled' => 'Disabled',

    'use-saml' => 'SAML access',
    'use-saml-no' => 'No',
    'use-saml-yes' => 'Yes',

    'suggested-countries' => 'Suggested Countries',
    'worldwide-countries' => 'Worldwide Countries',
    'state-types' =>  [
        ' ' => ' ',
        'administered areas' => 'Administered Areas',
        'administration' => 'Administration',
        'administrative area' => 'Administrative Area',
        'administrative atoll' => 'Administrative Atoll',
        'administrative region' => 'Administrative Region',
        'administrative regions' => 'Administrative Regions',
        'administrative territory' => 'Administrative Territory',
        'area' => 'Area',
        'autonomous city' => 'Autonomous City',
        'autonomous community' => 'Autonomous Community',
        'autonomous district' => 'Autonomous District',
        'autonomous municipality' => 'Autonomous Municipality',
        'autonomous province' => 'Autonomous Province',
        'autonomous region' => 'Autonomous Region',
        'autonomous republic' => 'Autonomous Republic',
        'autonomous sector' => 'Autonomous Sector',
        'autonomous territorial unit' => 'Autonomous Territorial Unit',
        'borough' => 'Borough',
        'canton' => 'Canton',
        'capital' => 'Capital',
        'capital city' => 'Capital City',
        'capital district' => 'Capital District',
        'capital metropolitan city' => 'Capital Metropolitan City',
        'capital region' => 'Capital Region',
        'capital territory' => 'Capital Territory',
        'chain of islands' => 'Chain of Islands',
        'city' => 'City',
        'city corporation' => 'City Corporation',
        'city of county right' => 'City of County Right',
        'commune' => 'Commune',
        'constitutional province' => 'Constitutional Province',
        'council' => 'Council',
        'council area (scotland)' => 'Council Area (Scotland)',
        'country' => 'Country',
        'county' => 'County',
        'department' => 'Department',
        'dependency' => 'Dependency',
        'development regions' => 'Development Regions',
        'district' => 'District',
        'district council area (northern ireland)' => 'District Council Area (Northern Ireland)',
        'division' => 'Division',
        'economic prefecture' => 'Economic Prefecture',
        'emirate' => 'Emirate',
        'entity' => 'Entity',
        'federal capital territory' => 'Federal Capital Territory',
        'federal dependency' => 'Federal Dependency',
        'federal district' => 'Federal District',
        'federal territory' => 'Federal Territory',
        'geographic regions' => 'Geographic Regions',
        'geographic units' => 'Geographic Units',
        'geographical region' => 'Geographical Region',
        'governorate' => 'Governorate',
        'governorates' => 'Governorates',
        'indigenous region' => 'Indigenous Region',
        'island' => 'Island',
        'island council' => 'Island Council',
        'island group' => 'Island Group',
        'metropolis' => 'Metropolis',
        'metropolitan administration' => 'Metropolitan Administration',
        'metropolitan city' => 'Metropolitan City',
        'metropolitan department' => 'Metropolitan Department',
        'metropolitan district' => 'Metropolitan District',
        'metropolitan regions' => 'Metropolitan Regions',
        'municipality' => 'Municipality',
        'outlying area' => 'Outlying Area',
        'overseas regions' => 'Overseas Regions',
        'overseas territorial collectivity' => 'Overseas Territorial Collectivity',
        'overseas territory' => 'Overseas Territory',
        'pakistan administered area' => 'Pakistan Administered Area',
        'parish' => 'Parish',
        'popularate' => 'Popularate',
        'prefecture' => 'Prefecture',
        'principality' => 'Principality',
        'province' => 'Province',
        'quarter' => 'Quarter',
        'region' => 'Region',
        'regional council' => 'Regional Council',
        'republic' => 'Republic',
        'rerion' => 'Rerion',
        'self-governed part' => 'Self-governed Part',
        'special administrative city' => 'Special Administrative City',
        'special administrative region' => 'Special Administrative Region',
        'special city' => 'Special City',
        'special district' => 'Special District',
        'special island authority' => 'Special Island Authority',
        'special municipality' => 'Special Municipality',
        'special region' => 'Special Region',
        'special zone' => 'Special Zone',
        'state' => 'State',
        'states' => 'States',
        'territorial collectivity' => 'Territorial Collectivity',
        'territorial unit' => 'Territorial Unit',
        'territory' => 'Territory',
        'two-tier county' => 'Two-tier County',
        'union territory' => 'Union Territory',
        'unitary authority' => 'Unitary Authority',
        'unitary authority (wales)' => 'Unitary Authority (Wales)',
        'urban prefecture' => 'Urban Prefecture',
        'voivodship' => 'Voivodship',
        'zone' => 'Zone',
    ],

    // Customer's modal warning.
    'modal-title' => 'Automatic deletion of Jobs',
    'modal-body1' => 'You are about to deactivate one or more «<span class="a4-text-shade-100 font-bold">tools</span>» of the impersonated Customer.<br /> For at least one of these <span class="a4-text-shade-100 font-bold">tools</span> there are «<span class="a4-text-shade-100 font-bold">jobs</span>» that will be automatically deleted.',
    'modal-body2' => 'Do you want to proceed with the update, deactivation of the <span class="a4-text-shade-100 font-bold">tools</span> and consequent elimination of the related <span class="a4-text-shade-100 font-bold">jobs</span>?',

];