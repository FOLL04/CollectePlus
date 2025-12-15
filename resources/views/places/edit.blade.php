@extends('layouts.app')

@section('title', 'Modifier une Place')

@section('content')
<div class="form-container">
    <h2><i class="fas fa-edit"></i> Modifier la Place</h2>

    <form method="POST" action="{{ route('places.update', $place->id) }}">
        @csrf
        @method('PUT')

        <!-- Hangar -->
        <div class="form-group">
            <label><i class="fas fa-warehouse"></i> Hangar</label>
            <select name="hangar_id" required>
                @foreach($hangars as $hangar)
                    <option value="{{ $hangar->id }}" {{ $place->hangar_id == $hangar->id ? 'selected' : '' }}>
                        {{ $hangar->code }} - Zone: {{ $hangar->zone->nom_zone }} - Marché: {{ $hangar->zone->marche->nom }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Numéro -->
        <div class="form-group">
            <label><i class="fas fa-hashtag"></i> Numéro de place</label>
            <input type="text" name="numero_place" value="{{ old('numero_place', $place->numero_place) }}" required>
        </div>

        <!-- Type -->
        <div class="form-group">
            <label><i class="fas fa-cube"></i> Type</label>
            <select name="type_place" required>
                <option value="hangar" {{ $place->type_place == 'hangar' ? 'selected' : '' }}>Hangar</option>
                <option value="boutique" {{ $place->type_place == 'boutique' ? 'selected' : '' }}>Boutique</option>
            </select>
        </div>

        <button type="submit" class="btn-submit">
            <i class="fas fa-save"></i> Mettre à jour
        </button>
    </form>
</div>

<style>
.form-container {
    max-width: 600px;
    margin: 40px auto;
    background: #fff;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    color: #000; /* Texte global en noir */
}

.form-container h2 {
    margin-bottom: 20px;
    color: #000; /* Titre en noir */
    font-size: 1.8em;
    display: flex;
    align-items: center;
    gap: 10px;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    font-weight: bold;
    color: #000; /* Labels en noir */
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 8px;
}

.form-group input,
.form-group select {
    width: 100%;
    padding: 12px;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    font-size: 1em;
    color: #000; /* Texte des inputs et selects en noir */
    background-color: #fff;
}

.form-group input:focus,
.form-group select:focus {
    border-color: #2563eb;
    box-shadow: 0 0 0 3px rgba(37,99,235,0.2);
    outline: none;
    color: #000; /* Maintenir le texte en noir même au focus */
}

.btn-submit {
    background: #2563eb;
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
}

.btn-submit:hover {
    background: #1e40af;
}
</style>

@endsection
