<?php

namespace App\Http\Controllers;

use App\Models\Zone;
use Illuminate\Http\Request;
use App\Models\Marche;
use App\Models\User;

class ZoneController extends Controller
{
    /**
     * Affiche la liste de toutes les zones avec leurs places, marché et agent.
     */
        public function index()
    {
        $zones = Zone::with(['places', 'marche', 'agent'])->get();
        return view('zones.index', compact('zones'));
    }

    /**
     * Affiche le formulaire de création d’une zone.
     * On récupère les marchés et les agents ayant le rôle "agent".
     */
    public function create()
    {
        $marches = Marche::all();

        //  Correction ici : on filtre les utilisateurs ayant le rôle "agent"
        $agents = User::whereHas('role', function ($query) {
            $query->where('name', 'agent');
        })->get();

        return view('zones.create', compact('marches', 'agents'));
    }

    /**
     * Enregistre une nouvelle zone avec un agent obligatoire.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom_zone'   => 'required|string|max:255',
            'marche_id'  => 'required|exists:marches,id',
            'agent_id'   => 'required|exists:users,id', // ✅ agent obligatoire
            'description'=> 'nullable|string',
        ]);

        Zone::create($validated);

        return redirect()->route('zones.index')
                         ->with('success', 'Zone créée avec succès.');
    }

    /**
     * Affiche les détails d’une zone spécifique.
     */
    public function show($id)
    {
        $zone = Zone::with(['places', 'marche', 'agent'])->findOrFail($id);
        return view('zones.show', compact('zone'));
    }

    /**
     * Affiche le formulaire d’édition d’une zone.
     */
    public function edit($id)
    {
        $zone = Zone::findOrFail($id);
        $marches = Marche::all();

        //  même correction ici
        $agents = User::whereHas('role', function ($query) {
            $query->where('name', 'agent');
        })->get();

        return view('zones.edit', compact('zone', 'marches', 'agents'));
    }

    /**
     * Met à jour une zone existante avec agent obligatoire.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nom_zone'   => 'required|string|max:255',
            'marche_id'  => 'required|exists:marches,id',
            'agent_id'   => 'required|exists:users,id', // ✅ agent obligatoire
            'description'=> 'nullable|string',
        ]);

        $zone = Zone::findOrFail($id);
        $zone->update($validated);

        return redirect()->route('zones.index')
                         ->with('success', 'Zone mise à jour avec succès.');
    }

    /**
     * Supprime une zone.
     */
    public function destroy($id)
    {
        Zone::destroy($id);

        return redirect()->route('zones.index')
                         ->with('success', 'Zone supprimée avec succès.');
    }
}
