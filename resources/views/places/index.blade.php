@extends('layouts.app')

@section('title', 'Liste des Places')

@section('content')
<div class="places-container">
    <!-- En-tête avec titre et bouton -->
    <div class="header">
        <h2><i class="fas fa-parking"></i> Gestion des Places</h2>
        <a href="{{ route('places.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle"></i> Nouvelle Place
        </a>
    </div>

    <!-- Messages de succès -->
    @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <!-- Si aucune place -->
    @if($places->isEmpty())
        <div class="empty-state">
            <i class="fas fa-parking fa-3x"></i>
            <h3>Aucune place enregistrée</h3>
            <p>Commencez par créer votre première place de stationnement.</p>
            <a href="{{ route('places.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Créer une place
            </a>
        </div>
    @else

    
        <!-- Statistiques -->
        <div class="stats">
            <div class="stat-card">
                <i class="fas fa-layer-group"></i>
                <div>
                    <h3>{{ $places->count() }}</h3>
                    <p>Places totales</p>
                </div>
            </div>
            
            <div class="stat-card">
                <i class="fas fa-store"></i>
                <div>
                    <h3>{{ $places->where('type_place', 'boutique')->count() }}</h3>
                    <p>Nombre de boutiques</p>
                </div>
            </div>
        </div>

        <!-- Tableau des places -->
        <div class="table-wrapper">
            <table class="styled-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Numéro</th>
                        <th>Type</th>
                        <th>Hangar</th>
                        <th>Zone</th>
                        <th>Marché</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($places as $place)
                    <tr>
                        <td><span class="badge-id">#{{ $place->id }}</span></td>
                        <td>
                            <div class="place-number">
                                <i class="fas fa-hashtag"></i>
                                <strong>{{ $place->numero_place }}</strong>
                            </div>
                        </td>
                        <td>
                            <span class="badge-type badge-{{ $place->type_place }}">
                                <i class="fas {{ $place->type_place == 'standard' ? 'fa-car' : 'fa-store' }}"></i>
                                {{ ucfirst($place->type_place) }}
                            </span>
                        </td>
                        <td>
                            <div class="info-cell">
                                <i class="fas fa-warehouse"></i>
                                <span>{{ $place->hangar->code ?? '-' }}</span>
                            </div>
                        </td>
                        <td>
                            <div class="info-cell">
                                <i class="fas fa-map-marker-alt"></i>
                                <span>{{ $place->hangar->zone->nom_zone ?? '-' }}</span>
                            </div>
                        </td>
                        <td>
                            <div class="info-cell">
                                <i class="fas fa-shopping-cart"></i>
                                <span>{{ $place->hangar->zone->marche->nom ?? '-' }}</span>
                            </div>
                        </td>
                        <td>
                            @php
                                $status = $place->disponible ? 'disponible' : 'occupée';
                                $icon = $place->disponible ? 'fa-check-circle' : 'fa-times-circle';
                                $color = $place->disponible ? 'success' : 'danger';
                            @endphp
                            <span class="badge-status badge-{{ $color }}">
                                <i class="fas {{ $icon }}"></i>
                                {{ ucfirst($status) }}
                            </span>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('places.edit', $place->id) }}" class="btn-action btn-edit" title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('places.destroy', $place->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action btn-delete" 
                                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette place ?')"
                                            title="Supprimer">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Informations -->
        <div class="table-footer">
            <div class="table-info">
                <i class="fas fa-info-circle"></i>
                <span>Affichage de {{ $places->count() }} place(s)</span>
            </div>
        </div>
    @endif
</div>

<style>
.places-container { 
    max-width: 1400px; 
    margin: 30px auto; 
    padding: 0 20px;
}

/* En-tête */
.header { 
    display: flex; 
    justify-content: space-between; 
    align-items: center; 
    margin-bottom: 30px;
    padding-bottom: 15px;
    border-bottom: 2px solid #f0f0f0;
}
.header h2 { 
    color: #2c3e50; 
    font-size: 1.8rem;
    margin: 0;
}
.header h2 i { 
    color: #27ae60;
    margin-right: 10px;
}

/* Boutons */
.btn { 
    padding: 10px 18px; 
    border-radius: 6px; 
    text-decoration: none; 
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
}
.btn-primary { 
    background-color: #27ae60;
    color: white;
}
.btn-primary:hover { 
    background-color: #219653; 
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(39, 174, 96, 0.3);
}

/* Alertes */
.alert { 
    padding: 15px 20px; 
    border-radius: 8px; 
    margin-bottom: 25px;
    display: flex;
    align-items: center;
    gap: 10px;
}
.alert-success { 
    background-color: #d4edda; 
    color: #155724;
    border-left: 4px solid #28a745;
}

/* État vide */
.empty-state { 
    text-align: center; 
    padding: 60px 20px;
    background: #f8f9fa;
    border-radius: 12px;
    border: 2px dashed #dee2e6;
}
.empty-state i { 
    color: #adb5bd; 
    margin-bottom: 20px;
}
.empty-state h3 { 
    color: #6c757d; 
    margin-bottom: 10px;
}
.empty-state p { 
    color: #868e96; 
    margin-bottom: 25px;
}

/* Statistiques */
.stats { 
    display: grid; 
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); 
    gap: 20px;
    margin-bottom: 30px;
}
.stat-card { 
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 3px 10px rgba(0,0,0,0.08);
    display: flex;
    align-items: center;
    gap: 15px;
    border-left: 4px solid #27ae60;
}
.stat-card i { 
    font-size: 2rem; 
    color: #27ae60;
}
.stat-card h3 { 
    margin: 0; 
    font-size: 1.8rem; 
    color: #2c3e50;
}
.stat-card p { 
    margin: 0; 
    color: #7f8c8d; 
    font-size: 0.9rem;
}

/* Tableau */
.table-wrapper {
    background: white;
    border-radius: 12px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    overflow: hidden;
    border: 1px solid #eef2f7;
}
.styled-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.95rem;
}
.styled-table th {
    background-color: #f8f9fa;
    color: #2c3e50;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.85rem;
    padding: 18px 15px;
    border-bottom: 2px solid #dee2e6;
    text-align: left;
}
.styled-table td {
    padding: 16px 15px;
    border-bottom: 1px solid #f0f0f0;
    vertical-align: middle;
}
.styled-table tbody tr:hover {
    background-color: #f9f9f9;
}
.styled-table tbody tr:last-child td {
    border-bottom: none;
}

/* Cellules avec icônes */
.info-cell {
    display: flex;
    align-items: center;
    gap: 8px;
}
.info-cell i {
    color: #7f8c8d;
    font-size: 0.9rem;
}

/* Badges */
.badge-id {
    background: #f1f5f9;
    color: #475569;
    padding: 4px 10px;
    border-radius: 4px;
    font-size: 0.85rem;
    font-weight: 500;
}
.badge-type {
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 5px;
}
.badge-standard { 
    background: #dbeafe; 
    color: #1e40af; 
}
.badge-boutique { 
    background: #f3e8ff; 
    color: #6b21a8; 
}
.badge-status {
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 5px;
}
.badge-success { 
    background: #d1fae5; 
    color: #065f46; 
}
.badge-danger { 
    background: #fee2e2; 
    color: #991b1b; 
}

/* Numéro de place */
.place-number {
    display: flex;
    align-items: center;
    gap: 8px;
    font-weight: 600;
    color: #2c3e50;
}
.place-number i {
    color: #27ae60;
}

/* Boutons d'action */
.action-buttons {
    display: flex;
    gap: 8px;
}
.btn-action {
    width: 36px;
    height: 36px;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: none;
    cursor: pointer;
    transition: all 0.2s ease;
    color: white;
}
.btn-edit { background-color: #f59e0b; }
.btn-delete { background-color: #e74c3c; }
.btn-action:hover {
    transform: translateY(-2px);
    box-shadow: 0 3px 6px rgba(0,0,0,0.15);
}

/* Pied de tableau */
.table-footer {
    margin-top: 20px;
    display: flex;
    justify-content: center;
}
.table-info {
    background-color: #27ae60;
    color: white;
    padding: 12px 24px;
    border-radius: 8px;
    font-size: 0.95rem;
    display: flex;
    align-items: center;
    gap: 10px;
    box-shadow: 0 3px 8px rgba(39, 174, 96, 0.3);
}
.table-info i {
    color: white;
}
</style>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endsection