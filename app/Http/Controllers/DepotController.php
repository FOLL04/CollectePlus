<?php

namespace App\Http\Controllers;

use App\Models\Depot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class DepotController extends Controller
{
    public function index(Request $request)
{
    $query = Depot::with(['agent.zone.marche', 'regisseur'])->latest();

    // Si un marché est sélectionné
    if ($request->filled('marche_id')) {
        $query->whereHas('agent.zone.marche', function ($q) use ($request) {
            $q->where('id', $request->marche_id);
        });
    }

    $depots = $query->get();

    // Charger la liste des marchés pour le select
    $marches = \App\Models\Marche::all();

    return view('depots.index', compact('depots', 'marches'));
}


    // Formulaire de création (uniquement pour les agents)
    public function create()
    {
        if (Auth::user()->role === 'admin') {
            abort(403, 'Les administrateurs ne peuvent pas effectuer de dépôts.');
        }

        return view('depots.create');
    }

    // Enregistrement d’un dépôt (agent → régisseur)
    public function store(Request $request)
    {
        if (Auth::user()->role === 'admin') {
            abort(403, 'Les administrateurs ne peuvent pas effectuer de dépôts.');
        }

        $validated = $request->validate([
            'regisseur_id' => 'required|exists:users,id',
            'montant' => 'required|numeric|min:0',
            'date_depot' => 'required|date',
            'recu_path' => 'nullable|string',
        ]);

        Depot::create([
            ...$validated,
            'agent_id' => Auth::id(), // l’agent connecté
        ]);

        return redirect()->route('depots.index')->with('success', 'Dépôt enregistré avec succès.');
    }

    // Affiche un dépôt spécifique
    public function show($id)
    {
        $depot = Depot::with(['agent', 'regisseur'])->findOrFail($id);
        return view('depots.show', compact('depot'));
    }

    //imprimer une fiche de tout les depots avec filtrage date debut et date fin
    public function imprimer(Request $request)
    {
        $query = Depot::with(['agent', 'regisseur'])->orderBy('date_depot', 'desc'); 
        if ($request->has('date_debut') && $request->date_debut) {
            $dateDebut = Carbon::parse($request->date_debut)->startOfDay();
            $query->where('date_depot', '>=', $dateDebut);
        }
        if ($request->has('date_fin') && $request->date_fin) {
            $dateFin = Carbon::parse($request->date_fin)->endOfDay();
            $query->where('date_depot', '<=', $dateFin);
}

        $depots = $query->get();

        $pdf = Pdf::loadView('depots.pdf', compact('depots'))
                  ->setPaper('A4', 'landscape');

        return $pdf->download('depots.pdf');
    }
}