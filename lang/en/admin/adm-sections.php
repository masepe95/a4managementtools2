<?php

return [

    // English.
    // Stringhe per la pagina 'sections' di amministrazione.

    'title' => 'Organization Chart',
    'title-tooltip' => 'Name of the Organization',
    'description' => 'Employee organization: on this page you can define an arbitrary number of hierarchical levels and units, ogni livello e unità avrà un nome (multilingua). <span id="org-info-exp-arrow" class="cursor-pointer" data-title="Show more." data-title-less="Show less."><svg class="inline h-4 w-4 stroke-neutral-800 hover:a4-stroke-shade-300 transition-transform duration-500 ease-in-out" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"></path></svg></span><div id="org-extra-info" style="display: none;">Each level can contain any number of units (with multilingual names), see «<span class="a4-text-shade-100 font-bold hover:underline hover:cursor-pointer" data-te-toggle="modal" data-te-target="#section-sample-preview" title="Click to show an example of a hierarchical organization.">example</span>».<br /><span class="font-bold">Note</span>: except for level <span class="font-bold">#1</span> unit, all other units must specify their parent unit in the next higher level.<br />Once the hierarchical structure is complete, on the page «<span class="menu-link a4-text-shade-100 font-bold hover:underline hover:cursor-pointer" data-link-page="adm-employees-sections" title="Go to the \'Employee organization\' page.">Employee organization</span>» you can associate employees with one or more units in the Organization chart.<br /><span class="font-bold">Note</span>: in case levels or units are deleted, check and review the employee associations on the page «<span class="menu-link a4-text-shade-100 font-bold hover:underline hover:cursor-pointer" data-link-page="adm-employees-sections" title="Go to the page \'Employee organization\'.">Employee organization</span>».</div>',

    'add-level-tooltip' => 'Add a level to the organization chart.',

    'level-label' => 'Level',
    'level-section-label' => 'Unit of Level',
    'level-delete-tooltip' => 'Delete this level of organization chart.',
    'add-section-tooltip' => 'Add a new unit to this level of the organization chart.',
    'level-error-tooltip' => 'Please fill in at least one language for the level name and specify a minimum of one unit.',
    'section-error-tooltip' => 'Please fill in at least one language for the unit name.',
    'section-label' => 'Unit',
    'section-delete-tooltip' => 'Delete this unit.',
    'parent-section-label' => 'Parent unit.',

    // Sections' modal preview.
    'modal-title' => 'Example of hierarchical organization',
    'modal-body1' => 'This example shows the pattern of a hierarchical organization with three levels (<span class="text-green-400 font-bold">Divisions</span>, <span class="text-green-400 font-bold">Departments</span> and <span class="text-green-400 font-bold">Teams</span>). The first level (<span class="text-green-400 font-bold">Division</span>) includes one unit (<span class="a4-text-shade-100 font-bold">Europe Division</span>), the second level (<span class="text-green-400 font-bold">Departments</span>) includes two units (<span class="a4-text-shade-100 font-bold">Chemical department</span> and <span class="a4-text-shade-100 font-bold">Electronics department</span>), finally, the third level (<span class="text-green-400 font-bold">Teams</span>) includes five units (<span class="a4-text-shade-100 font-bold">Research team</span>, <span class="a4-text-shade-100 font-bold">Development team</span>, <span class="a4-text-shade-100 font-bold">New technologies team</span>, <span class="a4-text-shade-100 font-bold">Electronic components team</span> and <span class="a4-text-shade-100 font-bold">Marketing team</span>).',
    'modal-body2' => 'A parent unit in the upper level must be specified for each unit.',
    'modal-body3' => 'The «<span class="a4-text-shade-100 font-bold">Employee organization</span>» page allows employees to be associated with one or more units in the organization chart.',

    // Errori SQL (salvati nell'attributo "data-sql-error" del div#sections-errors).
    // Nota: se il value di 'errMsg' deve contenere dei single o double-quote letterali, inserire
    //       rispettivamente i caratteri ’ o ” (saranno convertiti dalla funzione ajaxError() in "admin.js").
    'sql-error' => "[{ 'match':'section_level_lang.uq_section_level_lang_name','errMsg':" .
                      "'<b>Duplicated Level Name</b>: multiple levels have the same «Level Name» for the same language.' }," .
                    "{ 'match':'section_lang.uq_section_lang_name','errMsg':" .
                      "'<b>Duplicated Unit Name</b>: multiple units have the same «Unit Name» for the same language.' }," .
                    "{ 'match':'Error','errMsg':" .
                      "'<b>Invalid format</b>: the format of the Sections is invalid.' }]",

];
