@section('content')
<div class="container">
    <div class="page-header">
        <h2>Mes collectes du {{ $today }}</h2>
        <a href="{{ route('agent.index') }}" class="btn-new">Nouvelle collecte</a>
    </div>
    <div class="print-header">
        <button onclick="window.print()" class="btn-print">
            <span class="print-icon">🖨️</span> Imprimer la liste
        </button>
    </div>
    
    <div class="agent-summary">
        <div class="agent-name">{{ $agent->name }}</div>
        <div class="collecte-count">{{ $collectes->count() }} collecte(s)</div>
    </div>

    @if($collectes->count() > 0)
        <div class="table-container">
            <table class="collectes-table">
                <thead>
                    <tr>
                        <th>Place</th>
                        <th>Type</th>
                        <th>Montant</th>
                        <th>Zone</th>
                        <th>Marché</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($collectes as $collecte)
                        <tr>
                            <td class="place-code">{{ $collecte->place->numero_place }}</td>
                            <td><span class="type-badge type-{{ $collecte->type_collecte }}">{{ ucfirst($collecte->type_collecte) }}</span></td>
                            <td class="montant">{{ number_format($collecte->montant, 0, ',', ' ') }} FCFA</td>
                            <td>{{ $collecte->place->hangar->zone->nom ?? 'N/A' }}</td>
                            <td>{{ $collecte->place->hangar->zone->marche->nom ?? 'N/A' }}</td>
                            <td>
                                <a href="{{ route('agent.recu', $collecte->id) }}" class="btn-receipt">
                                    <span class="receipt-icon">🧾</span> Reçu
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="total-summary">
            <div class="total-label">TOTAL DU JOUR</div>
            <div class="total-amount">{{ number_format($collectes->sum('montant'), 0, ',', ' ') }} FCFA</div>
        </div>
    @else
        <div class="empty-state">
            <div class="empty-icon">📭</div>
            <h3>Aucune collecte enregistrée aujourd'hui</h3>
            <p>Commencez par enregistrer votre première collecte de la journée</p>
            <a href="{{ route('agent.index') }}" class="btn-primary">Faire une collecte</a>
        </div>
    @endif
</div>

<style>
.container { max-width: 1200px; margin: 25px auto; padding: 0 15px; }
.page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
.page-header h2 { color: #064e3b; font-size: 1.8rem; margin: 0; }
.btn-new { background: #10b981; color: white; padding: 8px 20px; border-radius: 6px; 
    text-decoration: none; font-weight: 600; transition: all 0.3s; }
.btn-new:hover { background: #059669; transform: translateY(-2px); }

.agent-summary { 
    background: #f0fdf4; border-left: 4px solid #10b981; padding: 15px; 
    border-radius: 8px; margin-bottom: 25px; display: flex; justify-content: space-between;
    align-items: center; 
}
.agent-name { font-weight: 600; color: #064e3b; font-size: 1.1rem; }
.collecte-count { background: #10b981; color: white; padding: 5px 15px; border-radius: 20px; 
    font-size: 0.9rem; font-weight: 600; }

.table-container { overflow-x: auto; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
.collectes-table { width: 100%; border-collapse: collapse; background: white; }
.collectes-table thead { background: #064e3b; }
.collectes-table th { 
    padding: 16px 12px; text-align: left; color: white; font-weight: 600; 
    font-size: 0.9rem; text-transform: uppercase; 
}
.collectes-table td { 
    padding: 14px 12px; border-bottom: 1px solid #f0f0f0; color: #374151; 
}
.collectes-table tr:hover { background: #f9f9f9; }
.collectes-table tr:last-child td { border-bottom: none; }

.place-code { font-weight: 600; color: #1f2937; }
.montant { font-weight: 700; color: #10b981; font-size: 1.1rem; }

.type-badge { 
    padding: 5px 12px; border-radius: 20px; font-size: 0.85rem; font-weight: 600; 
    display: inline-block; 
}
.type-journalier { background: #d1fae5; color: #065f46; }
.type-loyer { background: #fef3c7; color: #92400e; }
.type-mensuel { background: #dbeafe; color: #3730a3; }
.type-taxe { background: #fce7f3; color: #9d174d; }
.type-amende { background: #fee2e2; color: #991b1b; }

.btn-receipt { 
    background: #3b82f6; color: white; padding: 6px 12px; border-radius: 6px; 
    text-decoration: none; font-size: 0.85rem; display: inline-flex; align-items: center; 
    gap: 6px; transition: all 0.3s; 
}
.btn-receipt:hover { background: #2563eb; transform: translateY(-2px); }
.receipt-icon { font-size: 1rem; }

.total-summary { 
    background: #064e3b; color: white; padding: 20px; border-radius: 8px; 
    margin-top: 25px; display: flex; justify-content: space-between; align-items: center; 
}
.total-label { font-size: 1rem; opacity: 0.9; }
.total-amount { font-size: 1.8rem; font-weight: 700; }

.empty-state { 
    text-align: center; padding: 60px 20px; background: #f9fafb; border-radius: 8px;
    margin-top: 30px; 
}
.empty-icon { font-size: 3rem; margin-bottom: 20px; }
.empty-state h3 { color: #1f2937; margin-bottom: 10px; }
.empty-state p { color: #6b7280; margin-bottom: 25px; }
.btn-primary { 
    background: #10b981; color: white; padding: 12px 30px; border-radius: 6px; 
    text-decoration: none; font-weight: 600; display: inline-block; 
}
.btn-primary:hover { background: #059669; }
.print-header {
    text-align: right;
    margin-bottom: 20px;
}

.btn-print {
    background: #6b7280;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 6px;
    font-weight: 600;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.3s;
}

.btn-print:hover {
    background: #4b5563;
    transform: translateY(-2px);
}

.print-icon {
    font-size: 1.1rem;
}

@media print {
    .print-header, .btn-new, .btn-print, .btn-receipt {
        display: none;
    }
}

@media (max-width: 768px) {
    .page-header { flex-direction: column; align-items: flex-start; gap: 15px; }
    .agent-summary { flex-direction: column; align-items: flex-start; gap: 10px; }
    .collectes-table th, .collectes-table td { padding: 12px 8px; font-size: 0.9rem; }
    .total-summary { flex-direction: column; gap: 10px; text-align: center; }
}
</style>
