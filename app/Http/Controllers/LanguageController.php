<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\RedirectResponse;

class LanguageController extends Controller
{
    public function change(Request $request): RedirectResponse
    {
        App::setLocale($request->locale);

        // Crea il cookie con il "locale" appena impostato (525600 minuti = 365 giorni).
        $cookie = Cookie::make('current-locale', $request->locale, 525600,
                               null, null, true, true, false, 'strict');

        // Torna alla pagina precedente e invia il cookie.
        return redirect()->back()->withCookie($cookie);
    }
}
