<?php

namespace App\Http\Controllers;

use App\Models\Collecte;
use App\Models\User;
use App\Models\Place;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class CollecteController extends Controller
{
    
    /**
     * Liste des collectes selon le rôle
     */
  public function index(Request $request)
{
    $user = auth()->user();

    $agentId  = $request->input('agent_id');
    $placeId  = $request->input('place_id');
    $mois     = $request->input('mois'); // YYYY-MM

    // ADMIN → toutes les collectes
    if ($user->hasRole('admin')) {
        $collectes = Collecte::with(['agent', 'place'])
            ->when($mois, fn($q) => $q->whereYear('date_collecte', substr($mois, 0, 4))
                                      ->whereMonth('date_collecte', substr($mois, 5, 2)))
            ->when($agentId, fn($q) => $q->where('agent_id', $agentId))
            ->when($placeId, fn($q) => $q->where('place_id', $placeId))
            ->orderByDesc('date_collecte')
            ->paginate(50);

        // correction : filtrer via la relation role
        $agents = User::whereHas('role', fn($q) => $q->where('name', 'agent'))->get();
        $places = Place::all();

        return view('collectes.index', compact('collectes', 'agents', 'places', 'agentId', 'placeId', 'mois'));
    }

    // REGISSEUR → toutes les collectes mais pagination réduite
    if ($user->hasRole('regisseur')) {
        $collectes = Collecte::with(['agent', 'place'])
            ->when($mois, fn($q) => $q->whereYear('date_collecte', substr($mois, 0, 4))
                                      ->whereMonth('date_collecte', substr($mois, 5, 2)))
            ->when($agentId, fn($q) => $q->where('agent_id', $agentId))
            ->when($placeId, fn($q) => $q->where('place_id', $placeId))
            ->orderByDesc('date_collecte')
            ->paginate(30);

        //  correction : filtrer via la relation role
        $agents = User::whereHas('role', fn($q) => $q->where('name', 'agent'))->get();
        $places = Place::all();

        return view('regisseur.collectes.index', compact('collectes', 'agents', 'places', 'agentId', 'placeId', 'mois'));
    }

    // AGENT → uniquement ses collectes du jour
    if ($user->hasRole('agent')) {
        $collectes = Collecte::with('place')
            ->where('agent_id', $user->id)
            ->whereDate('date_collecte', now()->toDateString())
            ->orderByDesc('date_collecte')
            ->get();

        return view('agent.collectes.journalier', compact('collectes'));
    }

    abort(403, 'Accès non autorisé');
}

public function edit(Collecte $collecte)
{
    $user = auth()->user();
    abort_unless($user->hasRole('regisseur'), 403);

    $places = Place::orderBy('numero')->get();
    $agents = User::where('role','agent')->get();

    return view('regisseur.collectes.edit', compact('collecte','places','agents'));
}

public function update(Request $request, Collecte $collecte)
{
    $user = auth()->user();
    abort_unless($user->hasRole('regisseur'), 403);

    $validated = $request->validate([
        'agent_id'     => 'required|exists:users,id',
        'place_id'     => 'required|exists:places,id',
        'type_collecte'=> 'required|in:journalier,mensuel',
        'montant'      => 'required|numeric|min:0',
        'date_collecte'=> 'required|date',
        'recu_path'    => 'nullable|string|max:255',
    ]);

    $collecte->update($validated);

    return redirect()->route('collectes.index')
        ->with('success','Collecte modifiée par le régisseur avec succès.');
}
public function ficheJournalier(Request $request)
{
    $user = auth()->user();
    abort_unless($user->hasRole('regisseur'), 403);

    $date = $request->input('date', now()->toDateString());
    $placeId = $request->input('place_id');

    $agents = User::where('role','agent')->get();
    $fiches = [];

    foreach ($agents as $agent) {
        $items = Collecte::with('place')
            ->whereDate('date_collecte',$date)
            ->where('agent_id',$agent->id)
            ->when($placeId, fn($q) => $q->where('place_id',$placeId))
            ->orderBy('place_id')
            ->get();

        $parType = $items->groupBy('type_collecte')->map(function(Collection $col){
            return [
                'count' => $col->count(),
                'total' => $col->sum('montant'),
            ];
        });

        $totalGeneral = $items->sum('montant');

        $fiches[] = [
            'agent'        => $agent,
            'items'        => $items,
            'par_type'     => $parType,
            'total_general'=> $totalGeneral,
        ];
    }

    return view('regisseur.collectes.fiche_journalier', compact('date','placeId','fiches'));
}



public function imprimer(Request $request)
{
    // Récupérer les filtres comme dans index
    $agentId = $request->input('agent_id');
    $mois = $request->input('mois');

    $query = Collecte::with('agent');

    if ($agentId) {
        $query->where('agent_id', $agentId);
    }

    if ($mois) {
        $query->whereMonth('date_collecte', Carbon::parse($mois)->month)
              ->whereYear('date_collecte', Carbon::parse($mois)->year);
    }

    $collectes = $query->get();

    $pdf = Pdf::loadView('collectes.pdf', compact('collectes', 'mois'))
              ->setPaper('A4', 'landscape');

    return $pdf->download('collectes_admin.pdf');
}




}