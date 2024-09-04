<?php

return [

    // English.
    // Stringhe per la pagina 'tools' di amministrazione.

    'title' => 'Tools',
    'description' => '«<span class="a4-text-shade-100 font-bold">Tool</span>» management.',

    'tool' => 'Tool',
    'update-button-tooltip' => 'Update the selected Tool in the «:tool» comboBox.',
    'add-button-tooltip' => 'Add a new Tool.',
    'delete-button-tooltip' => 'Delete the selected Tool in the «:tool» comboBox.',

    'tool-id' => 'ID',
    'tool-id-tooltip' => 'Format: A4xxx (xxx = 001 - 999) or A4xxxx (xxxx = 0001 - 9999).',
    'tool-title' => 'Title',
    'tool-title-tooltip' => 'Uppercase and lowercase letters only, no spaces allowed.',
    'tool-active' => 'Active',
    'tool-inactive' => 'Inactive',
    'related-tools' => 'Related Tools',
    'related-tools-selected' => 'tools selected',

    'tool-level' => 'Levels',
    'tool-level-executive' => 'Executive',
    'tool-level-advanced' => 'Advanced',
    'tool-level-intermediate' => 'Intermediate',

    'tool-recipient' => 'Recipients',
    'tool-recipient-management' => 'Management',
    'tool-recipient-marketing' => 'Marketing',
    'tool-recipient-operations' => 'Operations',
    'tool-recipient-rd' => 'Research and development',

    'tool-usage' => 'Usage',
    'tool-usage-strategy' => 'Strategy',
    'tool-usage-assessment' => 'Assessment',
    'tool-usage-correctives' => 'Correctives',
    'tool-usage-simplification' => 'Simplification',
    'tool-usage-delegation' => 'Delegation',
    'tool-usage-motivation' => 'Motivation and Team Building',

    'tool-selection' => 'Selection',
    'tool-selection-a-plus' => 'A+++',
    'tool-selection-eco' => 'Eco',
    'tool-selection-quick' => 'Quick',
    'tool-selection-top' => 'TOP',

    'tool-scope' => 'Scope',
    'tool-scope-company-management' => 'Company-management',
    'tool-scope-management' => 'Management',
    'tool-scope-team-management' => 'Team management',
    'tool-scope-professional-development' => 'Professional development',
    'tool-scope-individual-development' => 'Individual development and well-being',

    // Errori SQL (salvati nell'attributo "data-sql-error" del div#tools-errors).
    // Nota: se il value di 'errMsg' deve contenere dei single o double-quote letterali, inserire
    //       rispettivamente i caratteri ’ o ” (saranno convertiti dalla funzione ajaxError() in "admin.js").
    'sql-error' => "[{ 'match':'tool.PRIMARY','errMsg':" .
                      "'<b>Duplicated ID</b>: another Tool is already using this «ID».' }," .
                    "{ 'match':'tool.uq_tool_title_id','errMsg':" .
                      "'<b>Duplicated Title</b>: another Tool is already using this «Title».' }," .
                    "{ 'match':'tool.chk_tool_title_id','errMsg':" .
                      "'<b>Empty Title</b>: the Tool «Title» cannot be empty.' }]",

    // Delete tools dialogBox.
    'delete-title' => 'Delete Tool',
    'delete-body' => 'Are you sure you want to delete the selected Tool?',

];
