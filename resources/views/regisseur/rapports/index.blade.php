@extends('layouts.regisseur')

@section('content')
<div class="container-fluid">
    <h2> Rapport détaillé par Agent</h2>
    
    <!-- Formulaire de filtrage -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('regisseur.rapports.agent') }}">
                <div class="row">
                    <div class="col-md-4">
                        <label>Agent</label>
                        <select name="agent_id" class="form-control" required>
                            <option value="">Sélectionner un agent</option>
                            @foreach($agents as $agentOpt)
                            <option value="{{ $agentOpt->id }}" {{ $agent && $agent->id == $agentOpt->id ? 'selected' : '' }}>
                                {{ $agentOpt->name }} - {{ $agentOpt->zone->marche->nom ?? 'Non assigné' }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label>Date début</label>
                        <input type="date" name="date_debut" class="form-control" value="{{ $dateDebut }}">
                    </div>
                    <div class="col-md-3">
                        <label>Date fin</label>
                        <input type="date" name="date_fin" class="form-control" value="{{ $dateFin }}">
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">Générer</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    @if($agent)
    <!-- Résumé statistique -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h6>Total Collecté</h6>
                    <h3>{{ number_format($statistiques['total_general'], 0, ',', ' ') }} FCFA</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h6>Nombre de collectes</h6>
                    <h3>{{ $statistiques['nombre_total'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h6>Moyenne par collecte</h6>
                    <h3>{{ number_format($statistiques['total_general'] / max($statistiques['nombre_total'], 1), 0, ',', ' ') }} FCFA</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h6>Zone assignée</h6>
                    <h5>{{ $agent->zone->nom_zone ?? 'Non assigné' }}</h5>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Détail par type -->
    <div class="card mb-4">
        <div class="card-header">
            <h5>Détail par type de collecte</h5>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr class="table-dark">
                        <th>Type de collecte</th>
                        <th>Nombre</th>
                        <th>Montant total</th>
                        <th>Moyenne</th>
                        <th>% du total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($statistiques['par_type'] as $type => $data)
                    <tr>
                        <td><strong>{{ $type }}</strong></td>
                        <td>{{ $data['nombre'] }}</td>
                        <td>{{ number_format($data['montant'], 0, ',', ' ') }} FCFA</td>
                        <td>{{ number_format($data['moyenne'], 0, ',', ' ') }} FCFA</td>
                        <td>
                            <div class="progress">
                                <div class="progress-bar" style="width: {{ ($data['montant'] / $statistiques['total_general']) * 100 }}%">
                                    {{ round(($data['montant'] / $statistiques['total_general']) * 100, 1) }}%
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- Bouton d'impression -->
    <div class="text-center mb-4">
        <form method="POST" action="{{ route('regisseur.rapports.agent.imprimer') }}">
            @csrf
            <input type="hidden" name="agent_id" value="{{ $agent->id }}">
            <input type="hidden" name="date_debut" value="{{ $dateDebut }}">
            <input type="hidden" name="date_fin" value="{{ $dateFin }}">
            <button type="submit" class="btn btn-success btn-lg">
                <i class="fas fa-print"></i> Imprimer le rapport
            </button>
        </form>
    </div>
    @endif
</div>
@endsection