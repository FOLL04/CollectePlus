@extends('layouts.app')

@section('title', 'Creer un Hangar')

@section('content')
<div class="form-container">
    <h2><i class="fas fa-plus-circle"></i> Créer un nouveau hangar</h2>

    <form method="POST" action="{{ route('hangars.store') }}">
        @csrf

        <!-- Zone -->
        <div class="form-group">
            <label><i class="fas fa-layer-group"></i> Zone</label>
            <select name="zone_id" required>
                <option value="">-- Choisir une zone --</option>
                @foreach($zones as $zone)
                    <option value="{{ $zone->id }}">
                        {{ $zone->nom_zone }} ({{ $zone->marche->nom }})
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Code du hangar -->
        <div class="form-group">
            <label><i class="fas fa-barcode"></i> Code du hangar</label>
            <input type="text" name="code" placeholder="Ex: H-001" required>
        </div>

        <!-- Type -->
        <div class="form-group">
            <label><i class="fas fa-cube"></i> Type de hangar</label>
            <select name="type" required>
                <option value="standard">Standard</option>
                <option value="boutique">Boutique</option>
            </select>
        </div>

        <!-- Boutons -->
        <div class="form-actions">
            <button type="submit" class="btn-submit">
                <i class="fas fa-save"></i> Enregistrer
            </button>
            <a href="{{ route('hangars.index') }}" class="btn-cancel">
                <i class="fas fa-times"></i> Annuler
            </a>
        </div>
    </form>
</div>

<style>
.form-container {
    max-width: 600px;
    margin: 40px auto;
    background: #fff;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    border: 1px solid #e5e7eb;
}

.form-container h2 {
    margin-bottom: 25px;
    color: #000000;
    font-size: 1.8rem;
    display: flex;
    align-items: center;
    gap: 12px;
    padding-bottom: 15px;
    border-bottom: 2px solid #16a34a;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    font-weight: 600;
    color: #374151;
    display: block;
    margin-bottom: 8px;
    font-size: 0.95rem;
}

.form-group label i {
    width: 20px;
    color: #16a34a;
    margin-right: 8px;
}

.form-group input,
.form-group select {
    width: 100%;
    padding: 12px 15px;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: #f9fafb;
}

.form-group input:focus,
.form-group select:focus {
    border-color: #16a34a;
    outline: none;
    background: white;
    box-shadow: 0 0 0 3px rgba(22, 163, 74, 0.1);
}

.form-group input::placeholder {
    color: #9ca3af;
    opacity: 0.7;
}

.form-actions {
    display: flex;
    gap: 15px;
    margin-top: 30px;
    padding-top: 20px;
    border-top: 1px solid #e5e7eb;
}

.btn-submit {
    background: #16a34a;
    color: #fff;
    padding: 12px 25px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 600;
    font-size: 1rem;
    display: flex;
    align-items: center;
    gap: 10px;
    transition: all 0.3s ease;
    flex: 1;
    justify-content: center;
}

.btn-submit:hover {
    background: #15803d;
    transform: translateY(-2px);
}

.btn-cancel {
    background: #6b7280;
    color: #fff;
    padding: 12px 25px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    font-size: 1rem;
    display: flex;
    align-items: center;
    gap: 10px;
    transition: all 0.3s ease;
    flex: 1;
    justify-content: center;
    text-align: center;
}

.btn-cancel:hover {
    background: #4b5563;
    transform: translateY(-2px);
}

@media (max-width: 640px) {
    .form-container {
        margin: 20px;
        padding: 20px;
    }
    
    .form-actions {
        flex-direction: column;
    }
}
</style>
@endsection