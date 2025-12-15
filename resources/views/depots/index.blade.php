@extends('layouts.app')

@section('content')
<div class="depots-container">
    <div class="header">
        <h1><i class="fas fa-piggy-bank"></i> Liste des dépôts</h1>
        <div class="header-actions">
            <button onclick="window.print()" class="btn btn-print">
                <i class="fas fa-print"></i> Imprimer
            </button>
        </div>
    </div>

    <!-- Filtres -->
    <div class="filter-card">
        <form method="GET" action="{{ route('depots.index') }}" class="filter-form">
            <div class="filter-group">
                <label><i class="fas fa-store"></i> Marché</label>
                <select name="marche_id">
                    <option value="">Tous les marchés</option>
                    @foreach($marches as $marche)
                        <option value="{{ $marche->id }}" {{ request('marche_id') == $marche->id ? 'selected' : '' }}>
                            {{ $marche->nom }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="filter-btn">
                <i class="fas fa-filter"></i> Filtrer
            </button>
        </form>
    </div>

    <!-- Tableau -->
    <div class="table-wrapper">
        <table class="depots-table">
            <thead>
                <tr>
                    <th><i class="fas fa-user-tie"></i> Agent</th>
                    <th><i class="fas fa-user-shield"></i> Régisseur</th>
                    <th><i class="fas fa-money-bill-wave"></i> Montant</th>
                    <th><i class="fas fa-calendar-day"></i> Date</th>
                    <th><i class="fas fa-store"></i> Marché</th>
                   
                </tr>
            </thead>
            <tbody>
                @foreach($depots as $depot)
                <tr>
                    <td class="agent-cell">
                        <i class="fas fa-user-circle"></i> {{ $depot->agent->name }}
                    </td>
                    <td class="regisseur-cell">
                        <i class="fas fa-user-check"></i> {{ $depot->regisseur->name }}
                    </td>
                    <td class="amount-cell">
                        <i class="fas fa-coins"></i> {{ number_format($depot->montant, 0, ',', ' ') }} FCFA
                    </td>
                    <td class="date-cell">
                        <i class="far fa-calendar"></i> {{ $depot->date_depot }}
                    </td>
                    <td class="marche-cell">
                        <i class="fas fa-map-marker-alt"></i> {{ $depot->agent->zone->marche->nom ?? 'N/A' }}
                    </td>
                    
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Infos -->
    <div class="footer-info">
        <div class="stats">
            <i class="fas fa-chart-bar"></i>
            {{ $depots->count() }} dépôt(s)
            @if(request('marche_id'))
                dans ce marché
            @endif
        </div>
    </div>
</div>

<style>
.depots-container { max-width: 1200px; margin: 30px auto; padding: 0 15px; }

/* Header */
.header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
.header h1 { color: #1f2937; font-size: 1.8rem; display: flex; align-items: center; gap: 10px; }
.header-actions { display: flex; gap: 10px; }
.btn { padding: 10px 20px; border-radius: 6px; text-decoration: none; font-weight: 600; 
    border: none; cursor: pointer; display: flex; align-items: center; gap: 8px; }
.btn-print { background: #6b7280; color: white; }
.btn:hover { opacity: 0.9; transform: translateY(-2px); }

/* Filtres */
.filter-card { background: white; padding: 20px; border-radius: 8px; margin-bottom: 25px; 
    box-shadow: 0 2px 8px rgba(0,0,0,0.05); }
.filter-form { display: flex; gap: 20px; align-items: flex-end; }
.filter-group { flex: 1; }
.filter-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #374151; 
    display: flex; align-items: center; gap: 8px; }
.filter-group select { width: 100%; padding: 10px; border: 1px solid #d1d5db; 
    border-radius: 6px; font-size: 1rem; }
.filter-btn { background: #3b82f6; color: white; padding: 10px 25px; height: 42px; }

/* Tableau */
.table-wrapper { overflow-x: auto; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
.depots-table { width: 100%; border-collapse: collapse; background: white; }
.depots-table thead { background: #368327; }
.depots-table th { padding: 16px 12px; text-align: left; color: white; font-weight: 600; 
    font-size: 0.9rem; }
.depots-table th i { margin-right: 8px; }
.depots-table td { padding: 14px 12px; border-bottom: 1px solid #f0f0f0; color: #374151; }
.depots-table tr:hover { background: #29702f; }
.depots-table tr:last-child td { border-bottom: none; }

/* Cellules */
.agent-cell, .regisseur-cell { font-weight: 600; }
.agent-cell i, .regisseur-cell i { color: #3b82f6; margin-right: 8px; }
.amount-cell { font-weight: 700; color: #10b981; }
.amount-cell i { margin-right: 8px; }
.date-cell i, .marche-cell i { margin-right: 8px; color: #6b7280; }

/* Reçu */
.receipt-cell .btn-receipt { 
    background: #3b82f6; color: white; padding: 6px 12px; border-radius: 6px; 
    text-decoration: none; font-size: 0.85rem; display: inline-flex; align-items: center; 
    gap: 6px; transition: all 0.3s; 
}
.btn-receipt:hover { background: #2563eb; transform: translateY(-2px); }
.no-receipt { color: #9ca3af; display: flex; align-items: center; gap: 6px; font-size: 0.9rem; }
.no-receipt i { color: #ef4444; }

/* Footer */
.footer-info { margin-top: 25px; padding-top: 20px; border-top: 1px solid #e5e7eb; }
.stats { text-align: center; color: #6b7280; display: flex; align-items: center; 
    justify-content: center; gap: 8px; font-weight: 600; }
.stats i { color: #10b981; }

/* Responsive */
@media (max-width: 768px) {
    .header { flex-direction: column; align-items: flex-start; gap: 15px; }
    .filter-form { flex-direction: column; align-items: stretch; }
    .filter-btn { width: 100%; }
    .depots-table th, .depots-table td { padding: 12px 8px; font-size: 0.9rem; }
    .depots-table th i, .depots-table td i { margin-right: 5px; }
}

/* Impression */
@media print {
    .header-actions, .filter-card { display: none; }
}
</style>
@endsection