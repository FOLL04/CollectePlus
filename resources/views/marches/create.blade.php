@extends('layouts.app')

@section('title', 'Créer un Marché')

@section('content')
<div class="form-container">
    <h2><i class="fas fa-store"></i> Nouveau Marché</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li><i class="fas fa-exclamation-triangle"></i> {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('marches.store') }}">
        @csrf

        <div class="form-group">
            <label><i class="fas fa-signature"></i> Nom du marché</label>
            <input type="text" name="nom" value="{{ old('nom') }}" required>
        </div>

        <div class="form-group">
            <label><i class="fas fa-map-marker-alt"></i> Localisation</label>
            <input type="text" name="localisation" value="{{ old('localisation') }}" required>
        </div>

                <!-- Petit ajout optionnel -->
        <div class="form-group">
            <label>Localisation <small>(vous pouvez copier-coller depuis Google Maps)</small></label>
            <input type="text" 
                name="localisation" 
                placeholder="Ex: 123 Rue Exemple, lome, togo"
                value="{{ old('localisation') }}"
                required>
            <small class="text-gray-500">
                Vous pouvez trouver l'adresse précise sur 
                <a href="https://maps.google.com" target="_blank" class="text-blue-600">Google Maps</a> 
                et la coller ici
            </small>
        </div>

        <div class="form-group">
            <label><i class="fas fa-align-left"></i> Description</label>
            <textarea name="description" rows="4">{{ old('description') }}</textarea>
        </div>

        <button type="submit" class="btn-submit">
            <i class="fas fa-save"></i> Enregistrer
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
.form-group textarea {
    width: 100%;
    padding: 12px;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    font-size: 1em;
}
.form-group input:focus,
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
    display: inline-flex;
    align-items: center;
    gap: 8px;
}
.btn-submit:hover {
    background: #15803d;
}
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endsection
