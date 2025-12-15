@extends('regisseur.layouts.app')

@section('title', 'Rapport par Marché - Régisseur')

@section('content')
<div class="container-fluid px-4">
    <!-- Header avec filtre -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 text-gray-800">
                <i class="fas fa-store text-primary me-2"></i>Rapport par Marché
            </h1>
            <p class="text-muted">Générez des rapports détaillés sur les collectes d'un marché spécifique</p>
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
            <form method="GET" action="{{ route('regisseur.rapports.marche') }}" class="row g-3">
                <div class="col-md-5">
                    <label class="form-label fw-bold">Marché</label>
                    <select name="marche_id" class="form-control select2">
                        <option value="">Tous les marchés</option>
                        @foreach($marches as $marcheOpt)
                        <option value="{{ $marcheOpt->id }}" 
                            {{ $marche && $marche->id == $marcheOpt->id ? 'selected' : '' }}>
                            {{ $marcheOpt->nom }}
                        </option>
                        @endforeach
                    </select>
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

    @if($marche || request('marche_id') == '')
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
                                {{ number_format($statistiques['total_montant'] ?? 0, 0, ',', ' ') }} FCFA
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
                                Nombre de collectes
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $statistiques['total_collectes'] ?? 0 }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-list fa-2x text-gray-300"></i>
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
                                Moyenne par collecte
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                @php
                                    $total = $statistiques['total_montant'] ?? 0;
                                    $count = $statistiques['total_collectes'] ?? 0;
                                    $avg = $count > 0 ? $total / $count : 0;
                                @endphp
                                {{ number_format($avg, 0, ',', ' ') }} FCFA
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calculator fa-2x text-gray-300"></i>
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
                                Agents actifs
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $statistiques['nombre_agents'] ?? 0 }}
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

    <!-- Informations marché -->
    <div class="card shadow mb-4">
        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-info-circle me-2"></i>
                    {{ $marche ? 'Informations du marché' : 'Vue globale (tous les marchés)' }}
                </h6>
                <span class="badge bg-info">
                    Période: {{ \Carbon\Carbon::parse($dateDebut)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($dateFin)->format('d/m/Y') }}
                </span>
            </div>
        </div>
        <div class="card-body">
            @if($marche)
            <div class="row">
                <div class="col-md-4">
                    <p><strong>Nom du marché:</strong><br>{{ $marche->nom }}</p>
                </div>
                <div class="col-md-4">
                    <p><strong>Zones:</strong><br>{{ $statistiques['nombre_zones'] ?? 0 }} zones</p>
                </div>
                <div class="col-md-4">
                    <p><strong>Hangars:</strong><br>{{ $marche->hangars_count ?? 0 }} hangars</p>
                </div>
            </div>
            @else
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Portée du rapport:</strong><br>Tous les marchés de la plateforme</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Total marchés:</strong><br>{{ $marches->count() }} marchés inclus</p>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Statistiques par zone -->
    <div class="card shadow mb-4">
        <div class="card-header bg-white py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-map-marked-alt me-2"></i>Collectes par zone
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>Zone</th>
                            <th>Nombre de collectes</th>
                            <th>Montant total</th>
                            <th>Moyenne par collecte</th>
                            <th>Agents actifs</th>
                            <th>% du total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($collectesParZone ?? [] as $zone => $info)
                        @php
                            $pourcentage = $statistiques['total_montant'] > 0 ? 
                                ($info['montant'] / $statistiques['total_montant']) * 100 : 0;
                        @endphp
                        <tr>
                            <td>
                                <strong>{{ $zone }}</strong>
                            </td>
                            <td>
                                <span class="badge bg-primary">{{ $info['nombre'] ?? 0 }}</span>
                            </td>
                            <td>
                                <strong>{{ number_format($info['montant'] ?? 0, 0, ',', ' ') }} FCFA</strong>
                            </td>
                            <td>
                                @php
                                    $moyenneZone = ($info['nombre'] ?? 0) > 0 ? 
                                        ($info['montant'] ?? 0) / ($info['nombre'] ?? 1) : 0;
                                @endphp
                                {{ number_format($moyenneZone, 0, ',', ' ') }} FCFA
                            </td>
                            <td>
                                {{ $info['agents'] ?? 0 }}
                            </td>
                            <td>
                                {{ round($pourcentage, 1) }}%
                                <div class="progress mt-2" style="height: 8px;">
                                    <div class="progress-bar 
                                        @if($pourcentage > 40) bg-success
                                        @elseif($pourcentage > 20) bg-info
                                        @elseif($pourcentage > 5) bg-warning
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

    <!-- Statistiques par type de collecte -->
    <div class="card shadow mb-4">
        <div class="card-header bg-white py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-chart-pie me-2"></i>Répartition par type de collecte
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>Type de collecte</th>
                            <th>Nombre</th>
                            <th>Montant total</th>
                            <th>Moyenne</th>
                            <th>% du total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($collectesParType ?? [] as $type => $info)
                        @php
                            $pourcentage = $statistiques['total_montant'] > 0 ? 
                                ($info['montant'] / $statistiques['total_montant']) * 100 : 0;
                        @endphp
                        <tr>
                            <td>
                                <strong>{{ ucfirst($type) }}</strong>
                            </td>
                            <td>
                                <span class="badge bg-primary">{{ $info['nombre'] ?? 0 }}</span>
                            </td>
                            <td>
                                <strong>{{ number_format($info['montant'] ?? 0, 0, ',', ' ') }} FCFA</strong>
                            </td>
                            <td>
                                @php
                                    $moyenneType = ($info['nombre'] ?? 0) > 0 ? 
                                        ($info['montant'] ?? 0) / ($info['nombre'] ?? 1) : 0;
                                @endphp
                                {{ number_format($moyenneType, 0, ',', ' ') }} FCFA
                            </td>
                            <td>
                                {{ round($pourcentage, 1) }}%
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
                    <tfoot class="table-dark">
                        <tr>
                            <th>TOTAL</th>
                            <th>{{ $statistiques['total_collectes'] ?? 0 }}</th>
                            <th>{{ number_format($statistiques['total_montant'] ?? 0, 0, ',', ' ') }} FCFA</th>
                            <th>
                                @php
                                    $total = $statistiques['total_montant'] ?? 0;
                                    $count = $statistiques['total_collectes'] ?? 0;
                                    $avgTotal = $count > 0 ? $total / $count : 0;
                                @endphp
                                {{ number_format($avgTotal, 0, ',', ' ') }} FCFA
                            </th>
                            <th>100%</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <!-- Évolution quotidienne -->
    <div class="card shadow mb-4">
        <div class="card-header bg-white py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-chart-line me-2"></i>Évolution quotidienne
            </h6>
        </div>
        <div class="card-body">
            @if(!empty($collectesParJour))
            <div class="table-responsive">
                <table class="table table-sm table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Date</th>
                            <th>Nombre de collectes</th>
                            <th>Montant total</th>
                            <th>Moyenne par collecte</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($collectesParJour as $date => $data)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}</td>
                            <td>{{ $data['nombre'] ?? 0 }}</td>
                            <td>{{ number_format($data['montant'] ?? 0, 0, ',', ' ') }} FCFA</td>
                            <td>
                                @php
                                    $moyenneJour = ($data['nombre'] ?? 0) > 0 ? 
                                        ($data['montant'] ?? 0) / ($data['nombre'] ?? 1) : 0;
                                @endphp
                                {{ number_format($moyenneJour, 0, ',', ' ') }} FCFA
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="text-center py-4">
                <p class="text-muted">Aucune donnée disponible pour l'évolution quotidienne</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Boutons d'action -->
    <div class="card shadow mb-4">
        <div class="card-body text-center">
            <div class="btn-group" role="group">
                <form method="POST" action="{{ route('regisseur.rapports.marche.imprimer') }}" class="d-inline">
                    @csrf
                    <input type="hidden" name="marche_id" value="{{ $marche->id ?? '' }}">
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
                <a href="{{ route('regisseur.rapports.agent') }}" class="btn btn-outline-info">
                    <i class="fas fa-exchange-alt me-2"></i>Voir rapport par agent
                </a>
            </div>
        </div>
    </div>
    @else
    <!-- Message si aucun marché sélectionné -->
    <div class="card shadow mb-4">
        <div class="card-body text-center py-5">
            <div class="empty-state">
                <i class="fas fa-store fa-4x text-muted mb-4"></i>
                <h3 class="text-muted">Sélectionnez un marché</h3>
                <p class="text-muted mb-4">
                    Choisissez un marché dans le formulaire ci-dessus pour générer son rapport détaillé.
                </p>
                <p>
                    <small class="text-muted">Ou laissez vide pour voir tous les marchés</small>
                </p>
            </div>
        </div>
    </div>
    @endif
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
    .empty-state {
        opacity: 0.7;
    }
    .select2-container .select2-selection--single {
        height: 38px !important;
        border: 1px solid #d1d3e2 !important;
    }
    .badge {
        font-size: 0.85em;
        padding: 0.35em 0.65em;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        // Initialiser Select2
        $('.select2').select2({
            placeholder: "Sélectionnez un marché",
            allowClear: true
        });

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