<?php

namespace App\Http\Controllers;

use App\Models\Marche;
use App\Models\User;
use App\Models\Zone;
use App\Models\Collecte;
use App\Models\Depot;
use App\Models\Place;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class RegisseurController extends Controller
{
    /**
     * ==================== DASHBOARD ====================
     */
    public function dashboard()
    {
        // Statistiques pour le dashboard
        $stats = [
            'total_marches' => Marche::count(),
            'total_agents' => User::whereHas('role', function($q) {
                $q->where('name', 'agent');
            })->count(),
            'collectes_aujourdhui' => Collecte::whereDate('date_collecte', today())->count(),
            'montant_depots_aujourdhui' => Depot::whereDate('created_at', today())->sum('montant'),
        ];
        
        // Derniers dépôts effectués par ce régisseur
        $depots_recents = Depot::where('regisseur_id', Auth::id())
            ->with('agent')
            ->latest()
            ->take(5)
            ->get();
            
        // Agents avec leurs zones
        $agents = User::whereHas('role', function($q) {
            $q->where('name', 'agent');
        })->with(['zone.marche'])->take(5)->get();
        
        return view('regisseur.dashboard', compact('stats', 'depots_recents', 'agents'));
    }
    
    /**
     * ==================== MARCHES ====================
     * Consultation seulement
     */
        public function marches()
        {
            $marches = Marche::with([
                    'zones.agent',   // charge les agents liés aux zones
                    'zones.hangars', // charge les hangars liés aux zones
                    'zones.places'   // charge les places liés aux zones
                ])
                ->withCount(['zones', 'collectes']) // compte zones et collectes par marché
                ->orderBy('nom')
                ->paginate(15);

            return view('regisseur.marches.index', compact('marches'));
        }

    
    /**
     * ==================== ZONES====================
     * Consultation avec zones et agents affectés
     */
    public function zones()
        {
            $zones = Zone::with(['marche', 'agent', 'hangars', 'places'])
                ->orderBy('nom_zone')
                ->paginate(15);

            return view('regisseur.zones.index', compact('zones'));
        }


    
    
    

    /**
     * ==================== DEPOTS ====================
     */
    
    // Liste des dépôts effectués par ce régisseur
    public function depots()
    {
        $depots = Depot::where('regisseur_id', Auth::id())
            ->with(['agent', 'agent.zone.marche'])
            ->latest()
            ->paginate(20);
            
        return view('regisseur.depots.index', compact('depots'));
    }
    
    // Formulaire pour créer un nouveau dépôt
    public function createDepot()
    {
        // Agents qui ont au moins une zone assignée
            $agents = User::whereHas('role', function($q) {
            $q->where('name', 'agent');
        })
        ->whereHas('zone') // fonctionne car User::zone() est défini
        ->with(['zone.marche'])
        ->orderBy('name')
        ->get();

        
        return view('regisseur.depots.create', compact('agents'));
    }
    
    // Enregistrer un nouveau dépôt
    public function storeDepot(Request $request)
    {
        $request->validate([
            'agent_id' => 'required|exists:users,id',
            'montant' => 'required|numeric|min:1',
            'observations' => 'nullable|string|max:500',
        ]);
        
        $depot = Depot::create([
            'agent_id' => $request->agent_id,
            'regisseur_id' => Auth::id(),
            'montant' => $request->montant,
            'observations' => $request->observations,
            'date_depot' => now(),
        ]);
        
        // Générer le numéro de reçu (ex: DEP-2024-001)
        $depot->update([
            'numero_recu' => 'DEP-' . date('Y') . '-' . str_pad($depot->id, 3, '0', STR_PAD_LEFT)
        ]);
        
        return redirect()->route('regisseur.depots.recu', $depot)
            ->with('success', 'Dépôt enregistré avec succès !');
    }
    
    // Afficher le reçu du dépôt
    public function showRecu(Depot $depot)
    {
        // Vérifier que le reçu appartient à ce régisseur
        if ($depot->regisseur_id !== Auth::id()) {
            abort(403, 'Accès non autorisé à ce reçu.');
        }
        
        $depot->load(['agent', 'agent.zone.marche', 'regisseur']);
        
        return view('regisseur.depots.recu', compact('depot'));
    }
    
    


/**
 * ==================== COLLECTES ====================
 * Voir les collectes des agents
 */
public function collectes(Request $request)
{
    $agents = User::whereHas('role', fn($q) => $q->where('name', 'agent'))
                  ->orderBy('name')->get();

    $zones = Zone::orderBy('id')->get();

    $query = Collecte::with(['agent', 'place.hangar.zone.marche']);

    if ($request->filled('agent_id')) {
        $query->where('agent_id', $request->agent_id);
    }
    if ($request->filled('date_debut')) {
        $query->whereDate('date_collecte', '>=', $request->date_debut);
    }
    if ($request->filled('date_fin')) {
        $query->whereDate('date_collecte', '<=', $request->date_fin);
    }
    if ($request->filled('zone_id')) {
        $query->whereHas('place.hangar.zone', fn($q) => $q->where('id', $request->zone_id));
    }
    if ($request->filled('type_collecte')) {
        $query->where('type_collecte', $request->type_collecte);
    }

    $collectes = $query->get();

    // Regroupement par agent → place → type_collecte
    $grouped = $collectes->groupBy('agent_id')->map(fn($agentCollectes) =>
        $agentCollectes->groupBy('place_id')->map(fn($placeCollectes) =>
            $placeCollectes->groupBy('type_collecte')->map(fn($typeCollectes) => [
                'count' => $typeCollectes->count(),
                'total' => $typeCollectes->sum('montant'),
                'items' => $typeCollectes
            ])
        )
    );

    $totalMontant = $collectes->sum('montant');
    $totalCollectes = $collectes->count();
    return view('regisseur.collectes.index', compact(
        'agents', 'zones', 'grouped', 'totalMontant', 'totalCollectes'
    ));
}
}