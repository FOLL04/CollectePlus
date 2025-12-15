<?php

namespace App\Http\Controllers;

use App\Models\Marche;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MarcheController extends Controller
{
    /**
     * Liste des marchés.
     */
   public function index()
{
    // Charger les marchés avec toutes les relations imbriquées
    $marches = Marche::with([
            'zones.hangars.places' // relation complète imbriquée
        ])
        ->orderBy('created_at', 'desc')
        ->paginate(12);

    // Compter les marchés créés ce mois-ci
    $recentMarchesCount = Marche::whereMonth('created_at', now()->month)->count();

    // Pour chaque marché, calculer les totaux
    foreach ($marches as $marche) {
        $marche->zones_count = $marche->zones->count();

        $marche->hangars_count = $marche->zones->sum(function ($zone) {
            return $zone->hangars->count();
        });

        $marche->places_count = $marche->zones->sum(function ($zone) {
            return $zone->hangars->sum(function ($hangar) {
                return $hangar->places->count();
            });
        });
    }

    return view('marches.index', compact(
        'marches',
        'recentMarchesCount'
    ));
}


    /**
     * Formulaire de création.
     */
    public function create()
    {
        return view('marches.create');
    }

    /**
     * Enregistrement d'un nouveau marché.
     */
    public function store(Request $request)
    {
        $validated = $this->validateMarche($request);

        Marche::create([
            ...$validated,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('marches.index')
                         ->with('success', 'Marché créé avec succès.');
    }

    /**
     * Détails d'un marché.
     */
    public function show($id)
    {
        $marche = Marche::findOrFail($id);
        return view('marches.edit', compact('marche'));
    }

    /**
     * Formulaire d'édition.
     */
    public function edit($id)
    {
        $marche = Marche::findOrFail($id);
        return view('marches.edit', compact('marche'));
    }

    /**
     * Mise à jour d'un marché.
     */
    public function update(Request $request, $id)
    {
        $validated = $this->validateMarche($request);

        $marche = Marche::findOrFail($id);
        $marche->update($validated);

        return redirect()->route('marches.index')
                         ->with('success', 'Marché mis à jour avec succès.');
    }

    /**
     * Suppression d'un marché.
     */
    public function destroy($id)
    {
        Marche::findOrFail($id)->delete();

        return redirect()->route('marches.index')
                         ->with('success', 'Marché supprimé avec succès.');
    }

    /**
     * Validation commune.
     */
    protected function validateMarche(Request $request): array
    {
        return $request->validate([
            'nom' => 'required|string|max:255',
            'localisation' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
    }
}