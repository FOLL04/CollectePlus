@extends('layouts.app')

@section('title', 'Modifier la zone')

@section('content')
<div class="form-container">
    <h2><i class="fas fa-edit"></i> Modifier la zone</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li><i class="fas fa-exclamation-circle"></i> {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!--  route update avec l'ID de la zone -->
    <form method="POST" action="{{ route('zones.update', $zone->id) }}">
        @csrf
        @method('PUT') 

        <!-- Nom de la zone -->
        <div class="form-group">
            <label><i class="fas fa-tag"></i> Nom de la zone</label>
            <input type="text" name="nom_zone" value="{{ old('nom_zone', $zone->nom_zone) }}" placeholder="Nom de la zone" required>
        </div>

        <!-- Marché associé -->
        <div class="form-group">
            <label><i class="fas fa-store"></i> Marché associé</label>
            <select name="marche_id" required>
                <option value="">-- Sélectionner un marché --</option>
                @foreach($marches as $marche)
                    <option value="{{ $marche->id }}" {{ $zone->marche_id == $marche->id ? 'selected' : '' }}>
                        {{ $marche->nom }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Agent de collecte -->
        <div class="form-group">
            <label><i class="fas fa-user"></i> Agent de collecte</label>
            <select name="agent_id" required>
                <option value="">-- Sélectionner un agent --</option>
                @foreach($agents as $agent)
                    <option value="{{ $agent->id }}" {{ $zone->agent_id == $agent->id ? 'selected' : '' }}>
                        {{ $agent->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Description -->
        <div class="form-group">
            <label><i class="fas fa-align-left"></i> Description</label>
            <textarea name="description" rows="4" placeholder="Description de la zone">{{ old('description', $zone->description) }}</textarea>
        </div>

        <!-- Bouton -->
        <button type="submit" class="btn-submit">
            <i class="fas fa-save"></i> Mettre à Jour
        </button>
    </form>
</div>

<!-- ================== CSS ================== -->
<style>
    .form-container {
        max-width: 600px;
        margin: 40px auto;
        background: #ffffff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }

    .form-container h2 {
        margin-bottom: 20px;
        color: #111827;
        font-size: 1.8em;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .alert {
        padding: 15px;
        background: #fee2e2;
        color: #b91c1c;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        font-weight: bold;
        color: #374151;
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 8px;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        width: 100%;
        padding: 12px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 1em;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        border-color: #16a34a;
        box-shadow: 0 0 0 3px rgba(22,163,74,0.2);
        outline: none;
    }

    .btn-submit {
        background: #16a34a;
        color: #fff;
        padding: 12px 20px;
        border: none;
        border-radius: 8px;
        font-size: 1em;
        font-weight: bold;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: background 0.2s ease;
    }

    .btn-submit:hover {
        background: #15803d;
    }
</style>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endsection
