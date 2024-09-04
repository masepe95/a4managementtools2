<?php

return [

    // English.
    // Stringhe per la pagina 'personal-groups' di amministrazione.

    'title' => 'My User Groups',
    'description' => 'Personal User Group management, can be used to quickly assign visibility of one\'s «<span class="a4-text-shade-100 font-bold">jobs</span>» to predefined Groups of colleagues.',

    'group-names-tooltip' => 'Current Group name.',
    'group-names-label' => 'User Group name',

    'new-group-name' => 'Name of the new User Group',
    'new-group-name-tooltip' => 'If this field is left blank, the Group name remains unchanged when «:update» button is pressed.&#10;To create a new Group, the name must be different from existing ones.',
    'new-group-name-error' => 'This name is already used.',

    'group-list-selected' => 'users selected',
    'group-list-tooltip' => 'Selects Users to be included in the selected Group or in a new Group.',
    'group-list' => 'Users of the Group',

    'update-button-tooltip' => 'Update the User Group selected in the «:name» comboBox.',
    'delete-button-tooltip' => 'Delete the User Group selected in the «:name» comboBox.',
    'add-button-tooltip' => 'Add a new User Group with the name specified in the «:newname» text box.',

    // Errori SQL (salvati nell'attributo "data-sql-error" del div#personal-groups-errors).
    // Nota: se il value di 'errMsg' deve contenere dei single o double-quote letterali, inserire
    //       rispettivamente i caratteri ’ o ” (saranno convertiti dalla funzione ajaxError() in "admin.js").
    'sql-error' => "[{ 'match':'personal_group.uq_personal_group_group_name','errMsg':" .
                      "'<b>Duplicate group name</b>: you have already used this «User Group» name.' }]",

    // Delete user group modal dialogBox.
    'delete-title' => 'Delete User Group',
    'delete-body' => 'Are you sure you want to delete the selected User Group?',

];
