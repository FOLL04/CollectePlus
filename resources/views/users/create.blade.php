@extends('layouts.app')

@section('title', 'Créer un utilisateur')

@section('content')
<div class="form-container">
    <h2><i class="fas fa-user-plus"></i> Créer un nouvel utilisateur</h2>

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

    <form method="POST" action="{{ route('users.store') }}" class="user-form">
        @csrf

        <!-- Nom -->
        <div class="form-group">
            <label><i class="fas fa-user"></i> Nom</label>
            <input type="text" name="name" value="{{ old('name') }}" placeholder="Entrez le nom complet" required>
        </div>

        <!-- Email -->
        <div class="form-group">
            <label><i class="fas fa-envelope"></i> Email</label>
            <input type="email" name="email" value="{{ old('email') }}" placeholder="exemple@domaine.com" required>
        </div>

        <!-- Téléphone -->
        <div class="form-group">
            <label><i class="fas fa-phone"></i> Téléphone</label>
            <input type="text" name="phone" value="{{ old('phone') }}" placeholder="Numéro de téléphone" required>
        </div>

        <!-- Mot de passe -->
        <div class="form-group">
            <label><i class="fas fa-lock"></i> Mot de passe</label>
            <input type="password" name="password" placeholder="Mot de passe sécurisé" required>
        </div>

        <!-- Numéro de carte d'identité -->
        <div class="form-group">
            <label><i class="fas fa-id-card"></i> Numéro de carte d'identité</label>
            <input type="text" name="identity_card_number" value="{{ old('identity_card_number') }}" placeholder="Numéro de la carte d'identité">
        </div>

        <!-- Adresse -->
        <div class="form-group">
            <label><i class="fas fa-map-marker-alt"></i> Adresse</label>
            <input type="text" name="address" value="{{ old('address') }}" placeholder="Adresse complète">
        </div>

        <!-- Personne à prévenir -->
        <div class="form-group">
            <label><i class="fas fa-user-friends"></i> Nom de la personne à prévenir</label>
            <input type="text" name="emergency_contact_name" value="{{ old('emergency_contact_name') }}" placeholder="Nom de la personne à prévenir">
        </div>

        <!-- Contact personne à prévenir -->
        <div class="form-group">
            <label><i class="fas fa-phone-alt"></i> Contact de la personne à prévenir</label>
            <input type="text" name="emergency_contact_phone" value="{{ old('emergency_contact_phone') }}" placeholder="Téléphone de la personne à prévenir">
        </div>

        <!-- Sexe -->
        <div class="form-group">
            <label><i class="fas fa-venus-mars"></i> Sexe</label>
            <select name="gender">
                <option value="">-- Sélectionnez --</option>
                <option value="Homme" {{ old('gender') == 'Homme' ? 'selected' : '' }}>Homme</option>
                <option value="Femme" {{ old('gender') == 'Femme' ? 'selected' : '' }}>Femme</option>
            </select>
        </div>

        <!-- Date de naissance -->
        <div class="form-group">
            <label><i class="fas fa-calendar-alt"></i> Date de naissance</label>
            <input type="date" name="birth_date" value="{{ old('birth_date') }}">
        </div>

        <!-- Rôle -->
        <div class="form-group">
            <label><i class="fas fa-user-tag"></i> Rôle</label>
            <select name="role_id" required>
                <option value="">-- Sélectionnez un rôle --</option>
                @foreach ($roles as $role)
                    <option value="{{ $role->id }}">{{ ucfirst($role->name) }}</option>
                @endforeach
            </select>
        </div>

        <!-- Bouton -->
        <button type="submit" class="btn-submit">
            <i class="fas fa-save"></i> Créer l'utilisateur
        </button>
    </form>
</div>

<!-- ================== CSS ================== -->
<style>
    .form-container {
        max-width: 700px;
        margin: 40px auto;
        background: #ffffff;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    .form-container h2 {
        margin-bottom: 20px;
        color: #16a34a;
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
    .form-group select {
        width: 100%;
        padding: 12px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 1em;
        transition: border-color 0.2s ease;
    }

    .form-group input:focus,
    .form-group select:focus {
        border-color: #16a34a;
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

<!-- Font Awesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endsection
