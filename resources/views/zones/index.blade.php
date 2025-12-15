@extends('layouts.app')

@section('title', 'Zones de collecte')

@section('content')
<div class="zones-container">
    <!-- En-tête avec titre et bouton -->
    <div class="header">
        <h2><i class="fas fa-map-marked-alt"></i> Zones de collecte</h2>
        <a href="{{ route('zones.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle"></i> Nouvelle zone
        </a>
    </div>

    <!-- Messages de succès -->
    @if (session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <!-- Si aucune zone -->
    @if($zones->isEmpty())
        <div class="empty-state">
            <i class="fas fa-map fa-3x"></i>
            <h3>Aucune zone enregistrée</h3>
            <p>Commencez par créer votre première zone de collecte.</p>
            <a href="{{ route('zones.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Créer une zone
            </a>
        </div>
    @else
        <!-- Statistiques -->
        <div class="stats">
            <div class="stat-card">
                <i class="fas fa-layer-group"></i>
                <div>
                    <h3>{{ $zones->count() }}</h3>
                    <p>Zones totales</p>
                </div>
            </div>
            <div class="stat-card">
                <i class="fas fa-users"></i>
                <div>
                    <h3>{{ $zones->whereNotNull('agent_id')->count() }}</h3>
                    <p>Zones assignées</p>
                </div>
            </div>
        </div>

        <!-- Liste des zones en grille -->
        <div class="grid">
            @foreach ($zones as $zone)
                <div class="card">
                    <div class="card-header">
                        <h3><i class="fas fa-map-pin"></i> {{ $zone->nom_zone }}</h3>
                        <span class="badge {{ $zone->agent_id ? 'badge-success' : 'badge-warning' }}">
                            {{ $zone->agent_id ? 'Assignée' : 'Non assignée' }}
                        </span>
                    </div>
                    
                    <div class="card-body">
                        <div class="info-item">
                            <i class="fas fa-store"></i>
                            <div>
                                <small>Marché</small>
                                <p>{{ $zone->marche->nom ?? 'Non défini' }}</p>
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <i class="fas fa-user-tie"></i>
                            <div>
                                <small>Agent responsable</small>
                                <p>{{ $zone->agent->name ?? 'Non affecté' }}</p>
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <i class="fas fa-calendar-alt"></i>
                            <div>
                                <small>Créée le</small>
                                <p>{{ $zone->created_at->format('d/m/Y à H:i') }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-footer">
                        <div class="actions">
                            <a href="{{ route('zones.edit', $zone->id) }}" class="btn btn-warning">
                                <i class="fas fa-edit"></i> Modifier
                            </a>
                            <form action="{{ route('zones.destroy', $zone->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette zone ?')">
                                    <i class="fas fa-trash"></i> Supprimer
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Pied de page avec informations -->
        <div class="footer-info">
            <i class="fas fa-info-circle"></i>
            <span>Affichage de {{ $zones->count() }} zone(s)</span>
        </div>
    @endif
</div>

<style>
.zones-container { 
    max-width: 1300px; 
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
    color:  #389b51; 
    font-size: 1.8rem;
    margin: 0;
}
.header h2 i { 
    color: #389b51; 
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
    background-color:  #389b51; 
    color: white;
}
.btn-primary:hover { 
    background-color:  #389b51; 
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(52, 152, 219, 0.3);
}
.btn-warning { 
    background-color: #f39c12; 
    color: white;
}
.btn-danger { 
    background-color: #e74c3c; 
    color: white;
}
.btn-warning:hover, .btn-danger:hover { 
    opacity: 0.9;
    transform: translateY(-1px);
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
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); 
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
    border-left: 4px solid  #389b51;
}
.stat-card i { 
    font-size: 2rem; 
    color:  #389b51;
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

/* Grille de cartes */
.grid { 
    display: grid; 
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); 
    gap: 25px;
}

/* Carte individuelle */
.card { 
    background: white;
    border-radius: 12px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border: 1px solid #eef2f7;
}
.card:hover { 
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}
.card-header { 
    padding: 20px 20px 15px;
    border-bottom: 1px solid #f0f0f0;
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
}
.card-header h3 { 
    margin: 0; 
    font-size: 1.3rem;
    color: #2c3e50;
    display: flex;
    align-items: center;
    gap: 8px;
}
.card-header h3 i { 
    color: #e74c3c;
}
.badge { 
    padding: 4px 10px; 
    border-radius: 20px; 
    font-size: 0.75rem;
    font-weight: 600;
}
.badge-success { background: #d4edda; color: #155724; }
.badge-warning { background: #fff3cd; color: #856404; }

.card-body { 
    padding: 20px;
}
.info-item { 
    display: flex; 
    gap: 12px; 
    margin-bottom: 15px;
    align-items: flex-start;
}
.info-item i { 
    color: #3498db; 
    margin-top: 3px;
    font-size: 1rem;
}
.info-item small { 
    display: block; 
    color: #7f8c8d; 
    font-size: 0.8rem;
}
.info-item p { 
    margin: 3px 0 0; 
    color: #2c3e50;
    font-weight: 500;
}

.card-footer { 
    padding: 15px 20px; 
    background: #f8f9fa;
    border-top: 1px solid #eef2f7;
}
.actions { 
    display: flex; 
    gap: 10px;
}

/* Pied de page */
.footer-info { 
    margin-top: 30px; 
    text-align: center; 
    color: #7f8c8d; 
    font-size: 0.9rem;
    padding: 15px;
    background: #f8f9fa;
    border-radius: 8px;
}
.footer-info i { 
    margin-right: 8px;
    color:  #389b51;
}
</style>

<!-- Font Awesome (à ajouter dans layouts/app.blade.php si pas déjà présent) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endsection