@section('content')
<div class="receipt-container">
    <div class="receipt" id="receipt">
        <div class="receipt-header">
            <div class="receipt-title">REÇU DE COLLECTE</div>
            <div class="receipt-number">N°{{ str_pad($collecte->id, 6, '0', STR_PAD_LEFT) }}</div>
        </div>
        
        <div class="receipt-body">
            <div class="info-row">
                <span class="label">Date:</span>
                <span class="value">{{ date('d/m/Y', strtotime($collecte->date_collecte)) }}</span>
            </div>
            <div class="info-row">
                <span class="label">Heure:</span>
                <span class="value">{{ date('H:i', strtotime($collecte->created_at)) }}</span>
            </div>
            <div class="info-row">
                <span class="label">Numéro place:</span>
                <span class="value">{{ $collecte->place->numero_place ?? 'N/A' }}</span>
            </div>
            <div class="info-row">
                <span class="label">Type:</span>
                <span class="value">{{ ucfirst($collecte->type_collecte) }}</span>
            </div>
            <div class="info-row">
                <span class="label">Marché:</span>
                <span class="value">{{ $collecte->place->hangar->zone->marche->nom ?? 'N/A' }}</span>
            </div>
            <div class="info-row">
                <span class="label">Zone:</span>
                <span class="value">{{ $collecte->place->hangar->zone->nom_zone ?? 'N/A' }}</span>
            </div>
            <div class="info-row">
                <span class="label">Agent:</span>
                <span class="value">{{ $collecte->agent->name ?? 'N/A' }}</span>
            </div>
            
            <div class="amount-section">
                <div class="amount-label">MONTANT</div>
                <div class="amount-value">{{ number_format($collecte->montant, 0, ',', ' ') }} FCFA</div>
            </div>
        </div>
        
        <div class="receipt-footer">
            <div class="signature-line"></div>
            <div class="signature-text">Signature de l'agent</div>
            <div class="thank-you">Merci pour votre confiance</div>
        </div>
    </div>
    
    <div class="actions">
        <button onclick="window.print()" class="btn-print">Imprimer</button>
        <a href="{{ route('agent.index') }}" class="btn-new">Nouvelle collecte</a>
    </div>
</div>

<style>
.receipt-container { max-width: 400px; margin: 20px auto; padding: 20px; }
.receipt { background: white; border: 2px solid #10b981; padding: 25px; font-family: 'Courier New', monospace; }
.receipt-header { text-align: center; margin-bottom: 20px; border-bottom: 2px dashed #10b981; padding-bottom: 15px; }
.receipt-title { font-size: 20px; font-weight: bold; color: #064e3b; margin-bottom: 5px; }
.receipt-number { color: #6b7280; font-size: 14px; }
.receipt-body { margin: 20px 0; }
.info-row { display: flex; justify-content: space-between; margin-bottom: 8px; padding-bottom: 8px; 
    border-bottom: 1px dashed #e5e7eb; }
.label { font-weight: bold; color: #374151; }
.value { color: #1f2937; }
.amount-section { margin-top: 25px; padding-top: 15px; border-top: 3px solid #10b981; text-align: center; }
.amount-label { font-size: 14px; color: #6b7280; margin-bottom: 5px; }
.amount-value { font-size: 28px; font-weight: bold; color: #064e3b; }
.receipt-footer { margin-top: 30px; text-align: center; }
.signature-line { width: 180px; height: 1px; background: #000; margin: 20px auto 10px; }
.signature-text { font-size: 12px; color: #6b7280; margin-bottom: 20px; }
.thank-you { font-style: italic; color: #10b981; }
.actions { display: flex; gap: 15px; margin-top: 25px; justify-content: center; }
.btn-print, .btn-new { padding: 10px 25px; border: none; border-radius: 6px; text-decoration: none; 
    font-weight: 600; cursor: pointer; }
.btn-print { background: #1f2937; color: white; }
.btn-new { background: #10b981; color: white; }
@media print {
    .actions { display: none; }
    .receipt-container { margin: 0; padding: 0; }
    .receipt { border: 1px solid #000; }
}
</style>
