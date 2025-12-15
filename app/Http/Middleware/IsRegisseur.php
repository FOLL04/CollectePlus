<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsRegisseur
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        
        // Vérifie si l'utilisateur a le rôle "regisseur"
        if ($user->role && $user->role->name === 'regisseur') {
            return $next($request);
        }

        abort(403, 'Accès réservé aux régisseurs.');
    }
}