<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class GetImage extends Controller
{
    public static function getImageInfo($photo, $noImage = ''): string
    {
        // Questa funzione statica è invocata dal metodo edit() di questa classe e da
        // diversi altri metodi di altre classi di Controller.

        // Se nessuna foto è stata specificata, ritorna l'URL dell'immagine 'no-user'.
        if (is_null($photo)) return $noImage;

        // Ritorna l'immagine inline (da assegnare all'attributo 'src' di <img />).
        // Formato:
        //   <img src='data:[<mime type>][;charset=<charset>][;base64],<encoded data>' .... />
        // Nota: se la funzione getimagesizefromstring() ritorna un array, allora l'immagine
        //       nel campo `photo_file` della tabella `employee` è un jpg o un png.
        //       Se getimagesizefromstring() ritorna false e simplexml_load_string() ritorna
        //       un oggetto SimpleXMLElement valido, allora l'immagine è una svg.
        if (($img = getimagesizefromstring($photo)) !== false) $mime = (isset($img['mime'])) ? $img['mime'] : 'image/png';
        elseif (simplexml_load_string($photo)) $mime = 'image/svg+xml';
        // Se il formato non è stato rilevato, ritorna l'URL dell'immagine 'no-user'.
        else return $noImage;

        $base64 = base64_encode($photo);
        return "data:$mime;base64,$base64";  // Double-quote per espandere i valori delle variabili.
    }

    public function photo(Request $request): JsonResponse
    {
        // Questo metodo è richiamato dallo script 'admin.js' tramite Ajax (route '/get-photo').
        return response()->json([ 'src' => GetImage::getImageInfo($request->user()->photo_file, 'images/no-user.png') ]);
    }
}
