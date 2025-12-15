<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Collecte;
use App\Models\Marche;
use App\Models\Depot;
use App\Models\Zone;
use PDF; // barryvdh/laravel-dompdf
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class RapportController extends Controller
{
    /**
     * ==================== RAPPORT PAR AGENT ====================
     */
    public function rapportAgent(Request $request)
    {
        // Récupérer tous les agents pour le formulaire de filtre
        $agents = User::whereHas('role', function($q) {
            $q->where('name', 'agent');
        })->orderBy('name')->get();
        
        // Définir les dates par défaut (mois en cours)
        $dateDebut = $request->input('date_debut', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $dateFin = $request->input('date_fin', Carbon::now()->format('Y-m-d'));
        $agentId = $request->input('agent_id');
        
        $collectes = collect();
        $statistiques = [];
        $agent = null;
        
        if ($agentId) {
            // Récupérer l'agent sélectionné
            $agent = User::with(['zone.marche'])->find($agentId);
            
            // Récupérer les collectes avec filtres
            $collectes = Collecte::with(['place.hangar.zone.marche'])
                ->where('agent_id', $agentId)
                ->whereBetween('date_collecte', [$dateDebut, $dateFin])
                ->orderBy('date_collecte')
                ->get();
            
            // Calculer les statistiques par type de collecte
            $statistiques = [
                'total_general' => $collectes->sum('montant'),
                'nombre_total' => $collectes->count(),
                'par_type' => $collectes->groupBy('type_collecte')->map(function($items) {
                    return [
                        'montant' => $items->sum('montant'),
                        'nombre' => $items->count(),
                        'moyenne' => $items->avg('montant')
                    ];
                }),
                'par_jour' => $collectes->groupBy('date_collecte')->map(function($items) {
                    return [
                        'montant' => $items->sum('montant'),
                        'nombre' => $items->count()
                    ];
                })
            ];
        }
        
        return view('regisseur.rapports.agent', compact(
            'agents', 'agent', 'collectes', 'statistiques', 'dateDebut', 'dateFin'
        ));
    }
    
    /**
     * ==================== IMPRESSION RAPPORT AGENT (PDF) ====================
     */
    public function imprimerRapportAgent(Request $request)
    {
        $request->validate([
            'agent_id' => 'required|exists:users,id',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date',
        ]);
        
        $agent = User::with(['zone.marche'])->find($request->agent_id);
        
        $collectes = Collecte::with(['place.hangar.zone.marche'])
            ->where('agent_id', $request->agent_id)
            ->whereBetween('date_collecte', [$request->date_debut, $request->date_fin])
            ->orderBy('date_collecte')
            ->get();
        
        // Statistiques générales
        $statistiques = [
            'total_general' => $collectes->sum('montant'),
            'nombre_total' => $collectes->count(),
        ];
        
        // Collectes par type
        $collectesParType = $collectes->groupBy('type_collecte')->map(function($items) use ($statistiques) {
            return [
                'montant' => $items->sum('montant'),
                'nombre' => $items->count(),
                'pourcentage' => $statistiques['total_general'] > 0 
                    ? round(($items->sum('montant') / $statistiques['total_general']) * 100, 2)
                    : 0
            ];
        });
        
        // Collectes par jour
        $collectesParJour = $collectes->groupBy('date_collecte')->map(function($items) {
            return [
                'montant' => $items->sum('montant'),
                'nombre' => $items->count()
            ];
        })->sortKeys();
        
        $data = [
            'agent' => $agent,
            'collectes' => $collectes,
            'statistiques' => $statistiques,
            'collectesParType' => $collectesParType,
            'collectesParJour' => $collectesParJour,
            'dateDebut' => $request->date_debut,
            'dateFin' => $request->date_fin,
        ];
        
        // Générer le PDF
        $pdf = PDF::loadView('regisseur.rapports.pdf.agent', $data)
            ->setPaper('A4', 'portrait');
        
        return $pdf->stream('rapport_agent_' . $agent->name . '_' . date('Y-m-d') . '.pdf');
    }
    
    /**
     * ==================== RAPPORT PAR MARCHÉ ====================
     */
    public function rapportMarche(Request $request)
    {
        $marches = Marche::orderBy('nom')->get();

        $marcheId = $request->input('marche_id');
        $dateDebut = $request->input('date_debut', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $dateFin = $request->input('date_fin', Carbon::now()->format('Y-m-d'));

        $marche = null;

        $query = Collecte::with(['agent', 'place.hangar.zone.marche'])
            ->whereBetween('date_collecte', [$dateDebut, $dateFin])
            ->orderBy('date_collecte');

        if ($marcheId && $marcheId != '') {
            $marche = Marche::find($marcheId);
            $query->whereHas('place.hangar.zone.marche', function($q) use ($marcheId) {
                $q->where('id', $marcheId);
            });
        }

        $collectes = $query->get();

        // Statistiques générales
        $statistiques = [
            'total_collectes' => $collectes->count(),
            'total_montant' => $collectes->sum('montant'),
            'moyenne_par_collecte' => $collectes->avg('montant'),
            'nombre_agents' => $collectes->pluck('agent_id')->unique()->count(),
            'nombre_zones' => $collectes->pluck('place.hangar.zone.id')->unique()->count()
        ];

        // Collectes par zone
        $collectesParZone = $collectes->groupBy(function($item) {
            return optional($item->place->hangar->zone)->nom ?? 'Zone inconnue';
        })->map(function($items) {
            return [
                'montant' => $items->sum('montant'),
                'nombre' => $items->count(),
                'agents' => $items->pluck('agent.name')->unique()->implode(', ')
            ];
        })->sortByDesc('montant');

        // Collectes par type
        $totalMontant = $collectes->sum('montant');
        $collectesParType = $collectes->groupBy('type_collecte')->map(function($items) use ($totalMontant) {
            return [
                'montant' => $items->sum('montant'),
                'nombre' => $items->count(),
                'pourcentage' => $totalMontant > 0 ? round(($items->sum('montant') / $totalMontant * 100), 2) : 0
            ];
        });

        // Évolution quotidienne
        $collectesParJour = $collectes->groupBy(function($item) {
            return Carbon::parse($item->date_collecte)->format('Y-m-d');
        })->map(function($items) {
            return [
                'montant' => $items->sum('montant'),
                'nombre' => $items->count()
            ];
        })->sortKeys();

        return view('regisseur.rapports.marche', compact(
            'marches', 'marche', 'statistiques', 'collectesParZone',
            'collectesParType', 'collectesParJour', 'dateDebut', 'dateFin'
        ));
    }
    
    /**
     * ==================== IMPRESSION RAPPORT MARCHÉ (PDF) ====================
     */
    public function imprimerRapportMarche(Request $request)
    {
        $request->validate([
            'date_debut' => 'required|date',
            'date_fin' => 'required|date',
        ]);
        
        $marcheId = $request->input('marche_id');
        $marche = null;
        
        if ($marcheId && $marcheId != '') {
            $marche = Marche::find($marcheId);
        }

        $query = Collecte::with(['agent', 'place.hangar.zone.marche'])
            ->whereBetween('date_collecte', [$request->date_debut, $request->date_fin])
            ->orderBy('date_collecte');

        if ($marcheId && $marcheId != '') {
            $query->whereHas('place.hangar.zone.marche', function($q) use ($marcheId) {
                $q->where('id', $marcheId);
            });
        }

        $collectes = $query->get();

        // Statistiques générales
        $statistiques = [
            'total_collectes' => $collectes->count(),
            'total_montant' => $collectes->sum('montant'),
            'moyenne_par_collecte' => $collectes->avg('montant'),
            'nombre_agents' => $collectes->pluck('agent_id')->unique()->count(),
            'nombre_zones' => $collectes->pluck('place.hangar.zone.id')->unique()->count()
        ];

        // Collectes par zone
        $collectesParZone = $collectes->groupBy(function($item) {
            return optional($item->place->hangar->zone)->nom ?? 'Zone inconnue';
        })->map(function($items) {
            return [
                'montant' => $items->sum('montant'),
                'nombre' => $items->count(),
                'agents' => $items->pluck('agent.name')->unique()->implode(', ')
            ];
        })->sortByDesc('montant');

        // Collectes par type
        $totalMontant = $collectes->sum('montant');
        $collectesParType = $collectes->groupBy('type_collecte')->map(function($items) use ($totalMontant) {
            return [
                'montant' => $items->sum('montant'),
                'nombre' => $items->count(),
                'pourcentage' => $totalMontant > 0 ? round(($items->sum('montant') / $totalMontant * 100), 2) : 0
            ];
        });
        
        $data = [
            'marche' => $marche,
            'statistiques' => $statistiques,
            'collectesParZone' => $collectesParZone,
            'collectesParType' => $collectesParType,
            'dateDebut' => $request->date_debut,
            'dateFin' => $request->date_fin,
        ];
        
        // Générer le PDF
        $pdf = PDF::loadView('regisseur.rapports.pdf.marche', $data)
            ->setPaper('A4', 'portrait');
            
        $nomFichier = $marche 
            ? 'rapport_marche_' . str_replace(' ', '_', $marche->nom) . '_' . date('Y-m-d') . '.pdf'
            : 'rapport_tous_marches_' . date('Y-m-d') . '.pdf';
        
        return $pdf->stream($nomFichier);
    }
    
    /**
     * ==================== RAPPORT SYNTHÈSE GLOBAL ====================
     */
    public function rapportSynthese(Request $request)
    {
        $dateDebut = $request->input('date_debut', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $dateFin = $request->input('date_fin', Carbon::now()->format('Y-m-d'));
        
        // Collectes sur la période
        $collectes = Collecte::with(['agent', 'place.hangar.zone.marche'])
            ->whereBetween('date_collecte', [$dateDebut, $dateFin])
            ->get();
        
        // Dépôts sur la période
        $depots = Depot::with(['agent', 'regisseur'])
            ->whereBetween('created_at', [$dateDebut, $dateFin])
            ->get();
        
        // Statistiques globales
        $statistiques = [
            'collectes' => [
                'total' => $collectes->count(),
                'montant' => $collectes->sum('montant'),
                'top_agents' => $collectes->groupBy('agent_id')->map(function($items, $agentId) {
                    $agent = User::find($agentId);
                    return [
                        'nom' => $agent ? $agent->name : 'Inconnu',
                        'montant' => $items->sum('montant'),
                        'nombre' => $items->count()
                    ];
                })->sortByDesc('montant')->take(10)->values()
            ],
            'depots' => [
                'total' => $depots->count(),
                'montant' => $depots->sum('montant'),
            ]
        ];
        
        return view('regisseur.rapports.synthese', compact(
            'statistiques', 'dateDebut', 'dateFin'
        ));
    }
    
    /**
     * ==================== IMPRESSION RAPPORT SYNTHÈSE (PDF) ====================
     */
    public function imprimerRapportSynthese(Request $request)
    {
        $request->validate([
            'date_debut' => 'required|date',
            'date_fin' => 'required|date',
        ]);
        
        $dateDebut = $request->input('date_debut');
        $dateFin = $request->input('date_fin');
        
        // Collectes sur la période
        $collectes = Collecte::with(['agent'])
            ->whereBetween('date_collecte', [$dateDebut, $dateFin])
            ->get();
        
        // Dépôts sur la période
        $depots = Depot::whereBetween('created_at', [$dateDebut, $dateFin])->get();
        
        // Statistiques globales
        $statistiques = [
            'collectes' => [
                'total' => $collectes->count(),
                'montant' => $collectes->sum('montant'),
                'top_agents' => $collectes->groupBy('agent_id')->map(function($items, $agentId) {
                    $agent = User::find($agentId);
                    return [
                        'nom' => $agent ? $agent->name : 'Inconnu',
                        'montant' => $items->sum('montant'),
                        'nombre' => $items->count()
                    ];
                })->sortByDesc('montant')->take(5)->values()
            ],
            'depots' => [
                'total' => $depots->count(),
                'montant' => $depots->sum('montant'),
            ]
        ];
        
        $data = [
            'statistiques' => $statistiques,
            'dateDebut' => $dateDebut,
            'dateFin' => $dateFin,
        ];
        
        // Générer le PDF
        $pdf = PDF::loadView('regisseur.rapports.pdf.synthese', $data)
            ->setPaper('A4', 'portrait');
            
        return $pdf->stream('rapport_synthese_' . date('Y-m-d') . '.pdf');
    }
    
    /**
     * ==================== RAPPORTS PAR ZONE ====================
     * Optionnel : Ajout d'un rapport par zone
     */
    public function rapportZone(Request $request)
    {
        $zones = Zone::with('marche')->orderBy('nom')->get();
        
        $zoneId = $request->input('zone_id');
        $dateDebut = $request->input('date_debut', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $dateFin = $request->input('date_fin', Carbon::now()->format('Y-m-d'));
        
        $zone = null;
        $collectes = collect();
        $statistiques = [];
        
        if ($zoneId) {
            $zone = Zone::with('marche')->find($zoneId);
            
            $collectes = Collecte::with(['agent', 'place.hangar.zone'])
                ->whereHas('place.hangar', function($q) use ($zoneId) {
                    $q->where('zone_id', $zoneId);
                })
                ->whereBetween('date_collecte', [$dateDebut, $dateFin])
                ->orderBy('date_collecte')
                ->get();
            
            $statistiques = [
                'total_collectes' => $collectes->count(),
                'total_montant' => $collectes->sum('montant'),
                'nombre_agents' => $collectes->pluck('agent_id')->unique()->count(),
                'par_type' => $collectes->groupBy('type_collecte')->map(function($items) {
                    return [
                        'montant' => $items->sum('montant'),
                        'nombre' => $items->count()
                    ];
                })
            ];
        }
        
        return view('regisseur.rapports.zone', compact(
            'zones', 'zone', 'collectes', 'statistiques', 'dateDebut', 'dateFin'
        ));
    }
}