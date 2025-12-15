@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="title"><i class="fas fa-warehouse"></i> Liste des hangars</h2>

    <!-- Filtre et bouton d'action -->
    <div class="header-actions">
        <form method="GET" action="{{ route('hangars.index') }}" class="filter-form">
            <select name="marche_id" onchange="this.form.submit()">
                <option value="">Tous les marchés</option>
                @foreach($marches as $marche)
                    <option value="{{ $marche->id }}" {{ request('marche_id') == $marche->id ? 'selected' : '' }}>
                        {{ $marche->nom }}
                    </option>
                @endforeach
            </select>
        </form>
        
        <a href="{{ route('hangars.create') }}" class="btn btn-success">
            <i class="fas fa-plus"></i> Nouveau hangar
        </a>
    </div>

    @if($hangars->isEmpty())
        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i> Aucun hangar trouvé.
            <a href="{{ route('hangars.create') }}">Créer le premier</a>
        </div>
    @else
        <table class="styled-table">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Zone</th>
                    <th>Marché</th>
                    <th>Type</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($hangars as $hangar)
                    <tr>
                        <td><strong>{{ $hangar->code }}</strong></td>
                        <td>{{ $hangar->zone->nom_zone ?? 'N/A' }}</td>
                        <td>{{ $hangar->zone->marche->nom ?? 'N/A' }}</td>
                        <td><span class="type-badge">{{ ucfirst($hangar->type) }}</span></td>
                        <td class="action-buttons">
                            <a href="{{ route('hangars.edit', $hangar->id) }}" class="btn btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('hangars.destroy', $hangar->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Supprimer ce hangar ?')">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
        <div class="table-info">
            <i class="fas fa-list"></i> 
            <strong>{{ $hangars->count() }}</strong> hangar(s)
            @if(request('marche_id'))
                dans ce marché
            @endif
        </div>
    @endif
</div>

<style>
.container { max-width: 1100px; margin: 25px auto; padding: 0 15px; }
.title { text-align: center; margin-bottom: 25px; color: #2c3e50; font-size: 1.8rem; }
.title i { margin-right: 10px; color: #3498db; }

.header-actions {
    display: flex; justify-content: space-between; align-items: center;
    margin-bottom: 25px; flex-wrap: wrap; gap: 15px;
}
.filter-form select {
    padding: 10px 15px; border: 1px solid #ddd; border-radius: 6px;
    min-width: 220px; background: white; font-size: 0.95rem;
}
.filter-form select:focus { outline: none; border-color: #3498db; }

.btn { 
    padding: 10px 18px; border-radius: 6px; text-decoration: none; 
    color: white; border: none; font-size: 0.95rem; cursor: pointer;
    transition: all 0.3s; display: inline-flex; align-items: center; gap: 8px;
}
.btn-success { background: #27ae60; }
.btn-warning { background: #f39c12; }
.btn-danger { background: #e74c3c; }
.btn:hover { opacity: 0.9; transform: translateY(-2px); }

.alert { 
    padding: 15px; border-radius: 6px; margin-bottom: 25px;
    background: #e8f6f3; color: #0c5460; border-left: 4px solid #27ae60;
}
.alert a { color: #1d8348; font-weight: 600; }
.alert i { margin-right: 8px; }

.styled-table { 
    width: 100%; border-collapse: collapse; background: white;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05); border-radius: 8px; overflow: hidden;
}
.styled-table th { 
    background: #2c3e50; color: white; font-weight: 600;
    padding: 16px 12px; text-align: center; font-size: 0.9rem;
}
.styled-table td { 
    padding: 14px 12px; border-bottom: 1px solid #f0f0f0;
    text-align: center; color: #333;
}
.styled-table tr:hover { background: #f8f9fa; }
.styled-table tr:last-child td { border-bottom: none; }

.type-badge {
    background: #e8f6f3; color: #27ae60; padding: 5px 12px;
    border-radius: 20px; font-size: 0.85rem; font-weight: 600;
}

.action-buttons { 
    display: flex; gap: 8px; justify-content: center; 
}
.action-buttons .btn { padding: 8px 12px; font-size: 0.85rem; }

.table-info {
    margin-top: 20px; text-align: right; color: #7f8c8d;
    font-size: 0.9rem; padding: 10px 0; border-top: 1px solid #eee;
}
.table-info i { margin-right: 8px; color: #3498db; }

@media (max-width: 768px) {
    .header-actions { flex-direction: column; align-items: flex-start; }
    .filter-form select { min-width: 100%; }
    .styled-table { font-size: 0.9rem; }
    .action-buttons { flex-wrap: wrap; }
}
</style>
@endsection