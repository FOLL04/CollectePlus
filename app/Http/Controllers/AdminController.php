<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Marche;
use App\Models\Collecte;
use App\Models\User;
use App\Models\Depot;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index()
    { 
        try {
            // Statistiques principales
            $stats = [
                'total_marches' => Marche::count(),
                'total_collectes' => Collecte::whereDate('created_at', today())->count(),
                'total_users' => User::count(),
                'total_depots' => Depot::count(),
                'collectes_semaine' => Collecte::where('created_at', '>=', now()->subDays(7))->count(),
            ];

            // Statistiques pour le graphique (7 derniers jours)
            $collectesStats = Collecte::selectRaw('DATE(created_at) as date, COUNT(*) as total')
                ->where('created_at', '>=', now()->subDays(7))
                ->groupBy('date')
                ->orderBy('date', 'asc')
                ->get()
                ->map(function($item) {
                    return [
                        'date' => $item->date,
                        'date_formatted' => Carbon::parse($item->date)->format('d/m'),
                        'total' => $item->total
                    ];
                });

            $formattedStats = $collectesStats;

            // Dernières collectes avec relations correctes
            $recentCollectes = Collecte::with([ 'agent'])
                ->latest()
                ->take(5)
                ->get();

            // Marchés actifs avec statistiques
            $marches = Marche::withCount(['collectes'])
                ->latest()
                ->take(6)
                ->get();

            // Derniers utilisateurs
            $recentUsers = User::with('role')
                ->latest()
                ->take(5)
                ->get();

            return view('admin.dashboard', compact(
                'stats',
                'formattedStats',
                'recentCollectes',
                'marches',
                'recentUsers'
            ));

        } catch (\Exception $e) {
            \Log::error('Erreur dans AdminController: ' . $e->getMessage());

            return view('admin.dashboard', [
                'stats' => [
                    'total_marches' => 0,
                    'total_collectes' => 0,
                    'total_users' => 0,
                    'total_depots' => 0,
                    'collectes_semaine' => 0,
                ],
                'formattedStats' => collect([]),
                'recentCollectes' => collect([]),
                'marches' => collect([]),
                'recentUsers' => collect([]),
            ]);
        }
    }

    public function dashboard()
    {
        return $this->index();
    }
}
