@extends('regisseur.layouts.app')

@section('title', 'Nouveau Dépôt')

@section('content')
<div class="container">
    <h1 class="mb-4"><i class="fas fa-plus-circle"></i> Enregistrer un Dépôt</h1>

    <!-- Affichage des erreurs -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li><i class="fas fa-exclamation-triangle"></i> {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('regisseur.depots.store') }}" method="POST">
        @csrf

        <!-- Sélection de l'agent -->
        <div class="mb-3">
            <label for="agent_id" class="form-label"><i class="fas fa-user"></i> Agent</label>
            <select name="agent_id" id="agent_id" class="form-select" required>
                <option value="">-- Sélectionner un agent --</option>
                @foreach($agents as $agent)
                    <option value="{{ $agent->id }}">
                        {{ $agent->name }} (Zone: {{ $agent->zone->nom_zone ?? 'N/A' }} - Marché: {{ $agent->zone->marche->nom ?? 'N/A' }})
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Montant -->
        <div class="mb-3">
            <label for="montant" class="form-label"><i class="fas fa-coins"></i> Montant</label>
            <input type="number" step="0.01" min="1" name="montant" id="montant" class="form-control" required>
        </div>

        <!-- Observations -->
        <div class="mb-3">
            <label for="observations" class="form-label"><i class="fas fa-comment"></i> Observations</label>
            <textarea name="observations" id="observations" class="form-control" rows="3"></textarea>
        </div>

        <!-- Bouton -->
        <button type="submit" class="btn btn-success">
            <i class="fas fa-save"></i> Enregistrer
        </button>
    </form>
</div>
@endsection
