<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Events\BeforeSheet;

// I metodi model(), collection() e onRow() (usati in modo mutualmente esclusivo) permettono di
// inserire ogni row importata dall'Excel direttamente nel DB.
// Per questo progetto, i dati degli User importati (tabella `employee`) hanno bisogno dell'id
// del customer a cui appartengono gli User stessi.
// Questo parametro può essere ottenuto tramite:
//   auth()->user()
//     oppure
//   Auth::user()
// e, in seguito, ottenendo l'eventuale user impersonato (vedi AdminController::getRealUser()).
//
// Tuttavia, la classe ExcelImport è generica (non per uno specifico file Excel) e si è optato
// per l'utilizzo del controller ExcelImportController che implementa il metodo getExcelRows().
// Quando serve importare un Excel particolare, dove necessario, si invoca il metodo getExcelRows()
// con i parametri specifici (nome del file, campi obbligatori ecc.) e si ottiene un array associativo
// altrettanto specifico dell'Excel importato.
// Nel caso di importing di impiegati (User => tabella `employee`), una volta ottenute le row
// validate, queste vengono inserite nel DB in modalità 'pending' e con una password di default.
// Per ogni utente inserito, viene inviata una e-mail di verifica (in modo molto simile al reset
// della password), cliccando il link ricevuto nella e-mail, l'utente viene rediretto ad un form in
// cui conferma la validità dell'e-mail e inserisce privatamente la propria password.
//
class ExcelImport implements /*ToCollection,*/ /*OnEachRow,*/ /*toModel,*/ WithHeadingRow//, WithEvents
{
    // La variabile $sheetNames, il costruttore e il metodo registerEvents() permettono di
    // ottene il nome di ogni worksheet.
    // Nota: per essere coerenti con i concetti di incapsulamento e information hiding, rendere
    //       privata la variabile $sheetNames e implementare un getter che ritorna una copia di $sheetNames.
    /*public $sheetNames;

    public function __construct(){
        $this->sheetNames = [];
    }

    public function registerEvents(): array
    {
        return [
            BeforeSheet::class => function(BeforeSheet $event) {
                $this->sheetNames[] = $event->getSheet()->getTitle();
            }
        ];
    }*/

    // Invocato per ogni row del worksheet corrente.
    /*public function model(array $row)
    {
        //return new User([
        //    'name' => $row[0],
        //]);
    }*/

    /*public function collection(Collection $rows)
    {
        // Il metodo collection() viene invocato quando l'import viene eseguito tramite il metodo
        // Excel::import(), ma solo se questa classe implementa anche l'interface ToCollection.
        // Nota: nel caso il file Excel importato abbia più di un worksheet, il metodo collection()
        //       viene invocato più volte, una per ogni singolo worksheet.

        // Itera le rows (property items) della collection importata da un Excel e le inserisce nel DB.
        foreach ($rows as $key => $row) {
            // Ogni $row è una collection di key => value, key corrisponde al nome della colonna mentre
            // value è il valore stesso della colonna.
            //User::create([
            //  'firstname' => $row['firstname'],
            //  'lastname' => $row['lastname'],
            //  . . . .
            //]);
        }
    }*/

    // Invocato quando l'import viene eseguito tramite il metodo Excel::import(), ma solo se questa
    // classe implementa anche l'interface OnEachRow.
    // Di norma, il metodo onRow() è utilizzato quando le colonne importate non corrispondono
    // direttamente al modello della tabella destinazione (colonne con diverso nome o i cui valori
    // richiedono delle modifiche prima di essere inseriti).
    // Si ha quindi il controllo totale sui dati delle rows prima che queste vengano inserite nel DB.
    // Il metodo onRow() è invocato per ogni row importata del worksheet corrente.
    /*public function onRow(Row $row)
    {
        $rowIndex = $row->getIndex();  // Numero della row corrente effettiva importata da Excel.

        // La $row corrisponde ad una collection delle colonne della row correntemente importata.
        // Se necessario, le colonne della row possono essere filtrate tramite il metodo $row->only().

        // Ritorna un array associativo key => value, key corrisponde al nome della colonna mentre
        // value è il valore stesso della colonna.
        $rowArr = $row->toArray();
    }*/
}
