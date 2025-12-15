@extends('layouts.app')

@section('title', 'Créer une Place')

@section('content')
<div class="form-container">
    <h2><i class="fas fa-plus-circle"></i> Nouvelle Place</h2>

    @if ($errors->any())
        <div class="alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li><i class="fas fa-exclamation-triangle"></i> {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('places.store') }}">
        @csrf

        <!-- Hangar -->
        <div class="form-group">
            <label for="hangar_id"><i class="fas fa-warehouse"></i> Hangar</label>
            <select name="hangar_id" id="hangar_id" required>
                <option value="">-- Sélectionner un hangar --</option>
                @foreach($hangars as $hangar)
                    <option value="{{ $hangar->id }}" {{ old('hangar_id') == $hangar->id ? 'selected' : '' }}>
                        {{ $hangar->code }} | Zone: {{ $hangar->zone->nom_zone }} | Marché: {{ $hangar->zone->marche->nom }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Numéro -->
        <div class="form-group">
            <label for="numero_place"><i class="fas fa-hashtag"></i> Numéro de place</label>
            <input type="text" name="numero_place" id="numero_place" value="{{ old('numero_place') }}" required>
        </div>

        <!-- Type -->
        <div class="form-group">
            <label for="type_place"><i class="fas fa-cube"></i> Type</label>
            <select name="type_place" id="type_place" required>
                <option value="">-- Sélectionner le type --</option>
                <option value="hangar" {{ old('type_place') == 'hangar' ? 'selected' : '' }}>Hangar</option>
                <option value="boutique" {{ old('type_place') == 'boutique' ? 'selected' : '' }}>Boutique</option>
            </select>
        </div>

        <button type="submit" class="btn-submit">
            <i class="fas fa-save"></i> Enregistrer
        </button>
    </form>
</div>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<!-- CSS -->
<style>
.form-container {
    max-width: 600px;
    margin: 40px auto;
    background: #fff;
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
.alert-danger {
    background: #fee2e2;
    color: #b91c1c;
    padding: 12px;
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
.form-group select {
    width: 100%;
    padding: 12px;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    font-size: 1em;
    background-color: #fff;
    color: #000;
}
.form-group input:focus,
.form-group select:focus {
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
}
.btn-submit:hover {
    background: #15803d;
}
</style>
@endsection
