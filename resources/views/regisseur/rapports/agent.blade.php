
@extends('regisseur.layouts.app')

@section('title', 'Rapport par Agent - Régisseur')

@section('content')
<div class="container-fluid px-4">
    <!-- Header avec filtre -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 text-gray-800">
                <i class="fas fa-user-chart text-primary me-2"></i>Rapport par Agent
            </h1>
            <p class="text-muted">Générez des rapports détaillés sur les collectes d'un agent spécifique</p>
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
            <form method="GET" action="{{ route('regisseur.rapports.agent') }}" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-bold">Agent</label>
                    <select name="agent_id" class="form-control select2" required>
                        <option value="">Sélectionnez un agent</option>
                        @foreach($agents as $agentOpt)
                        <option value="{{ $agentOpt->id }}" 
                            {{ $agent && $agent->id == $agentOpt->id ? 'selected' : '' }}>
                            {{ $agentOpt->name }} 
                            @if($agentOpt->zone)
                                - Zone: {{ $agentOpt->zone->nom_zone }}
                            @endif
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Date début</label>
                    <input type="date" name="date_debut" class="form-control" 
                           value="{{ $dateDebut }}" max="{{ date('Y-m-d') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Date fin</label>
                    <input type="date" name="date_fin" class="form-control" 
                           value="{{ $dateFin }}" max="{{ date('Y-m-d') }}">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search me-2"></i>Générer
                    </button>
                </div>
            </form>
        </div>
    </div>

    @if($agent)
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
                                {{ number_format($statistiques['total_general'], 0, ',', ' ') }} FCFA
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
                                {{ $statistiques['nombre_total'] }}
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
                                {{ number_format($statistiques['total_general'] / max($statistiques['nombre_total'], 1), 0, ',', ' ') }} FCFA
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
                                Zone assignée
                            </div>
                            <div class="h6 mb-0 font-weight-bold text-gray-800">
                                {{ $agent->zone->nom_zone ?? 'Non assigné' }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-map-marker-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Informations agent -->
    <div class="card shadow mb-4">
        <div class="card-header bg-white py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-user-tie me-2"></i>Informations de l'agent
            </h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <p><strong>Nom complet:</strong><br>{{ $agent->name }}</p>
                </div>
                <div class="col-md-3">
                    <p><strong>Email:</strong><br>{{ $agent->email }}</p>
                </div>
                <div class="col-md-3">
                    <p><strong>Zone:</strong><br>{{ $agent->zone->nom_zone ?? 'Non assigné' }}</p>
                </div>
                <div class="col-md-3">
                    <p><strong>Marché:</strong><br>{{ $agent->zone->marche->nom ?? 'Non assigné' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistiques par type -->
    <div class="card shadow mb-4">
        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-chart-pie me-2"></i>Répartition par type de collecte
                </h6>
                <span class="badge bg-info">Période: {{ \Carbon\Carbon::parse($dateDebut)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($dateFin)->format('d/m/Y') }}</span>
            </div>
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
                            <th>Visualisation</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($statistiques['par_type'] as $type => $data)
                        @php
                            $pourcentage = $statistiques['total_general'] > 0 ? 
                                ($data['montant'] / $statistiques['total_general']) * 100 : 0;
                        @endphp
                        <tr>
                            <td>
                                <strong>{{ $type }}</strong>
                            </td>
                            <td>
                                <span class="badge bg-primary">{{ $data['nombre'] }}</span>
                            </td>
                            <td>
                                <strong>{{ number_format($data['montant'], 0, ',', ' ') }} FCFA</strong>
                            </td>
                            <td>
                                {{ number_format($data['moyenne'], 0, ',', ' ') }} FCFA
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
                            <td>
                                <button class="btn btn-sm btn-outline-primary" 
                                        onclick="voirDetails('{{ $type }}')">
                                    <i class="fas fa-eye"></i> Détails
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-dark">
                        <tr>
                            <th>TOTAL</th>
                            <th>{{ $statistiques['nombre_total'] }}</th>
                            <th>{{ number_format($statistiques['total_general'], 0, ',', ' ') }} FCFA</th>
                            <th>{{ number_format($statistiques['total_general'] / max($statistiques['nombre_total'], 1), 0, ',', ' ') }} FCFA</th>
                            <th>100%</th>
                            <th></th>
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
                        @foreach($statistiques['par_jour'] as $date => $data)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}</td>
                            <td>{{ $data['nombre'] }}</td>
                            <td>{{ number_format($data['montant'], 0, ',', ' ') }} FCFA</td>
                            <td>{{ number_format($data['montant'] / max($data['nombre'], 1), 0, ',', ' ') }} FCFA</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Boutons d'action -->
    <div class="card shadow mb-4">
        <div class="card-body text-center">
            <div class="btn-group" role="group">
                <form method="POST" action="{{ route('regisseur.rapports.agent.imprimer') }}" class="d-inline">
                    @csrf
                    <input type="hidden" name="agent_id" value="{{ $agent->id }}">
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
        </div>
    </div>
    @else
    <!-- Message si aucun agent sélectionné -->
    <div class="card shadow mb-4">
        <div class="card-body text-center py-5">
            <div class="empty-state">
                <i class="fas fa-user-chart fa-4x text-muted mb-4"></i>
                <h3 class="text-muted">Sélectionnez un agent</h3>
                <p class="text-muted mb-4">
                    Choisissez un agent dans le formulaire ci-dessus pour générer son rapport détaillé.
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
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        // Initialiser Select2
        $('.select2').select2({
            placeholder: "Sélectionnez un agent",
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

    function voirDetails(type) {
        alert('Détails pour: ' + type + '\nFonctionnalité à implémenter.');
        // Ici vous pouvez ajouter une modal avec les détails
    }

    function exporterExcel() {
        // Ici vous pouvez implémenter l'export Excel
        alert('Export Excel - Fonctionnalité à implémenter.');
    }
</script>
@endpush