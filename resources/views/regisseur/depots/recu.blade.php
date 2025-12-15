@section('title', 'Reçu du Dépôt')

@section('content')
<div class="container">
    <div class="card shadow-lg">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <h4><i class="fas fa-file-invoice"></i> Reçu de Dépôt</h4>
            <span class="badge bg-success">{{ $depot->numero_recu ?? 'N/A' }}</span>
        </div>
        <div class="card-body">
            <!-- Informations du dépôt -->
            <h5 class="mb-3"><i class="fas fa-info-circle"></i> Informations générales</h5>
            <ul class="list-group mb-4">
                
                <li class="list-group-item"><strong>Montant :</strong> {{ number_format($depot->montant, 0, ',', ' ') }} FCFA</li>
                <li class="list-group-item">
                    <strong>Date :</strong> 
                    {{ $depot->date_depot ?? $depot->created_at->format('d/m/Y H:i') }}
                </li>
                <li class="list-group-item"><strong>Observations :</strong> {{ $depot->observations ?? 'Aucune' }}</li>
            </ul>

            <!-- Informations de l'agent -->
            <h5 class="mb-3"><i class="fas fa-user"></i> Agent Déposant</h5>
            <ul class="list-group mb-4">
                <li class="list-group-item"><strong>Nom :</strong> {{ $depot->agent->name ?? 'Non défini' }}</li>
                <li class="list-group-item"><strong>Email :</strong> {{ $depot->agent->email ?? 'Non défini' }}</li>
                <li class="list-group-item"><strong>Zone :</strong> {{ $depot->agent->zone->nom_zone ?? 'Non définie' }}</li>
                <li class="list-group-item"><strong>Marché :</strong> {{ $depot->agent->zone->marche->nom ?? 'Non défini' }}</li>
            </ul>

            <!-- Informations du régisseur -->
            <h5 class="mb-3"><i class="fas fa-user-shield"></i> Régisseur</h5>
            <ul class="list-group mb-4">
                <li class="list-group-item"><strong>Nom :</strong> {{ $depot->regisseur->name ?? 'Non défini' }}</li>
               

            <!-- Zones de signature -->
            <div class="signature-section d-flex justify-content-between mt-5">
                <div class="signature-box">
                    <p><strong>Signature de l'Agent :</strong></p>
                    <div class="signature-line"></div>
                </div>
                <div class="signature-box">
                    <p><strong>Signature du Régisseur :</strong></p>
                    <div class="signature-line"></div>
                </div>
            </div>
        </div>
        <div class="card-footer text-center">
            <button onclick="window.print()" class="btn btn-primary">
                <i class="fas fa-print"></i> Imprimer le reçu
            </button>
        </div>
    </div>
</div>

<style>
/* Reset and base typography */
*,
*::before,
*::after {
  box-sizing: border-box;
}
html, body {
  margin: 0;
  padding: 0;
  font-family: "Inter", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen, Ubuntu, Cantarell, "Fira Sans", "Droid Sans", "Helvetica Neue", Arial, sans-serif;
  color: #1f2937;
  background: #f3f4f6;
  line-height: 1.5;
}

/* Layout container */
.container {
  max-width: 980px;
  margin: 32px auto;
  padding: 0 16px;
}

/* Card */
.card {
  background: #ffffff;
  border: 1px solid #e5e7eb;
  border-radius: 12px;
  box-shadow: 0 10px 25px rgba(0,0,0,0.08);
  overflow: hidden;
}
.card-header,
.card-footer {
  padding: 16px 20px;
}
.card-header {
  background: #111827;
  color: #ffffff;
  display: flex;
  align-items: center;
  justify-content: space-between;
}
.card-header h4 {
  margin: 0;
  font-size: 18px;
  font-weight: 600;
  display: inline-flex;
  align-items: center;
  gap: 10px;
}
.card-body {
  padding: 20px;
}

/* Badge */
.badge {
  display: inline-block;
  padding: 6px 10px;
  border-radius: 999px;
  font-size: 12px;
  font-weight: 600;
}
.bg-success {
  background: #10b981;
  color: #ffffff;
}

/* Section titles */
.card-body h5 {
  margin: 16px 0 12px;
  font-size: 16px;
  font-weight: 600;
  color: #111827;
  display: inline-flex;
  align-items: center;
  gap: 8px;
}

/* List group */
.list-group {
  list-style: none;
  margin: 0 0 16px;
  padding: 0;
  border: 1px solid #e5e7eb;
  border-radius: 10px;
  overflow: hidden;
}
.list-group-item {
  padding: 12px 14px;
  border-bottom: 1px solid #e5e7eb;
  background: #ffffff;
  display: flex;
  gap: 8px;
}
.list-group-item:last-child {
  border-bottom: none;
}
.list-group-item strong {
  min-width: 180px;
  color: #374151;
  font-weight: 600;
}

/* Signature section */
.signature-section {
  display: flex;
  justify-content: space-between;
  gap: 40px;
}
.signature-box {
  flex: 1;
}
.signature-line {
  border-bottom: 2px solid #111827;
  height: 80px;
  margin-top: 10px;
}

/* Button */
.btn {
  border: none;
  border-radius: 10px;
  padding: 10px 16px;
  font-size: 14px;
  font-weight: 600;
  cursor: pointer;
  display: inline-flex;
  align-items: center;
  gap: 8px;
}
.btn-primary {
  background: #2563eb;
  color: #ffffff;
}
.btn-primary:hover {
  background: #1d4ed8;
}

/* Print styles */
@media print {
  .btn { display: none !important; }
  .card { box-shadow: none; border: none; }
  .card-header { background: #ffffff; color: #111827; border-bottom: 2px solid #111827; }
}
</style>
