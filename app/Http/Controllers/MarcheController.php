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
        // 1. Charger les marchés avec les compteurs calculés en une seule requête SQL
        // On utilise withCount pour les relations directes et imbriquées
        $marches = Marche::withCount([
            'zones', 
            // Pour compter les hangars à travers les zones
            'zones as hangars_count' => function ($query) {
                $query->join('hangars', 'zones.id', '=', 'hangars.zone_id');
            },
            // Pour compter les places à travers zones -> hangars
            'zones as places_count' => function ($query) {
                $query->join('hangars', 'zones.id', '=', 'hangars.zone_id')
                      ->join('places', 'hangars.id', '=', 'places.hangar_id');
            }
        ])
        ->orderBy('created_at', 'desc')
        ->paginate(12);

        // 2. Compte simple pour les statistiques du mois
        $recentMarchesCount = Marche::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

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