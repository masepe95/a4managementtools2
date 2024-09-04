<?php

return [

    // Italiano.
    // Stringhe per la pagina 'languages' di amministrazione.

    'title' => 'Lingue',
    'description' => 'Gestione delle lingue.',

    'language' => 'Lingua',
    'update-button-tooltip' => 'Modifica la lingua selezionata nel comboBox «:language».',
    'add-button-tooltip' => 'Aggiungi una nuova lingua.',
    'delete-button-tooltip' => 'Elimina la lingua selezionata nel comboBox «:language».',

    'language-data' => 'Per aggiungere una nuova lingua, tutti i campi devono essere validi.',
    'language-name' => 'Nome della lingua',
    'language-name-tooltip' => 'Si prega di compilare questo campo con almeno un carattere alfabetico (eventuali spazi iniziali e in coda vengono eliminati).',
    'language-code' => 'Codice della lingua',
    'language-code-tooltip' => 'Inserire il codice ISO 639-1 della lingua (2 lettere minuscole).',
    'language-order' => 'Priorità della lingua',
    'language-order-tooltip' => 'Un valore numerico più piccolo indica una priorità maggiore.',

    // Errori SQL (salvati nell'attributo "data-sql-error" del div#languages-errors).
    // Nota: se il value di 'errMsg' deve contenere dei single o double-quote letterali, inserire
    //       rispettivamente i caratteri ’ o ” (saranno convertiti dalla funzione ajaxError() in "admin.js").
    'sql-error' => "[{ 'match':'language.PRIMARY','errMsg':" .
                      "'<b>Codice della lingua duplicato</b>: ogni Lingua deve avere un Codice univoco.' },
                     { 'match':'language.uq_language_name','errMsg':" .
                      "'<b>Nome della lingua duplicato</b>: ogni Lingua deve avere un Nome univoco.' },
                     { 'match':'ON DELETE RESTRICT','errMsg':" .
                      "'<b>Lingua in uso</b>: non è possibile eliminare una Lingua utilizzata in almeno una tabella.' }]",

    // Delete languages dialogBox.
    'delete-title' => 'Elimina Lingua',
    'delete-body' => "Sei sicuro di voler eliminare la Lingua selezionata?<br /><br />Se la Lingua che stai per eliminare è in uso in almeno una tabella, l'operazione verrà interrotta e verrà visualizzato un errore.",

];
