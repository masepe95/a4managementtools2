<?php

return [

    // English.
    // Stringhe per la pagina 'employees' di amministrazione.

    'title' => 'Employees',
    'title-tooltip' => 'Name of the Organization',
    'description' => 'Employee management.',

    'employee' => 'Employee',
    'employee-tooltip' => 'Name, surname and email of the selected Employee.',
    'update-button-tooltip' => 'Update the data of the selected Employee in the «:employee» comboBox.',
    'add-button-tooltip' => 'Add a new Employee.',
    'delete-button-tooltip' => 'Delete the data of the selected Employee in the «:employee» comboBox.',

    'firstname' => 'Firstname',
    'lastname' => 'Lastname',
    'acronym' => 'Acronym',
    'employee-id' => 'ID',
    'mobile-phone' => 'Mobile phone',
    'phone' => 'Phone',
    'email' => 'Email',
    'language' => 'Language',
    'language-tooltip' => 'Default personal language.',
    'curr-password' => 'Current Password',
    'curr-password-tooltip' => 'Enter the current password if you want to change it.',
    'new-password' => 'New Password',
    'new-password-tooltip' => "New Password, leave the field empty if you don't want to change it.",
    'job-title' => 'Job title',
    'role' => 'Role',
    'failed-passwords' => 'Incorrect passwords',
    'failed-passwords-tooltip' => "Number of incorrect passwords entered consecutively (maximum of 5 before the employee is locked out).  This field is read-only, click the «:reset» button to re-enable the selected employee's access.",
    'reset-failed-passwords' => 'Reset',
    'reset-failed-passwords-tooltip' => "Resets the number of incorrect passwords and re-enables the selected employee's access.",
    'status' => 'Status',

    'employee-photo' => "<span>Drag the Employee's<br />photo here<br />or click<br />in this area</span>",
    'employee-photo-tooltip' => "Drag the Employee's photo here or click in this area.&#10;Supported image formats: JPG, PNG, GIF, SVG.",
    'employee-photo-delete' => "Delete the selected Employee's photo.",

    'tools-visibility' => 'Visibility of Tools',
    'tools-visibility-choices' =>  [
        'write' => ['tooltip' => 'Read and write accessible tool.', 'label' => 'W'],
        'read' => ['tooltip' => 'Tool accessible for reading only.', 'label' => 'R'],
        'none' => ['tooltip' => 'Tool not accessible.', 'label' => 'X'],
    ],

    // Errori SQL (salvati nell'attributo "data-sql-error" del div#employees-errors).
    // Nota: se il value di 'errMsg' deve contenere dei single o double-quote letterali, inserire
    //       rispettivamente i caratteri ’ o ” (saranno convertiti dalla funzione ajaxError() in "admin.js").
    // Nota: l'errore della key 'uq_employee_email_password' va inserita prima della 'uq_employee_email',
    //       in caso contrario, indexof() ritornerebbe sempre la entry 'uq_employee_email'.
    'sql-error' => "[{ 'match':'employee.uq_employee_email_password','errMsg':" .
                      "'<b>Invalid password</b>: please use another «Password».' }," .
                    "{ 'match':'employee.uq_employee_email','errMsg':" .
                      "'<b>Duplicated Email</b>: another employee is already using this «Email» address.' }," .
                    "{ 'match':'employee.uq_employee_acronym','errMsg':" .
                      "'<b>Duplicated Acronym</b>: another employee is already using this «Acronym».' }," .
                    "{ 'match':'employee.uq_employee_employee_id','errMsg':" .
                      "'<b>Duplicated ID</b>: another employee is already using this «ID».' }]",

    // Delete employees dialogBox.
    'delete-title' => 'Delete Employee',
    'delete-body' => 'Are you sure you want to delete the selected Employee?',

];
