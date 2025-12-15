<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //  Liste des utilisateurs
    public function index()
    {
        $users = User::with('role')->get(); // chargement du rôle
        return view('users.index', compact('users'));
    }

    //  Formulaire de création
    public function create()
    {
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    //  Enregistrement d’un nouvel utilisateur
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'                   => 'required|string|max:255',
            'email'                  => 'required|email|unique:users',
            'phone'                  => 'required|string|max:20',
            'password'               => 'required|min:6',
            'role_id'                => 'required|exists:roles,id',
            'identity_card_number'   => 'nullable|string|max:50',
            'address'                => 'nullable|string|max:255',
            'emergency_contact_name' => 'nullable|string|max:255',
            'emergency_contact_phone'=> 'nullable|string|max:20',
            'gender'                 => 'nullable|in:Homme,Femme',
            'birth_date'             => 'nullable|date',
        ]);

        User::create([
            'name'                   => $validated['name'],
            'email'                  => $validated['email'],
            'phone'                  => $validated['phone'],
            'password'               => Hash::make($validated['password']),
            'role_id'                => $validated['role_id'],
            'status'                 => true,
            'created_by'             => Auth::id(),
            'identity_card_number'   => $validated['identity_card_number'] ?? null,
            'address'                => $validated['address'] ?? null,
            'emergency_contact_name' => $validated['emergency_contact_name'] ?? null,
            'emergency_contact_phone'=> $validated['emergency_contact_phone'] ?? null,
            'gender'                 => $validated['gender'] ?? null,
            'birth_date'             => $validated['birth_date'] ?? null,
        ]);

        return redirect()->route('users.index')->with('success', 'Utilisateur créé avec succès.');
    }

    //  Formulaire de modification
    public function edit(User $user)
    {
        $roles = Role::all();
        return view('users.edit', compact('user', 'roles'));
    }

    //  Mise à jour d’un utilisateur
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name'                   => 'required|string|max:255',
            'email'                  => 'required|email|unique:users,email,' . $user->id,
            'phone'                  => 'required|string|max:20',
            'role_id'                => 'required|exists:roles,id',
            'identity_card_number'   => 'nullable|string|max:50',
            'address'                => 'nullable|string|max:255',
            'emergency_contact_name' => 'nullable|string|max:255',
            'emergency_contact_phone'=> 'nullable|string|max:20',
            'gender'                 => 'nullable|in:Homme,Femme',
            'birth_date'             => 'nullable|date',
        ]);

        $user->update([
            'name'                   => $validated['name'],
            'email'                  => $validated['email'],
            'phone'                  => $validated['phone'],
            'role_id'                => $validated['role_id'],
            'identity_card_number'   => $validated['identity_card_number'] ?? $user->identity_card_number,
            'address'                => $validated['address'] ?? $user->address,
            'emergency_contact_name' => $validated['emergency_contact_name'] ?? $user->emergency_contact_name,
            'emergency_contact_phone'=> $validated['emergency_contact_phone'] ?? $user->emergency_contact_phone,
            'gender'                 => $validated['gender'] ?? $user->gender,
            'birth_date'             => $validated['birth_date'] ?? $user->birth_date,
        ]);

        return redirect()->route('users.index')->with('success', 'Utilisateur mis à jour avec succès.');
    }

    //  Suppression d’un utilisateur
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Utilisateur supprimé.');
    }

    // Ajoutez cette méthode dans UserController
public function toggleStatus(Request $request, User $user)
{
    $request->validate([
        'status' => 'required|boolean'
    ]);
    
    $user->update(['status' => $request->status]);
    
    return response()->json([
        'success' => true,
        'message' => 'Statut mis à jour avec succès'
    ]);
}
}
