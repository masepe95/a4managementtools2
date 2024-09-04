<?php

return [

    // Français.
    // Stringhe per la pagina 'sections' di amministrazione.

    'title' => 'Organigramme',
    'title-tooltip' => "Nom de l'Organisation",
    'description' => 'Organisation des employés: sur cette page il est possible de définir un nombre arbitraire de niveaux et d\'unités hiérarchiques, chaque niveau et unité aura un nom (multilingue). <span id="org-info-exp-arrow" class="cursor-pointer" data-title="Montre plus." data-title-less="Montrer moins."><svg class="inline h-4 w-4 stroke-neutral-800 hover:a4-stroke-shade-300 transition-transform duration-500 ease-in-out" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"></path></svg></span><div id="org-extra-info" style="display: none;">Chaque niveau peut contenir n\'importe quel nombre d\'unités (avec des noms multilingues), voir «<span class="a4-text-shade-100 font-bold hover:underline hover:cursor-pointer" data-te-toggle="modal" data-te-target="#section-sample-preview" title="Cliquez pour afficher un exemple d\'organisation hiérarchique.">exemple</span>».<br /><span class="font-bold">Remarque</span>: à l\'exception des unités de niveau <span class="font-bold">1</span>, toutes les autres doivent spécifier leur unité parent au niveau immédiatement supérieur.<br />Une fois la structure hiérarchique complétée, sur la page «<span class="menu-link a4-text-shade-100 font-bold hover:underline hover:cursor-pointer" data-link-page="adm-employees-sections" title="Accédez à la page \'Organisation employés\'.">Organisation employés</span>» il est possible d\'associer des employés à une ou plusieurs unités de l\'organigramme.<br /><span class="font-bold">Remarque</span>: si des niveaux ou des unités sont supprimés, vérifiez et examinez les associations d\'employés sur la page «<span class="menu-link a4-text-shade-100 font-bold hover:underline hover:cursor-pointer" data-link-page="adm-employees-sections" title="Accédez à la page \'Organisation employés\'.">Organisation employés</span>».</div>',

    'add-level-tooltip' => 'Ajoutez un nouveau niveau à votre organigramme.',

    'level-label' => 'Niveau',
    'level-section-label' => 'Unités de niveau',
    'level-delete-tooltip' => "Supprimez ce niveau d'organigramme.",
    'add-section-tooltip' => "Ajoutez une nouveau unité à ce niveau de l'organigramme.",
    'level-error-tooltip' => 'Veuillez remplir au moins une langue pour le nom du niveau et au moins une unité.',
    'section-error-tooltip' => "Veuillez indiquer au moins une langue pour le nom de l'unité.",
    'section-label' => 'Unité',
    'section-delete-tooltip' => 'Supprimez cette unité.',
    'parent-section-label' => 'Unité parent.',

    // Sections' modal preview.
    'modal-title' => "Exemple d'organisation hiérarchique",
    'modal-body1' => 'Cet exemple montre le schéma d\'une organisation hiérarchique à trois niveaux (<span class="text-green-400 font-bold">Divisions</span>, <span class="text-green-400 font-bold">Departments</span> et <span class="text-green-400 font-bold">Teams</span>). Le premier niveau <span class="text-green-400 font-bold">Division</span> comprend une seule unité (<span class="a4-text-shade-100 font-bold">Europe Division</span>), le deuxième niveau <span class="text-green-400 font-bold">Departments</span> comprend deux unités (<span class="a4-text-shade-100 font-bold">Chemical department</span> et <span class="a4-text-shade-100 font-bold">Electronics department</span>), enfin, le troisième niveau <span class="text-green-400 font-bold">Teams</span> comprend cinq unités (<span class="a4-text-shade-100 font-bold">Research team</span>, <span class="a4-text-shade-100 font-bold">Development team</span>, <span class="a4-text-shade-100 font-bold">New technologies team</span>, <span class="a4-text-shade-100 font-bold">Electronic components team</span> et <span class="a4-text-shade-100 font-bold">Marketing team</span>).',
    'modal-body2' => 'Pour chaque unité, une unité parent doit être spécifiée au niveau supérieur.',
    'modal-body3' => 'La page «<span class="a4-text-shade-100 font-bold">Organisation employés</span>» permet d\'associer des employés à une ou plusieurs unités de l\'organigramme.',

    // Errori SQL (salvati nell'attributo "data-sql-error" del div#sections-errors).
    // Nota: se il value di 'errMsg' deve contenere dei single o double-quote letterali, inserire
    //       rispettivamente i caratteri ’ o ” (saranno convertiti dalla funzione ajaxError() in "admin.js").
    'sql-error' => "[{ 'match':'section_level_lang.uq_section_level_lang_name','errMsg':" .
                      "'<b>Nom de Niveau dupliqué</b>: plusieurs niveaux ont le même «Nom de Niveau» pour la même langue.' }," .
                    "{ 'match':'section_lang.uq_section_lang_name','errMsg':" .
                      "'<b>Nom de Unité dupliqué</b>: plusieurs unités ont le même «Nom de Unité» pour la même langue.' }," .
                    "{ 'match':'Error','errMsg':" .
                      "'<b>Format invalide</b>: le format des Sections n’est pas valide.' }]",

];
