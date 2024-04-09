<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->role === 'admin') {
            return $next($request);
        }
        // Reindirizza l'utente se non è un amministratore
        return redirect('/')->with('error', 'Accesso non autorizzato.');
    }
}
