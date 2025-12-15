<?php

namespace App\Http\Controllers;

use App\Models\Place;
use Illuminate\Http\Request;

class PlaceController extends Controller
{
    /**
     * Liste de toutes les places
     * (sans charger les collectes)
     */
    public function index()
    {
        // On récupère uniquement les infos de la place, hangar, zone et marché
        $places = Place::with('hangar.zone.marche')->get();
        return view('places.index', compact('places'));
    }

    /**
     * Formulaire de création
     */
    public function create()
    {
        $hangars = \App\Models\Hangar::with('zone.marche')->get();
        return view('places.create', compact('hangars'));
    }

    /**
     * Crée une nouvelle place
     * (aucune collecte n’est liée ici)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'hangar_id'     => 'required|exists:hangars,id',
            'numero_place'  => 'required|string|max:10',
            'type_place'    => 'required|string|in:boutique,hangar',
            'loyer_mensuel' => 'nullable|numeric|min:0',
            'taxe_mensuelle'=> 'nullable|numeric|min:0',
        ]);

        Place::create($validated);

        return redirect()->route('places.index')
                         ->with('success', 'Place créée avec succès.');
    }

    /**
     * Affiche une place spécifique
     * (sans collectes, elles seront gérées ailleurs)
     */
    public function show($id)
    {
        $place = Place::with('hangar.zone.marche')->findOrFail($id);
        return view('places.show', compact('place'));
    }

    /**
     * Formulaire d’édition
     */
    public function edit($id)
    {
        $place   = Place::findOrFail($id);
        $hangars = \App\Models\Hangar::with('zone.marche')->get();
        return view('places.edit', compact('place', 'hangars'));
    }

    /**
     * Met à jour une place existante
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'hangar_id'     => 'required|exists:hangars,id',
            'numero_place'  => 'required|string|max:10',
            'type_place'    => 'required|string|in:boutique,hangar',
            'loyer_mensuel' => 'nullable|numeric|min:0',
            'taxe_mensuelle'=> 'nullable|numeric|min:0',
        ]);

        $place = Place::findOrFail($id);
        $place->update($validated);

        return redirect()->route('places.index')
                         ->with('success', 'Place mise à jour avec succès.');
    }

    /**
     * Supprime une place
     */
    public function destroy($id)
    {
        Place::destroy($id);

        return redirect()->route('places.index')
                         ->with('success', 'Place supprimée avec succès.');
    }
}
