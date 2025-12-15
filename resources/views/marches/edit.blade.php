@extends('layouts.app')

@section('title', 'Modifier le marché')

@section('content')
<div class="form-container">
    <h2><i class="fas fa-edit"></i> Modifier le marché</h2>

    <!-- Affichage des erreurs -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li><i class="fas fa-exclamation-circle"></i> {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('marches.update', $marche->id) }}" class="marche-form">
        @csrf
        @method('PUT')

        <!-- Nom du marché -->
        <div class="form-group">
            <label><i class="fas fa-tag"></i> Nom du marché</label>
            <input type="text" name="nom" value="{{ old('nom', $marche->nom) }}" required>
        </div>

        <!-- Localisation -->
        <div class="form-group">
            <label><i class="fas fa-map-marker-alt"></i> Localisation</label>
            <input type="text" name="localisation" value="{{ old('localisation', $marche->localisation) }}" required>
        </div>

        <!-- Description -->
        <div class="form-group">
            <label><i class="fas fa-align-left"></i> Description</label>
            <textarea name="description" rows="4">{{ old('description', $marche->description) }}</textarea>
        </div>

        <!-- Bouton -->
        <button type="submit" class="btn-submit">
            <i class="fas fa-save"></i> Mettre à jour
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
    .form-group textarea {
        width: 100%;
        padding: 12px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 1em;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
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
