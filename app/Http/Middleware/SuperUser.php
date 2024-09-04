<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SuperUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Se l'utente non è un Super User ('siteAdmin'), reindirizza alla root page.
        if ($request->user()->role != 'siteAdmin') {
            return $request->expectsJson() ? abort(403, 'You must be a Super User.') :
                                             redirect('/');
        }

        return $next($request);
    }
}
