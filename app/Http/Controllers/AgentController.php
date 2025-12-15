<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Collecte;
use App\Models\Place;
use Illuminate\Support\Facades\Auth;

class AgentController extends Controller
{
    /**
     * Page index : formulaire pour enregistrer une collecte
     */
    public function index()
    {
        $agent = Auth::user(); // agent connecté
        $zone   = $agent->zone; // relation hasOne
        $marche = $zone ? $zone->marche : null;

        return view('agent.index', compact('agent', 'zone', 'marche'));
    }

    /**
     * Enregistrer une collecte
     */
    public function store(Request $request)
    {
        $request->validate([
            'numero_place'  => 'required|string|max:50',
            'type_collecte' => 'required|in:journalier,loyer,mensuel,taxe,amende',
            'montant'       => 'required|numeric|min:0',
            'date_collecte' => 'required|date',
            'observations'  => 'nullable|string',
        ]);

        $agent = Auth::user();

        // Retrouver la place par son numéro
        $place = Place::where('numero_place', $request->numero_place)->firstOrFail();

        // Création de la collecte
        $collecte = Collecte::create([
            'agent_id'      => $agent->id,
            'place_id'      => $place->id,
            'type_collecte' => $request->type_collecte,
            'montant'       => $request->montant,
            'date_collecte' => $request->date_collecte,
            'observations'  => $request->observations,
        ]);

        return redirect()->route('agent.recu', $collecte->id);
    }

    /**
     * Page journalier : voir les collectes du jour
     */
    public function journalier()
    {
        $agent = Auth::user();
        $today = now()->toDateString();

        $collectes = Collecte::where('agent_id', $agent->id)
            ->whereDate('date_collecte', $today)
            ->with(['place.hangar.zone.marche'])
            ->get();

        return view('agent.journalier', compact('collectes', 'today', 'agent'));
    }

    /**
     * Page reçu : imprimer un reçu pour un marchand
     */
    public function recu($id)
    {
        $collecte = Collecte::with(['agent', 'place.hangar.zone.marche'])->findOrFail($id);
        return view('agent.recu', compact('collecte'));
    }
}
