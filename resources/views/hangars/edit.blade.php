@extends('layouts.app')

@section('title', 'Modifier un Hangar')

@section('content')
<div class="form-container">
    <h2><i class="fas fa-edit"></i> Modifier Hangar</h2>

    <form method="POST" action="{{ route('hangars.update', $hangar->id) }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label><i class="fas fa-tag"></i> Code du Hangar</label>
            <input type="text" name="code" value="{{ $hangar->code }}" required>
        </div>

        <div class="form-group">
            <label><i class="fas fa-store"></i> Marché associé</label>
            <select name="marche_id" required>
                @foreach($marches as $marche)
                    <option value="{{ $marche->id }}" {{ $hangar->marche_id == $marche->id ? 'selected' : '' }}>
                        {{ $marche->nom }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label><i class="fas fa-cube"></i> Type</label>
            <input type="text" name="type" value="{{ $hangar->type }}">
        </div>

        <button type="submit" class="btn-submit">
            <i class="fas fa-save"></i> Mettre à jour
        </button>
    </form>
</div>

<style>
    .form-container { max-width: 600px; margin: 30px auto; background: #fff; padding: 25px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
    .form-container h2 { margin-bottom: 20px; color: #111827; }
    .form-group { margin-bottom: 15px; }
    .form-group label { font-weight: bold; color: #374151; display: block; margin-bottom: 6px; }
    .form-group input, .form-group select { width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px; }
    .form-group input:focus, .form-group select:focus { border-color: #f59e0b; outline: none; }
    .btn-submit { background: #f59e0b; color: #fff; padding: 10px 15px; border: none; border-radius: 6px; cursor: pointer; }
    .btn-submit:hover { background: #d97706; }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare">