@extends('layouts.app')

@section('content')
    <title>Gestion des Marchés</title>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen">
        <!-- Header -->
        <header class="gradient-bg text-white shadow-lg" style="margin-bottom: 5%">
            <div class="container mx-auto px-4 py-6">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div class="mb-4 md:mb-0">
                        <h1 class="text-3xl font-bold">
                            <i class="fas fa-store mr-3"></i>Gestion des Marchés
                        </h1>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <div class="text-center bg-white bg-opacity-20 p-3 rounded-lg">
                            <p class="text-sm opacity-90">Marchés ce mois</p>
                            <p class="text-2xl font-bold">{{ $recentMarchesCount }}</p>
                        </div>
                         <button class="btn" style="box-shadow: #e5e7eb hover:bg-gray-200 transition duration-200">
                        <a href="{{ route('marches.create') }}" class="action-btn info">
                            <i class="fas fa-store-alt"></i>
                            <span>Nouveau marché</span>
                        </a>
                         </button>
                    </div>
                </div>
            </div>
        </header>

        <!-- Statistiques -->
        <div class="container mx-auto px-4 py-6 -mt-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="stat-card bg-white rounded-xl shadow-lg p-6 fade-in">
                    <div class="flex items-center">
                        <div class="bg-blue-100 p-4 rounded-lg mr-4">
                            <i class="fas fa-map-marked-alt text-blue-600 text-2xl"></i>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm">Total Marchés</p>
                            <p class="text-3xl font-bold text-gray-800">{{ $marches->total() }}</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="flex justify-between text-sm text-gray-600">
                            <span>Actifs</span>
                            <span>{{ $marches->total() }}</span>
                        </div>
                        <div class="progress-bar mt-1">
                            <div class="progress-fill" style="width: 100%"></div>
                        </div>
                    </div>
                </div>
                
                <div class="stat-card bg-white rounded-xl shadow-lg p-6 fade-in delay-1">
                    <div class="flex items-center">
                        <div class="bg-green-100 p-4 rounded-lg mr-4">
                            <i class="fas fa-layer-group text-green-600 text-2xl"></i>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm">Zones moyennes par marché</p>
                            <p class="text-3xl font-bold text-gray-800">
                                @php
                                    $avgZones = $marches->count() > 0 ? round($marches->sum('zones_count') / $marches->count(), 1) : 0;
                                    echo $avgZones;
                                @endphp
                            </p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="flex justify-between text-sm text-gray-600">
                            <span>Distribution</span>
                            <span>{{ $marches->sum('zones_count') }} total</span>
                        </div>
                        <div class="progress-bar mt-1">
                            <div class="progress-fill" style="width: {{ min(100, ($avgZones / 10) * 100) }}%"></div>
                        </div>
                    </div>
                </div>
                
                <div class="stat-card bg-white rounded-xl shadow-lg p-6 fade-in delay-2">
                    <div class="flex items-center">
                        <div class="bg-purple-100 p-4 rounded-lg mr-4">
                            <i class="fas fa-parking text-purple-600 text-2xl"></i>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm">Places moyennes par marché</p>
                            <p class="text-3xl font-bold text-gray-800">
                                @php
                                    $avgPlaces = $marches->count() > 0 ? round($marches->sum('places_count') / $marches->count(), 0) : 0;
                                    echo $avgPlaces;
                                @endphp
                            </p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="flex justify-between text-sm text-gray-600">
                            <span>Occupation</span>
                            <span>{{ $marches->sum('places_count') }} total</span>
                        </div>
                        <div class="progress-bar mt-1">
                            <div class="progress-fill" style="width: {{ min(100, ($avgPlaces / 500) * 100) }}%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Liste des marchés -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden fade-in delay-3">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex flex-col md:flex-row justify-between items-center">
                        <h2 class="text-xl font-bold text-gray-800">
                            <i class="fas fa-list mr-2"></i>Liste des Marchés
                        </h2>
                        
                        <div class="mt-3 md:mt-0">
                            <div class="relative">
                                <input type="text" placeholder="Rechercher un marché..." class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="responsive-table">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Nom du Marché
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Zones
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Hangars
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Places
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Date de création
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($marches as $marche)
                            <tr class="hover:bg-gray-50 transition duration-150">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="bg-indigo-100 p-3 rounded-lg mr-4">
                                            <i class="fas fa-store text-indigo-600"></i>
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-900">{{ $marche->nom ?? 'Marché #' . $marche->id }}</div>
                                            <div class="text-sm text-gray-500">ID: {{ $marche->id }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <span class="inline-flex items-center justify-center bg-blue-100 text-blue-800 text-sm font-semibold px-3 py-1 rounded-full">
                                            <i class="fas fa-layer-group mr-1"></i> {{ $marche->zones_count }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <span class="inline-flex items-center justify-center bg-green-100 text-green-800 text-sm font-semibold px-3 py-1 rounded-full">
                                            <i class="fas fa-warehouse mr-1"></i> {{ $marche->hangars_count }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <span class="inline-flex items-center justify-center bg-purple-100 text-purple-800 text-sm font-semibold px-3 py-1 rounded-full">
                                            <i class="fas fa-parking mr-1"></i> {{ $marche->places_count }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <div class="flex items-center">
                                        <i class="far fa-calendar-alt mr-2 text-gray-400"></i>
                                        {{ $marche->created_at->format('d/m/Y') }}
                                    </div>
                                    <div class="text-xs text-gray-400 mt-1">
                                        {{ $marche->created_at->diffForHumans() }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <button class="text-indigo-600 hover:text-indigo-900 p-2 rounded-lg hover:bg-indigo-50 transition duration-200" title="Voir détails">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="text-green-600 hover:text-green-900 p-2 rounded-lg hover:bg-green-50 transition duration-200" title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="text-red-600 hover:text-red-900 p-2 rounded-lg hover:bg-red-50 transition duration-200" title="Supprimer">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="text-gray-400">
                                        <i class="fas fa-inbox text-4xl mb-4"></i>
                                        <p class="text-xl">Aucun marché trouvé</p>
                                        <p class="mt-2">Commencez par ajouter un nouveau marché</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                @if($marches->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    <div class="flex flex-col md:flex-row justify-between items-center">
                        <div class="mb-4 md:mb-0 text-sm text-gray-700">
                            Affichage de <span class="font-semibold">{{ $marches->firstItem() }}</span> à <span class="font-semibold">{{ $marches->lastItem() }}</span> sur <span class="font-semibold">{{ $marches->total() }}</span> marchés
                        </div>
                        
                        <div class="pagination">
                            @if($marches->onFirstPage())
                            <span class="px-3 py-1 bg-gray-100 text-gray-400 rounded-lg cursor-not-allowed">
                                <i class="fas fa-chevron-left mr-1"></i> Précédent
                            </span>
                            @else
                            <a href="{{ $marches->previousPageUrl() }}" class="px-3 py-1 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition duration-200">
                                <i class="fas fa-chevron-left mr-1"></i> Précédent
                            </a>
                            @endif
                            
                            <span class="mx-2 text-gray-500">|</span>
                            
                            @if($marches->hasMorePages())
                            <a href="{{ $marches->nextPageUrl() }}" class="px-3 py-1 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition duration-200">
                                Suivant <i class="fas fa-chevron-right ml-1"></i>
                            </a>
                            @else
                            <span class="px-3 py-1 bg-gray-100 text-gray-400 rounded-lg cursor-not-allowed">
                                Suivant <i class="fas fa-chevron-right ml-1"></i>
                            </span>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Pages numérotées -->
                    <div class="flex justify-center mt-4">
                        @foreach($marches->getUrlRange(1, $marches->lastPage()) as $page => $url)
                            @if($page == $marches->currentPage())
                            <span class="mx-1 px-3 py-1 bg-indigo-600 text-white rounded-lg font-semibold">{{ $page }}</span>
                            @else
                            <a href="{{ $url }}" class="mx-1 px-3 py-1 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition duration-200">{{ $page }}</a>
                            @endif
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- Espacement entre le titre et les cartes -->
            <div class="mt-8 mb-6">
                <h2 class="text-2xl font-bold text-gray-800 text-center">
                    <i class="fas fa-chart-bar mr-3"></i>Statistiques Détaillées
                </h2>
                <p class="text-gray-600 text-center mt-2">Analyse complète des capacités de vos marchés</p>
            </div>
            
            <!-- Informations complémentaires -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">
                        <i class="fas fa-chart-line mr-2 text-green-500"></i>Résumé des capacités
                    </h3>
                    <div class="space-y-4">
                        <div>
                            <div class="flex justify-between text-sm text-gray-600 mb-1">
                                <span>Zones totales</span>
                                <span class="font-semibold">{{ $marches->sum('zones_count') }}</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: {{ $marches->count() > 0 ? min(100, ($marches->sum('zones_count') / ($marches->count() * 10)) * 100) : 0 }}%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between text-sm text-gray-600 mb-1">
                                <span>Hangars totaux</span>
                                <span class="font-semibold">{{ $marches->sum('hangars_count') }}</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: {{ $marches->count() > 0 ? min(100, ($marches->sum('hangars_count') / ($marches->count() * 20)) * 100) : 0 }}%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between text-sm text-gray-600 mb-1">
                                <span>Places totales</span>
                                <span class="font-semibold">{{ $marches->sum('places_count') }}</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: {{ $marches->count() > 0 ? min(100, ($marches->sum('places_count') / ($marches->count() * 500)) * 100) : 0 }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">
                        <i class="fas fa-info-circle mr-2 text-blue-500"></i>Informations clés
                    </h3>
                    <div class="space-y-4">
                        <div class="flex items-center p-3 bg-blue-50 rounded-lg">
                            <i class="fas fa-calendar-check text-blue-500 mr-3"></i>
                            <div>
                                <p class="font-medium text-gray-800">Marchés récents</p>
                                <p class="text-sm text-gray-600">{{ $recentMarchesCount }} créés ce mois</p>
                            </div>
                        </div>
                        <div class="flex items-center p-3 bg-green-50 rounded-lg">
                            <i class="fas fa-warehouse text-green-500 mr-3"></i>
                            <div>
                                <p class="font-medium text-gray-800">Capacité moyenne</p>
                                <p class="text-sm text-gray-600">{{ $marches->count() > 0 ? round($marches->sum('hangars_count') / $marches->count(), 1) : 0 }} hangars par marché</p>
                            </div>
                        </div>
                        <div class="flex items-center p-3 bg-purple-50 rounded-lg">
                            <i class="fas fa-chart-pie text-purple-500 mr-3"></i>
                            <div>
                                <p class="font-medium text-gray-800">Rendement d'espace</p>
                                <p class="text-sm text-gray-600">{{ $marches->count() > 0 ? round($marches->sum('places_count') / $marches->count(), 0) : 0 }} places en moyenne</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Styles CSS -->
    <style>
        /* CSS personnalisé */
        .gradient-bg {
            background: linear-gradient(180deg, #0f766e 0%, #047857 100%);
        }
        
        .card-hover {
            transition: all 0.3s ease;
            border: 1px solid #e5e7eb;
        }
        
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            border-color: #667eea;
        }
        
        .stat-card {
            transition: transform 0.3s ease;
        }
        
        .stat-card:hover {
            transform: scale(1.03);
        }
        
        .pagination .page-link {
            padding: 8px 16px;
            margin: 0 4px;
            border-radius: 6px;
            transition: all 0.3s;
        }
        
        .pagination .page-link:hover {
            background-color: #667eea;
            color: white;
        }
        
        .progress-bar {
            height: 8px;
            border-radius: 4px;
            overflow: hidden;
            background-color: #e5e7eb;
        }
        
        .progress-fill {
            height: 100%;
            border-radius: 4px;
            background: linear-gradient(90deg, #10b981 0%, #34d399 100%);
        }
        
        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .fade-in {
            animation: fadeIn 0.5s ease forwards;
        }
        
        .delay-1 { animation-delay: 0.1s; opacity: 0; }
        .delay-2 { animation-delay: 0.2s; opacity: 0; }
        .delay-3 { animation-delay: 0.3s; opacity: 0; }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .responsive-table {
                display: block;
                overflow-x: auto;
            }
        }
        
        /* Espacements améliorés */
        .spacing-section {
            margin-top: 3rem;
            margin-bottom: 2rem;
        }
        
        .section-title {
            position: relative;
            padding-bottom: 1rem;
        }
        
        .section-title:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 3px;
            background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
            border-radius: 2px;
        }
        
        /* Effets de survol pour les lignes du tableau */
        tbody tr {
            transition: all 0.2s ease;
        }
        
        tbody tr:hover {
            background-color: #f7fafc;
            transform: translateX(5px);
        }
        
        /* Boutons avec effet de profondeur */
        .btn-depth {
            box-shadow: 0 4px 6px rgba(50, 50, 93, 0.11), 0 1px 3px rgba(0, 0, 0, 0.08);
            transition: all 0.15s ease;
        }
        
        .btn-depth:hover {
            transform: translateY(-2px);
            box-shadow: 0 7px 14px rgba(50, 50, 93, 0.1), 0 3px 6px rgba(0, 0, 0, 0.08);
        }
        
        /* Badges avec effet de lueur */
        .badge-glow {
            box-shadow: 0 0 0 1px rgba(59, 130, 246, 0.5);
        }
        
        .badge-glow:hover {
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.8);
        }
    </style>

    <!-- Scripts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    
    <script>
        // Animation au chargement
        document.addEventListener('DOMContentLoaded', function() {
            // Animation des éléments
            const fadeElements = document.querySelectorAll('.fade-in');
            fadeElements.forEach(el => {
                el.style.opacity = 1;
            });
            
            // Gestion des interactions
            const rows = document.querySelectorAll('tbody tr');
            rows.forEach(row => {
                row.addEventListener('click', function(e) {
                    if (!e.target.closest('button')) {
                        this.classList.toggle('bg-indigo-50');
                    }
                });
            });
            
            // Recherche (exemple simple)
            const searchInput = document.querySelector('input[type="text"]');
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                const rows = document.querySelectorAll('tbody tr');
                
                rows.forEach(row => {
                    const text = row.textContent.toLowerCase();
                    if (text.includes(searchTerm)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        });
    </script>
</body>
</html>
@endsection