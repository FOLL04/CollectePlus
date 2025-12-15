@extends('regisseur.layouts.app')

@section('title', 'Rapport Synthèse Globale')

@section('content')
<div class="container-fluid px-4">
    <!-- Header avec filtre -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 text-gray-800">
                <i class="fas fa-chart-pie text-primary me-2"></i>Rapport Synthèse Globale
            </h1>
            <p class="text-muted">Vue d'ensemble complète de toutes les activités du système</p>
        </div>
    </div>

    <!-- Carte de filtrage -->
    <div class="card shadow mb-4">
        <div class="card-header bg-white py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-filter me-2"></i>Filtres de recherche
            </h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('regisseur.rapports.synthese') }}" class="row g-3">
                <div class="col-md-5">
                    <label class="form-label fw-bold">Type de rapport</label>
                    <select class="form-control" disabled>
                        <option>Syntèse Globale (toutes les données)</option>
                    </select>
                    <small class="text-muted">Ce rapport inclut toutes les activités du système</small>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Date début</label>
                    <input type="date" name="date_debut" class="form-control" 
                           value="{{ $dateDebut ?? date('Y-m-01') }}" max="{{ date('Y-m-d') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Date fin</label>
                    <input type="date" name="date_fin" class="form-control" 
                           value="{{ $dateFin ?? date('Y-m-d') }}" max="{{ date('Y-m-d') }}">
                </div>
                <div class="col-md-1 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Section Résumé -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Collecté
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($statistiques['collectes']['montant'], 0, ',', ' ') }} FCFA
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-money-bill-wave fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Dépôt
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($statistiques['depots']['montant'], 0, ',', ' ') }} FCFA
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-piggy-bank fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Solde Net
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                @php
                                    $solde = $statistiques['collectes']['montant'] - $statistiques['depots']['montant'];
                                @endphp
                                {{ number_format($solde, 0, ',', ' ') }} FCFA
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-balance-scale fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Agents Actifs
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ count($statistiques['collectes']['top_agents']) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Informations synthèse -->
    <div class="card shadow mb-4">
        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-info-circle me-2"></i>
                    Vue Synthèse Globale
                </h6>
                <span class="badge bg-info">
                    Période: {{ \Carbon\Carbon::parse($dateDebut)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($dateFin)->format('d/m/Y') }}
                </span>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <p><strong>Portée:</strong><br>Toutes les activités du système</p>
                </div>
                <div class="col-md-3">
                    <p><strong>Collectes totales:</strong><br>{{ $statistiques['collectes']['total'] }} opérations</p>
                </div>
                <div class="col-md-3">
                    <p><strong>Dépôts totaux:</strong><br>{{ $statistiques['depots']['total'] }} opérations</p>
                </div>
                <div class="col-md-3">
                    <p><strong>Taux de dépôt:</strong><br>
                        @php
                            $tauxDepot = $statistiques['collectes']['montant'] > 0 
                                ? ($statistiques['depots']['montant'] / $statistiques['collectes']['montant']) * 100 
                                : 0;
                        @endphp
                        {{ number_format($tauxDepot, 1, ',', ' ') }}%
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Top 10 des agents -->
    <div class="card shadow mb-4">
        <div class="card-header bg-white py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-crown me-2"></i>Top 10 des agents par performance
            </h6>
        </div>
        <div class="card-body">
            @if(count($statistiques['collectes']['top_agents']) > 0)
            <div class="table-responsive">
                <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th style="width: 50px;">Rang</th>
                            <th>Nom de l'agent</th>
                            <th class="text-center">Collectes</th>
                            <th class="text-right">Montant total</th>
                            <th class="text-right">Moyenne</th>
                            <th class="text-center">% du total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($statistiques['collectes']['top_agents'] as $index => $agent)
                        @php
                            $pourcentage = $statistiques['collectes']['montant'] > 0 
                                ? ($agent['montant'] / $statistiques['collectes']['montant']) * 100 
                                : 0;
                            $moyenneAgent = $agent['nombre'] > 0 ? $agent['montant'] / $agent['nombre'] : 0;
                        @endphp
                        <tr @if($index < 3) style="background-color: rgba(255, 215, 0, 0.1);" @endif>
                            <td class="text-center">
                                @if($index == 0)
                                <span class="badge bg-warning text-dark">🥇 {{ $index + 1 }}</span>
                                @elseif($index == 1)
                                <span class="badge bg-secondary">🥈 {{ $index + 1 }}</span>
                                @elseif($index == 2)
                                <span class="badge bg-danger">🥉 {{ $index + 1 }}</span>
                                @else
                                <span class="badge bg-light text-dark">{{ $index + 1 }}</span>
                                @endif
                            </td>
                            <td><strong>{{ $agent['nom'] }}</strong></td>
                            <td class="text-center">
                                <span class="badge bg-primary">{{ $agent['nombre'] }}</span>
                            </td>
                            <td class="text-right">
                                <strong>{{ number_format($agent['montant'], 0, ',', ' ') }} FCFA</strong>
                            </td>
                            <td class="text-right">
                                {{ number_format($moyenneAgent, 0, ',', ' ') }} FCFA
                            </td>
                            <td class="text-center">
                                {{ number_format($pourcentage, 1, ',', ' ') }}%
                                <div class="progress mt-2" style="height: 8px;">
                                    <div class="progress-bar 
                                        @if($pourcentage > 15) bg-success
                                        @elseif($pourcentage > 8) bg-info
                                        @elseif($pourcentage > 3) bg-warning
                                        @else bg-secondary
                                        @endif"
                                        role="progressbar" 
                                        style="width: {{ min($pourcentage, 100) }}%"
                                        aria-valuenow="{{ $pourcentage }}" 
                                        aria-valuemin="0" 
                                        aria-valuemax="100">
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-dark">
                        <tr>
                            <th colspan="2">TOTAL</th>
                            <th class="text-center">{{ $statistiques['collectes']['total'] }}</th>
                            <th class="text-right">{{ number_format($statistiques['collectes']['montant'], 0, ',', ' ') }} FCFA</th>
                            <th class="text-right">
                                @php
                                    $moyenneGlobale = $statistiques['collectes']['total'] > 0 
                                        ? $statistiques['collectes']['montant'] / $statistiques['collectes']['total']
                                        : 0;
                                @endphp
                                {{ number_format($moyenneGlobale, 0, ',', ' ') }} FCFA
                            </th>
                            <th class="text-center">100%</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            @else
            <div class="text-center py-4">
                <i class="fas fa-users fa-3x text-muted mb-3"></i>
                <p class="text-muted">Aucune donnée d'agent disponible pour cette période</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Détails des opérations -->
    <div class="card shadow mb-4">
        <div class="card-header bg-white py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-chart-bar me-2"></i>Détails des opérations
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>Type d'opération</th>
                            <th class="text-center">Nombre</th>
                            <th class="text-right">Montant total</th>
                            <th class="text-right">Moyenne</th>
                            <th class="text-center">Taux de réalisation</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Ligne Collectes -->
                        <tr>
                            <td><strong>Collectes</strong></td>
                            <td class="text-center">{{ $statistiques['collectes']['total'] }}</td>
                            <td class="text-right">{{ number_format($statistiques['collectes']['montant'], 0, ',', ' ') }} FCFA</td>
                            <td class="text-right">
                                @php
                                    $moyenneCollecte = $statistiques['collectes']['total'] > 0 
                                        ? $statistiques['collectes']['montant'] / $statistiques['collectes']['total']
                                        : 0;
                                @endphp
                                {{ number_format($moyenneCollecte, 0, ',', ' ') }} FCFA
                            </td>
                            <td class="text-center">100%</td>
                        </tr>
                        
                        <!-- Ligne Dépôts -->
                        <tr>
                            <td><strong>Dépôts</strong></td>
                            <td class="text-center">{{ $statistiques['depots']['total'] }}</td>
                            <td class="text-right">{{ number_format($statistiques['depots']['montant'], 0, ',', ' ') }} FCFA</td>
                            <td class="text-right">
                                @php
                                    $moyenneDepot = $statistiques['depots']['total'] > 0 
                                        ? $statistiques['depots']['montant'] / $statistiques['depots']['total']
                                        : 0;
                                @endphp
                                {{ number_format($moyenneDepot, 0, ',', ' ') }} FCFA
                            </td>
                            <td class="text-center">
                                @php
                                    $tauxDepot = $statistiques['collectes']['montant'] > 0 
                                        ? ($statistiques['depots']['montant'] / $statistiques['collectes']['montant']) * 100 
                                        : 0;
                                @endphp
                                {{ number_format($tauxDepot, 1, ',', ' ') }}%
                            </td>
                        </tr>
                        
                        <!-- Ligne Solde -->
                        <tr style="background-color: #f0fdf4; font-weight: bold;">
                            <td><strong>SOLDE NET</strong></td>
                            <td class="text-center">-</td>
                            <td class="text-right">
                                @php
                                    $solde = $statistiques['collectes']['montant'] - $statistiques['depots']['montant'];
                                @endphp
                                {{ number_format($solde, 0, ',', ' ') }} FCFA
                            </td>
                            <td class="text-right">-</td>
                            <td class="text-center">
                                @if($solde >= 0)
                                    <span class="badge bg-success">✓ Excédent</span>
                                @else
                                    <span class="badge bg-danger">⚠ Déficit</span>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Collectes par type (optionnel) -->
    @if(isset($statistiques['collectes']['par_type']) && count($statistiques['collectes']['par_type']) > 0)
    <div class="card shadow mb-4">
        <div class="card-header bg-white py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-chart-pie me-2"></i>Répartition des collectes par type
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>Type de collecte</th>
                            <th class="text-center">Nombre</th>
                            <th class="text-right">Montant</th>
                            <th class="text-center">% du total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($statistiques['collectes']['par_type'] as $type => $info)
                        @php
                            $pourcentage = $statistiques['collectes']['montant'] > 0 
                                ? ($info['montant'] / $statistiques['collectes']['montant']) * 100 
                                : 0;
                        @endphp
                        <tr>
                            <td><strong>{{ ucfirst($type) }}</strong></td>
                            <td class="text-center">
                                <span class="badge bg-primary">{{ $info['nombre'] }}</span>
                            </td>
                            <td class="text-right">
                                <strong>{{ number_format($info['montant'], 0, ',', ' ') }} FCFA</strong>
                            </td>
                            <td>
                                {{ number_format($pourcentage, 1, ',', ' ') }}%
                                <div class="progress mt-2" style="height: 8px;">
                                    <div class="progress-bar 
                                        @if($pourcentage > 50) bg-success
                                        @elseif($pourcentage > 25) bg-info
                                        @elseif($pourcentage > 10) bg-warning
                                        @else bg-secondary
                                        @endif"
                                        role="progressbar" 
                                        style="width: {{ $pourcentage }}%"
                                        aria-valuenow="{{ $pourcentage }}" 
                                        aria-valuemin="0" 
                                        aria-valuemax="100">
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

    <!-- Boutons d'action -->
    <div class="card shadow mb-4">
        <div class="card-body text-center">
            <div class="btn-group" role="group">
                <form method="POST" action="{{ route('regisseur.rapports.synthese.imprimer') }}" class="d-inline">
                    @csrf
                    <input type="hidden" name="date_debut" value="{{ $dateDebut }}">
                    <input type="hidden" name="date_fin" value="{{ $dateFin }}">
                    <button type="submit" class="btn btn-success btn-lg mx-2">
                        <i class="fas fa-print me-2"></i>Imprimer le rapport
                    </button>
                </form>
                <a href="javascript:window.print()" class="btn btn-outline-primary btn-lg mx-2">
                    <i class="fas fa-file-pdf me-2"></i>Version imprimable
                </a>
                <button onclick="exporterExcel()" class="btn btn-outline-success btn-lg mx-2">
                    <i class="fas fa-file-excel me-2"></i>Exporter Excel
                </button>
            </div>
            <div class="mt-3">
                <a href="{{ route('regisseur.rapports.marche') }}" class="btn btn-outline-info me-2">
                    <i class="fas fa-store me-2"></i>Voir rapport par marché
                </a>
                <a href="{{ route('regisseur.rapports.agent') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-user-tie me-2"></i>Voir rapport par agent
                </a>
            </div>
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
    .badge {
        font-size: 0.85em;
        padding: 0.35em 0.65em;
    }
    .card.border-left-primary { border-left-color: #4e73df !important; }
    .card.border-left-success { border-left-color: #1cc88a !important; }
    .card.border-left-info { border-left-color: #36b9cc !important; }
    .card.border-left-warning { border-left-color: #f6c23e !important; }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        // Validation des dates
        $('input[type="date"]').change(function() {
            const dateDebut = $('input[name="date_debut"]').val();
            const dateFin = $('input[name="date_fin"]').val();
            
            if (dateDebut && dateFin && dateDebut > dateFin) {
                alert('La date de début ne peut pas être après la date de fin.');
                $('input[name="date_fin"]').val('');
            }
        });
    });

    function exporterExcel() {
        // Ici vous pouvez implémenter l'export Excel
        alert('Export Excel - Fonctionnalité à implémenter.');
    }
</script>
@endpush
