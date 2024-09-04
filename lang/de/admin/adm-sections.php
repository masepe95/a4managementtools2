<?php

return [

    // Deutsch.
    // Stringhe per la pagina 'sections' di amministrazione.

    'title' => 'Organigramm',
    'title-tooltip' => 'Name der Organisation',
    'description' => 'Organisation der Mitarbeiter: Auf dieser Seite können beliebig viele Hierarchieebenen und Einheiten definiert werden, jede Ebene und Einheit erhält einen Namen (mehrsprachig). <span id="org-info-exp-arrow" class="cursor-pointer" data-title="Zeig mehr." data-title-less="Zeige weniger."><svg class="inline h-4 w-4 stroke-neutral-800 hover:a4-stroke-shade-300 transition-transform duration-500 ease-in-out" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"></path></svg></span><div id="org-extra-info" style="display: none;">Jede Ebene kann beliebig viele Einheiten (mit mehrsprachigen Namen) enthalten, siehe «<span class="a4-text-shade-100 font-bold hover:underline hover:cursor-pointer" data-te-toggle="modal" data-te-target="#section-sample-preview" title="Klicken Sie, um ein Beispiel einer hierarchischen Organisation anzuzeigen.">Beispiel</span>».<br /><span class="font-bold">Hinweis</span>: Mit Ausnahme von Einheiten der Ebene <span class="font-bold">1</span>, müssen alle anderen ihre übergeordnete Einheit auf der nächsthöheren Ebene angeben.<br />Sobald die hierarchische Struktur fertiggestellt ist, ist es auf der Seite «<span class="menu-link a4-text-shade-100 font-bold hover:underline hover:cursor-pointer" data-link-page="adm-employees-sections" title="Gehen Sie zur Seite mit dem \'Mitarbeiterorganisation\'.">Mitarbeiterorganisation</span>» ist es möglich, Mitarbeiter einer oder mehreren Einheiten des \'Organigramms\' zuzuordnen .<br /><span class="font-bold">Hinweis</span>: Wenn Ebenen oder Einheiten gelöscht werden, überprüfen Sie die Mitarbeiterzuordnungen auf der Seite «<span class="menu-link a4-text-shade-100 font-bold hover:underline hover:cursor-pointer" data-link-page="adm-employees-sections" title="Gehen Sie zur Seite mit dem \'Mitarbeiterorganisation\'.">Mitarbeiterorganisation</span>» noch einmal.</div>',

    'add-level-tooltip' => 'Fügen Sie Ihrem Organigramm eine Level hinzu.',

    'level-label' => 'Ebene',
    'level-section-label' => 'Level-Einheiten',
    'level-delete-tooltip' => 'Löschen Sie diese Organigrammebene.',
    'add-section-tooltip' => 'Fügen Sie auf dieser Ebene des Organigramms eine neue Einheit hinzu.',
    'level-error-tooltip' => 'Bitte geben Sie mindestens eine Sprache für den Levelnamen und mindestens eine Einheit ein.',
    'section-error-tooltip' => 'Bitte geben Sie mindestens eine Sprache für den Einheitennamen ein.',
    'section-label' => 'Einheit',
    'section-delete-tooltip' => 'Löschen Sie dieses Laufwerk.',
    'parent-section-label' => 'Elterneinheit.',

    // Sections' modal preview.
    'modal-title' => 'Beispiel einer hierarchischen Organisation',
    'modal-body1' => 'Dieses Beispiel zeigt das Diagramm einer hierarchischen Organisation mit drei Ebenen (<span class="text-green-400 font-bold">Divisions</span>, <span class="text-green-400 font-bold">Departments</span> und <span class="text-green-400 font-bold">Teams</span>). Die erste Ebene (<span class="text-green-400 font-bold">Division</span>) umfasst eine einzelne Einheit (<span class="a4-text-shade-100 font-bold">Europe Division</span>), die zweite Ebene <span class="text-green-400 font-bold">Departments</span>) umfasst zwei Einheiten (<span class="a4-text-shade-100 font-bold">Chemical department</span> und <span class="a4-text-shade-100 font-bold">Electronics department</span>), und schließlich umfasst die dritte Ebene (<span class="text-green-400 font-bold">Teams</span>) fünf Einheiten (<span class="a4-text-shade-100 font-bold">Research team</span>, <span class="a4-text-shade-100 font-bold">Development team</span>, <span class="a4-text-shade-100 font-bold">New technologies team</span>, <span class="a4-text-shade-100 font-bold">Electronic components team</span> und <span class="a4-text-shade-100 font-bold">Marketing team</span>).',
    'modal-body2' => 'Für jede Einheit muss auf der obersten Ebene eine übergeordnete Einheit angegeben werden.',
    'modal-body3' => 'Auf der Seite «<span class="a4-text-shade-100 font-bold">Mitarbeiterorganisation</span>» können Sie Mitarbeiter einer oder mehreren Einheiten des Organigramms zuordnen.',

    // Errori SQL (salvati nell'attributo "data-sql-error" del div#sections-errors).
    // Nota: se il value di 'errMsg' deve contenere dei single o double-quote letterali, inserire
    //       rispettivamente i caratteri ’ o ” (saranno convertiti dalla funzione ajaxError() in "admin.js").
    'sql-error' => "[{ 'match':'section_level_lang.uq_section_level_lang_name','errMsg':" .
                      "'<b>Doppelter Ebenenname</b>: Mehrere Ebenen haben denselben «Ebenennamen» für dieselbe Sprache.' }," .
                    "{ 'match':'section_lang.uq_section_lang_name','errMsg':" .
                      "'<b>Doppelter Einheitenname</b>: Mehrere Einheiten haben denselben «Ebenennamen» für dieselbe Sprache.' }," .
                    "{ 'match':'Error','errMsg':" .
                      "'<b>Ungültiges Format</b>: das Abschnittsformat ist ungültig.' }]",

];
