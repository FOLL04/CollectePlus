@extends('layouts.app')

@section('content')
<div class="collectes-container">
    <div class="header">
        <h1><span class="icon"></span> Liste des collectes </h1>
        <div class="header-actions">
            <button onclick="window.print()" class="btn btn-print">
                <span class="btn-icon">🖨️</span> Imprimer
            </button>
            <a href="{{ route('collectes.pdf', request()->query()) }}" class="btn btn-pdf">
                <span class="btn-icon">📄</span> PDF
            </a>
        </div>
    </div>

    <!-- Filtres -->
    <div class="filter-card">
        <form method="GET" action="{{ route('collectes.index') }}" class="filter-form">
            <div class="filter-group">
                <label><span class="label-icon">👤</span> Agent</label>
                <select name="agent_id">
                    <option value="">Tous les agents</option>
                    @foreach($agents as $agent)
                        <option value="{{ $agent->id }}" {{ $agentId == $agent->id ? 'selected' : '' }}>
                            {{ $agent->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="filter-group">
                <label><span class="label-icon">📅</span> Jour et mois</label>
                <input type="days" name="jour" value="{{ $mois }}">
            </div>
            
            <button type="submit" class="filter-btn">
                <span class="btn-icon">🔍</span> Filtrer
            </button>
        </form>
    </div>

    <!-- Tableau -->
    <div class="table-wrapper">
        <table class="collectes-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Agent</th>
                    <th>Type</th>
                    <th>Montant</th>
                    <th>Date</th>
                    <th>Heure</th>
                    <th>Reçu</th>
                </tr>
            </thead>
            <tbody>
                @forelse($collectes as $collecte)
                <tr>
                    <td class="id-cell">{{ $collecte->id }}</td>
                    <td class="agent-cell">{{ $collecte->agent->name ?? 'N/A' }}</td>
                    <td><span class="type-badge">{{ ucfirst($collecte->type_collecte) }}</span></td>
                    <td class="amount-cell"> {{ number_format($collecte->montant, 0, ',', ' ') }} FCFA</td>
                    <td class="date-cell"> {{ date('d/m/Y', strtotime($collecte->date_collecte)) }}</td>
                    <td class="time-cell"> {{ date('H:i', strtotime($collecte->created_at)) }}</td>
                    <td class="receipt-cell"> {{ $collecte->numero_recu }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="empty-state">
                        <div class="empty-icon">📭</div>
                        <div class="empty-text">Aucune collecte trouvée</div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination et infos -->
    @if($collectes->hasPages())
    <div class="footer-info">
        <div class="stats">
            <span class="stat-icon">📊</span>
            Affichage de {{ $collectes->firstItem() ?? 0 }} à {{ $collectes->lastItem() ?? 0 }}
            sur {{ $collectes->total() }} collectes
        </div>
        <div class="pagination">
            {{ $collectes->links() }}
        </div>
    </div>
    @endif
</div>

<style>
.collectes-container { max-width: 1300px; margin: 30px auto; padding: 0 15px; }

/* Header */
.header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
.header h1 { color: #1f2937; font-size: 1.8rem; display: flex; align-items: center; gap: 10px; }
.header-actions { display: flex; gap: 10px; }
.btn { padding: 10px 20px; border-radius: 6px; text-decoration: none; font-weight: 600; 
    border: none; cursor: pointer; display: flex; align-items: center; gap: 8px; }
.btn-print { background: #6b7280; color: white; }
.btn-pdf { background: #ef4444; color: white; }
.btn:hover { opacity: 0.9; transform: translateY(-2px); }

/* Filtres */
.filter-card { background: white; padding: 20px; border-radius: 8px; margin-bottom: 25px; 
    box-shadow: 0 2px 8px rgba(0,0,0,0.05); }
.filter-form { display: flex; gap: 20px; align-items: flex-end; flex-wrap: wrap; }
.filter-group { flex: 1; min-width: 200px; }
.filter-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #374151; 
    display: flex; align-items: center; gap: 5px; }
.filter-group select, .filter-group input { width: 100%; padding: 10px; border: 1px solid #d1d5db; 
    border-radius: 6px; font-size: 1rem; }
.filter-btn { background: #3b82f6; color: white; padding: 10px 25px; height: 42px; }

/* Tableau */
.table-wrapper { overflow-x: auto; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
.collectes-table { width: 100%; border-collapse: collapse; background: white; }
.collectes-table thead { background: #55a327; }
.collectes-table th { padding: 16px 12px; text-align: left; color: white; font-weight: 600; 
    font-size: 0.9rem; }
.collectes-table td { padding: 14px 12px; border-bottom: 1px solid #f0f0f0; color: #374151; }
.collectes-table tr:hover { background: #428b11; }
.collectes-table tr:last-child td { border-bottom: none; }

/* Cellules spéciales */
.id-cell { font-weight: 600; color: #6b7280; }
.amount-cell { font-weight: 700; color: #10b981; }
.date-cell, .time-cell { color: #6b7280; font-size: 0.9rem; }
.agent-cell { font-weight: 600; }
.receipt-cell { font-family: monospace; color: #3b82f6; }

/* Badge type */
.type-badge { background: #e5e7eb; padding: 4px 12px; border-radius: 20px; font-size: 0.85rem; }

/* État vide */
.empty-state { text-align: center; padding: 40px; }
.empty-icon { font-size: 3rem; margin-bottom: 10px; opacity: 0.5; }
.empty-text { color: #6b7280; font-size: 1.1rem; }

/* Footer */
.footer-info { margin-top: 25px; padding-top: 20px; border-top: 1px solid #e5e7eb; }
.stats { text-align: center; color: #6b7280; margin-bottom: 15px; display: flex; 
    align-items: center; justify-content: center; gap: 8px; }
.pagination { display: flex; justify-content: center; }

/* Responsive */
@media (max-width: 768px) {
    .header { flex-direction: column; align-items: flex-start; gap: 15px; }
    .filter-form { flex-direction: column; align-items: stretch; }
    .filter-group { min-width: 100%; }
    .filter-btn { width: 100%; }
    .collectes-table th, .collectes-table td { padding: 12px 8px; font-size: 0.9rem; }
}

/* Impression */
@media print {
    .header-actions, .filter-card { display: none; }
    .collectes-table th { background: #000; color: #fff; }
}
</style>
@endsection