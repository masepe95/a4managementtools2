<?php

namespace App\Http\Controllers;

use Exception;
use App\Imports\ExcelImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;

class ExcelImportController extends Controller
{
    // Ritorna un array con le row importate da un Excel, ogni row è a sua volta un array
    // associativo contenente le varie colonne (colName => colValue).
    // Ritorna anche un array con le eventuali row invalide (vedi statement return).
    public static function getExcelRows($filename, $required, $rules, $valueMap = [],
                                        $keyRename = [], $firstDataRowIndex = 2): Array
    {
        $excelData = Excel::toArray(new ExcelImport, $filename);

        $rows = []; $invalidRows = [];
        $cntRequired = count($required);
        $allFields = array_keys($rules);

        // Itera tutte le row importate dell'Excel.
        // Nota: $excelData[0] corrisponde alle rows del primo worksheet, eventualmente
        //       implementare l'iterazione di tutti i worksheet.
        // Nota: l'array $sheetNames nella classe ExcelImport non viene popolato, utilizzare
        //       il metodo sheets().
        //       Vedi https://docs.laravel-excel.com/3.1/imports/multiple-sheets.html
        foreach ($excelData[0] as $index => $row) {
            // La variavile $index è l'id della row corrente.

            // Itera tutti i field obbligatori della row.
            for ( $n = 0; $n < $cntRequired; $n++ ) {
                // Termina l'iterazione se un field non è null.
                // Se anche un solo field obbligatorio non è null, l'intera row verrà validata.
                if (!is_null($row[$required[$n]])) break;
            }

            // Se tutti i field obbligatori sono null, assumi la row come vuota e ignorala.
            if ($n >= $cntRequired) continue;

            try {
                Validator::make($row, $rules)->validate();

                // Includi solo i field attesi (required & optionals).
                $r = Arr::only($row, $allFields);

                // Esegui il value mapping.
                foreach ($valueMap as $key => $values) {
                    foreach ($values as $oldValue => $newValue) {
                        if ($r[$key] == $oldValue) {
                            $r[$key] = $newValue;
                            break;
                        }
                    }
                }

                // Esegui l'eventuale key rename.
                foreach ($keyRename as $oldKey => $newKey) {
                    if (array_key_exists($oldKey, $r)) {
                        // Crea una nuova entry con la nuova key (e con lo stesso valore della
                        // precedente key) ed elimina la precedente key.
                        $r[$newKey] = $r[$oldKey];
                        unset($r[$oldKey]);
                    }
                }

                $rows[] = $r;
            } catch (Exception $e) {
                // Aggiungi il numero della row dell'Excel che contiene dei dati invalidi.
                $invalidRows[] = [ 'index' => $index + $firstDataRowIndex, 'error' => $e->getMessage() ];
            }
        }

        return [ 'rows' => $rows, 'invalidRows' => $invalidRows ];
    }
}
