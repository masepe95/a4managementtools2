<?php

return [

    // English.
    // Stringhe per la pagina 'profile' di amministrazione.

    'title' => 'My Personal Details',
    'description' => 'Management of your Profile.',

    'firstname' => 'Firstname',
    'lastname' => 'Lastname',
    'acronym' => 'Acronym',
    'employee-id' => 'ID',
    'mobile-phone' => 'Mobile phone',
    'phone' => 'Phone',
    'email' => 'Email',
    'language' => 'Language',
    'language-tooltip' => 'Default Personal language.',
    'curr-password' => 'Current Password',
    'curr-password-tooltip' => 'Enter the current password if you want to change it.',
    'new-password' => 'New Password',
    'new-password-tooltip' => "New Password, leave the field empty if you don't want to change it.",
    'job-title' => 'Job title',
    'role' => 'Role',

    'profile-photo' => '<span>Drag &amp; Drop<br />your photo here<br />or click<br />in this area</span>',
    'profile-photo-tooltip' => 'Drag &amp; Drop your photo here or click it.&#10;Supported image formats: JPG, PNG, GIF, SVG.',
    'profile-photo-delete' => 'Delete your photo.',

    // Errori SQL (salvati nell'attributo "data-sql-error" del div#profile-errors).
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

];
