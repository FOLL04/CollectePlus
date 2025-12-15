<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Affiche le formulaire de login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Traite la tentative de connexion
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Redirection selon le rôle
            switch ($user->role->name) {
                case 'admin':
                    return redirect()->route('admin.dashboard');
                case 'agent':
                    return redirect()->route('agent.index');
                case 'regisseur':
                    return redirect()->route('regisseur.dashboard');
                default:
                    return redirect()->route('marches.index');
            }
        }

        return back()->withErrors([
            'email' => 'Les identifiants ne correspondent pas.',
        ]);
    }

    // Déconnexion
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
