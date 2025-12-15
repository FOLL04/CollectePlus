<h1>solo beton SYNTHESE</h1>
@extends('layouts.app')

@section('title', 'Synthèse Globale - admin')

@section('content')
<div class="container-fluid px-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 text-gray-800">
                <i class="fas fa-chart-pie text-primary me-2"></i>Synthèse Globale
            </h1>
            <p class="text-muted">Vue d'ensemble complète des activités du système</p>
        </div>
        <div class="dropdown">
            <button class="btn btn-outline-primary dropdown-toggle" type="button" 
                    id="periodeDropdown" data-bs-toggle="dropdown">
                <i class="fas fa-calendar me-2"></i>
                Période: {{ \Carbon\Carbon::parse($dateDebut)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($dateFin)->format('d/m/Y') }}
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="?date_debut={{ now()->startOfMonth()->format('Y-m-d') }}&date_fin={{ now()->format('Y-m-d') }}">Ce mois</a></li>
                <li><a class="dropdown-item" href="?date_debut={{ now()->subMonth()->startOfMonth()->format('Y-m-d') }}&date_fin={{ now()->subMonth()->endOfMonth()->format('Y-m-d') }}">Mois dernier</a></li>
                <li><a class="dropdown-item" href="?date_debut={{ now()->startOfYear()->format('Y-m-d') }}&date_fin={{ now()->format('Y-m-d') }}">Cette année</a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form method="GET" class="px-3 py-2">
                        <div class="mb-2">
                            <label class="form-label small">Date début</label>
                            <input type="date" name="date_debut" class="form-control form-control-sm">
                        </div>
                        <div class="mb-2">
                            <label class="form-label small">Date fin</label>
                            <input type="date" name="date_fin" class="form-control form-control-sm">
                        </div>
                        <button type="submit" class="btn btn-sm btn-primary w-100">Appliquer</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>

    <!-- Statistiques principales -->
    <div class="row mb-4">
        <!-- Collectes -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Collectes Total
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($statistiques['collectes']['montant'], 0, ',', ' ') }} FCFA
                            </div>
                            <div class="mt-2">
                                <span class="badge bg-primary">{{ $statistiques['collectes']['total'] }} transactions</span>
                                <small class="text-muted ms-2">
                                    {{ number_format($statistiques['collectes']['montant'] / max($statistiques['collectes']['total'], 1), 0, ',', ' ') }} FCFA moy.
                                </small>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-money-bill-wave fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Dépôts -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Dépôts Total
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($statistiques['depots']['montant'], 0, ',', ' ') }} FCFA
                            </div>
                            <div class="mt-2">
                                <span class="badge bg-success">{{ $statistiques['depots']['total'] }} dépôts</span>
                                <small class="text-muted ms-2">
                                    {{ number_format($statistiques['depots']['montant'] / max($statistiques['depots']['total'], 1), 0, ',', ' ') }} FCFA moy.
                                </small>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-hand-holding-usd fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Évolution -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Évolution
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($evolution, 1) }}%
                            </div>
                            <div class="mt-2">
                                <span class="badge bg-info">vs période précédente</span>
                                <small class="text-muted ms-2">
                                    {{ number_format($collectesActuelles, 0, ',', ' ') }} vs 
                                    {{ number_format($collectesPrecedentes, 0, ',', ' ') }} FCFA
                                </small>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chart-line fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Performance par marché -->
    <div class="card shadow mb-4">
        <div class="card-header bg-white py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-store me-2"></i>Performance par marché
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>Marché</th>
                            <th>Collectes</th>
                            <th>Montant</th>
                            <th>Moyenne</th>
                            <th>% du total</th>
                            <th>Performance</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($statistiques['marchés'] as $marche)
                        @php
                            $pourcentage = $statistiques['collectes']['montant'] > 0 ? 
                                ($marche->collectes_sum_montant / $statistiques['collectes']['montant']) * 100 : 0;
                        @endphp
                        <tr>
                            <td>
                                <strong>{{ $marche->nom }}</strong>
                            </td>
                            <td>
                                <span class="badge bg-primary">{{ $marche->collectes_count }}</span>
                            </td>
                            <td>
                                <strong>{{ number_format($marche->collectes_sum_montant, 0, ',', ' ') }} FCFA</strong>
                            </td>
                            <td>
                                {{ number_format($marche->collectes_sum_montant / max($marche->collectes_count, 1), 0, ',', ' ') }} FCFA
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="progress flex-grow-1 mr-2" style="height: 8px;">
                                        <div class="progress-bar 
                                            @if($pourcentage > 30) bg-success
                                            @elseif($pourcentage > 15) bg-info
                                            @elseif($pourcentage > 5) bg-warning
                                            @else bg-secondary
                                            @endif"
                                            style="width: {{ $pourcentage }}%">
                                        </div>
                                    </div>
                                    <span>{{ round($pourcentage, 1) }}%</span>
                                </div>
                            </td>
                            <td>
                                @if($pourcentage > 20)
                                <span class="badge bg-success">Excellent</span>
                                @elseif($pourcentage > 10)
                                <span class="badge bg-info">Bon</span>
                                @elseif($pourcentage > 5)
                                <span class="badge bg-warning">Moyen</span>
                                @else
                                <span class="badge bg-secondary">Faible</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Top agents -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card shadow h-100">
                <div class="card-header bg-white py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-crown me-2"></i>Top 5 Agents
                    </h6>
                </div>
                <div class="card-body">
                    @if(count($statistiques['collectes']['top_agents']) > 0)
                    <div class="list-group list-group-flush">
                        @foreach($statistiques['collectes']['top_agents'] as $agentData)
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-0">{{ $agentData['nom'] }}</h6>
                                <small class="text-muted">{{ $agentData['nombre'] }} collectes</small>
                            </div>
                            <div class="text-end">
                                <span class="font-weight-bold text-success">
                                    {{ number_format($agentData['montant'], 0, ',', ' ') }} FCFA
                                </span>
                                <br>
                                <small class="text-muted">
                                    {{ number_format($agentData['montant'] / max($agentData['nombre'], 1), 0, ',', ' ') }} FCFA moy.
                                </small>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-4 text-muted">
                        <i class="fas fa-users fa-2x mb-3"></i>
                        <p>Aucun agent avec des collectes</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Dépôts par régisseur -->
        <div class="col-md-6">
            <div class="card shadow h-100">
                <div class="card-header bg-white py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-user-tie me-2"></i>Dépôts par régisseur
                    </h6>
                </div>
                <div class="card-body">
                    @if(count($statistiques['depots']['par_regisseur']) > 0)
                    <div class="list-group list-group-flush">
                        @foreach($statistiques['depots']['par_regisseur'] as $regisseurData)
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-0">{{ $regisseurData['nom'] }}</h6>
                                <small class="text-muted">{{ $regisseurData['nombre'] }} dépôts</small>
                            </div>
                            <div class="text-end">
                                <span class="font-weight-bold text-primary">
                                    {{ number_format($regisseurData['montant'], 0, ',', ' ') }} FCFA
                                </span>
                                <br>
                                <small class="text-muted">
                                    {{ number_format($regisseurData['montant'] / max($regisseurData['nombre'], 1), 0, ',', ' ') }} FCFA moy.
                                </small>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-4 text-muted">
                        <i class="fas fa-hand-holding-usd fa-2x mb-3"></i>
                        <p>Aucun dépôt enregistré</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Répartition par type -->
    <div class="card shadow mb-4">
        <div class="card-header bg-white py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-chart-pie me-2"></i>Répartition des collectes par type
            </h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead class="table-light">
                                <tr>
                                    <th>Type</th>
                                    <th>Montant</th>
                                    <th>Nombre</th>
                                    <th>% du total</th>
                                    <th>Moyenne</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($statistiques['collectes']['par_type'] as $type => $data)
                                @php
                                    $pourcentage = $statistiques['collectes']['montant'] > 0 ? 
                                        ($data['montant'] / $statistiques['collectes']['montant']) * 100 : 0;
                                @endphp
                                <tr>
                                    <td>
                                        <span class="badge bg-{{ getTypeColor($type) }}">{{ $type }}</span>
                                    </td>
                                    <td>{{ number_format($data['montant'], 0, ',', ' ') }} FCFA</td>
                                    <td>{{ $data['nombre'] }}</td>
                                    <td>
                                        <div class="progress" style="height: 6px;">
                                            <div class="progress-bar bg-{{ getTypeColor($type) }}" 
                                                 style="width: {{ $pourcentage }}%">
                                            </div>
                                        </div>
                                        <small>{{ round($pourcentage, 1) }}%</small>
                                    </td>
                                    <td>{{ number_format($data['montant'] / max($data['nombre'], 1), 0, ',', ' ') }} FCFA</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-4">
                    <!-- Graphique circulaire simple -->
                    <div class="text-center">
                        <div class="mb-3">
                            <h5 class="text-primary">Répartition</h5>
                            <small class="text-muted">Montant total par type</small>
                        </div>
                        
                        <!-- Graphique SVG simple -->
                        <svg width="200" height="200" viewBox="0 0 42 42" class="donut">
                            @php
                                $total = $statistiques['collectes']['montant'];
                                $startAngle = 0;
                                $colors = ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b', '#858796'];
                                $i = 0;
                            @endphp
                            
                            @foreach($statistiques['collectes']['par_type'] as $type => $data)
                            @php
                                $percentage = $total > 0 ? ($data['montant'] / $total) * 100 : 0;
                                $angle = ($percentage / 100) * 360;
                                $endAngle = $startAngle + $angle;
                            @endphp
                            
                            <circle class="donut-segment" cx="21" cy="21" r="15.91549430918954" 
                                    fill="transparent" stroke="{{ $colors[$i % count($colors)] }}" 
                                    stroke-width="3" stroke-dasharray="{{ $percentage }} {{ 100 - $percentage }}" 
                                    stroke-dashoffset="{{ 25 + $startAngle }}">
                            </circle>
                            
                            @php
                                $startAngle += $angle;
                                $i++;
                            @endphp
                            @endforeach
                            
                            <circle class="donut-hole" cx="21" cy="21" r="12.5" fill="white"></circle>
                        </svg>
                        
                        <!-- Légende -->
                        <div class="mt-3">
                            @foreach($statistiques['collectes']['par_type'] as $type => $data)
                            <div class="d-flex align-items-center mb-1">
                                <div class="legend-color" style="background-color: {{ $colors[$loop->index % count($colors)] }}; width: 12px; height: 12px; border-radius: 2px; margin-right: 8px;"></div>
                                <small>{{ $type }} ({{ round(($data['montant'] / $total) * 100, 1) }}%)</small>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Résumé et actions -->
    <div class="card shadow mb-4">
        <div class="card-header bg-white py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-clipboard-list me-2"></i>Résumé de la période
            </h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h6 class="font-weight-bold">Points clés</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <strong>Collectes:</strong> {{ $statistiques['collectes']['total'] }} transactions
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <strong>Dépôts:</strong> {{ $statistiques['depots']['total'] }} enregistrements
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <strong>Marchés actifs:</strong> {{ count($statistiques['marchés']) }}
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check-circle {{ $evolution >= 0 ? 'text-success' : 'text-danger' }} me-2"></i>
                            <strong>Évolution:</strong> {{ number_format($evolution, 1) }}%
                        </li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <h6 class="font-weight-bold">Actions</h6>
                    <div class="d-grid gap-2">
                        <a href="javascript:window.print()" class="btn btn-outline-primary">
                            <i class="fas fa-print me-2"></i>Imprimer le rapport
                        </a>
                        <button onclick="genererRapportComplet()" class="btn btn-outline-success">
                            <i class="fas fa-file-pdf me-2"></i>Générer PDF complet
                        </button>
                        <button onclick="envoyerParEmail()" class="btn btn-outline-info">
                            <i class="fas fa-envelope me-2"></i>Envoyer par email
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer bg-white">
            <small class="text-muted">
                <i class="fas fa-info-circle me-1"></i>
                Rapport généré le {{ now()->format('d/m/Y à H:i') }}. 
                Période: {{ \Carbon\Carbon::parse($dateDebut)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($dateFin)->format('d/m/Y') }}
            </small>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .progress {
        border-radius: 4px;
        overflow: hidden;
    }
    .table-hover tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.05);
    }
    .donut {
        margin: 0 auto;
        display: block;
    }
    .donut-segment {
        transform: rotate(-90deg);
        transform-origin: 50% 50%;
    }
    .legend-color {
        min-width: 12px;
    }
    .list-group-item {
        border-left: none;
        border-right: none;
    }
    .list-group-item:first-child {
        border-top: none;
    }
    .list-group-item:last-child {
        border-bottom: none;
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        // Tooltips Bootstrap
        $('[data-bs-toggle="tooltip"]').tooltip();
    });

    function genererRapportComplet() {
        // Générer un rapport PDF complet
        const url = window.location.href;
        const params = new URLSearchParams(window.location.search);
        
        alert('Génération du rapport PDF complet...\nCette fonctionnalité sera implémentée.');
        
        // Ici vous pouvez faire une requête AJAX pour générer le PDF
        // $.post('/regisseur/rapports/generer-pdf', params.toString(), function(response) {
        //     window.open(response.pdf_url, '_blank');
        // });
    }

    function envoyerParEmail() {
        const email = prompt('Entrez l\'adresse email pour envoyer le rapport:');
        if (email && validateEmail(email)) {
            alert(`Rapport envoyé à ${email}\n(Cette fonctionnalité sera implémentée)`);
            
            // Ici vous pouvez faire une requête AJAX
            // $.post('/regisseur/rapports/envoyer-email', {
            //     email: email,
            //     date_debut: '{{ $dateDebut }}',
            //     date_fin: '{{ $dateFin }}'
            // });
        } else if (email) {
            alert('Adresse email invalide.');
        }
    }

    function validateEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }
</script>
@endpush

<?php
// Helper function pour les couleurs (identique à celui dans statistiques-types)
if (!function_exists('getTypeColor')) {
    function getTypeColor($type) {
        $colors = [
            '100F' => 'primary',
            'loyer' => 'success',
            'taxe' => 'warning',
            'amende' => 'danger',
            'abonnement' => 'info'
        ];
        return $colors[$type] ?? 'secondary';
    }
}
?>