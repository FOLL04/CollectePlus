@extends('regisseur.layouts.app')

@section('title', 'Collectes des Agents')

@section('content')
<div class="container">
    <h1>Collectes des Agents</h1>

    <!-- Formulaire de filtres -->
    <div class="card mb-4">
        <div class="card-header">Filtres</div>
        <div class="card-body">
            <form method="GET" action="{{ route('regisseur.collectes.index') }}" class="row g-3">
                <!-- Agent -->
                <div class="col-md-3">
                    <label for="agent_id" class="form-label">Agent</label>
                    <select name="agent_id" id="agent_id" class="form-select">
                        <option value="">-- Tous --</option>
                        @foreach($agents as $agent)
                            <option value="{{ $agent->id }}" {{ request('agent_id') == $agent->id ? 'selected' : '' }}>
                                {{ $agent->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Date début -->
                <div class="col-md-3">
                    <label for="date_debut" class="form-label">Date début</label>
                    <input type="date" name="date_debut" id="date_debut" value="{{ request('date_debut') }}" class="form-control">
                </div>

                <!-- Date fin -->
                <div class="col-md-3">
                    <label for="date_fin" class="form-label">Date fin</label>
                    <input type="date" name="date_fin" id="date_fin" value="{{ request('date_fin') }}" class="form-control">
                </div>

                

                <!-- Type de collecte -->
                <div class="col-md-3">
                    <label for="type_collecte" class="form-label">Type de collecte</label>
                    <select name="type_collecte" id="type_collecte" class="form-select">
                        <option value="">-- Tous --</option>
                        <option value="journalier" {{ request('type_collecte') == 'journalier' ? 'selected' : '' }}>Journalier</option>
                        <option value="mensuel" {{ request('type_collecte') == 'mensuel' ? 'selected' : '' }}>Mensuel</option>
                    </select>
                </div>

                <!-- Boutons -->
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary">Filtrer</button>
                    <a href="{{ route('regisseur.collectes.index') }}" class="btn btn-secondary">Réinitialiser</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Totaux globaux -->
    <div class="alert alert-info">
        <strong>Total collectes :</strong> {{ $totalCollectes }} |
        <strong>Montant total :</strong> {{ number_format($totalMontant, 0, ',', ' ') }} FCFA
    </div>

    <!-- Liste des collectes regroupées -->
    @forelse($grouped as $agentId => $places)
        @php $agent = $agents->firstWhere('id', $agentId); @endphp
        <div class="card mb-4">
            <div class="card-header">
                <h4>Agent : {{ $agent->name ?? 'Inconnu' }}</h4>
            </div>
            <div class="card-body">
                @foreach($places as $placeId => $types)
                    @php
                        $place = \App\Models\Place::find($placeId);
                    @endphp
                    <h5>Place/Boutique : {{ $place->nom ?? 'N/A' }} (Zone : {{ $place->hangar->zone->nom ?? 'N/A' }})</h5>
                    <table class="table table-bordered mb-3">
                        <thead>
                            <tr>
                                <th>Type de collecte</th>
                                <th>Nombre</th>
                                <th>Montant total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($types as $type => $data)
                                <tr>
                                    <td>{{ ucfirst($type) }}</td>
                                    <td>{{ $data['count'] }}</td>
                                    <td>{{ number_format($data['total'], 0, ',', ' ') }} FCFA</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endforeach
            </div>
        </div>
    @empty
        <div class="alert alert-warning">Aucune collecte trouvée pour les critères sélectionnés.</div>
    @endforelse
</div>
@endsection
