<!DOCTYPE html>
<html>
<head>
    <title>Rapport Agent {{ $agent->name }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #333; padding-bottom: 10px; }
        .title { font-size: 20px; font-weight: bold; }
        .subtitle { font-size: 14px; color: #666; }
        .table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        .table th, .table td { border: 1px solid #ddd; padding: 8px; }
        .table th { background-color: #f2f2f2; font-weight: bold; }
        .total-row { font-weight: bold; background-color: #e8f4f8; }
        .section { margin-bottom: 20px; }
        .stat-box { border: 1px solid #ccc; padding: 10px; margin: 5px; text-align: center; }
        .footer { margin-top: 30px; text-align: center; font-size: 10px; color: #888; }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">RAPPORT DES COLLECTES - AGENT</div>
        <div class="subtitle">{{ $agent->name }}</div>
        <div>Période du {{ \Carbon\Carbon::parse($dateDebut)->format('d/m/Y') }} au {{ \Carbon\Carbon::parse($dateFin)->format('d/m/Y') }}</div>
    </div>
    
    <div class="section">
        <h4>Informations de l'agent</h4>
        <p><strong>Nom :</strong> {{ $agent->name }}</p>
        <p><strong>Zone :</strong> {{ $agent->zone->nom_zone ?? 'Non assigné' }}</p>
        <p><strong>Marché :</strong> {{ $agent->zone->marche->nom ?? 'Non assigné' }}</p>
    </div>
    
    <div class="section">
        <h4>Statistiques générales</h4>
        <table class="table">
            <tr>
                <th>Total collecté</th>
                <th>Nombre de collectes</th>
                <th>Moyenne par collecte</th>
            </tr>
            <tr>
                <td>{{ number_format($stats['total_general'], 0, ',', ' ') }} FCFA</td>
                <td>{{ $stats['nombre_total'] }}</td>
                <td>{{ number_format($stats['total_general'] / max($stats['nombre_total'], 1), 0, ',', ' ') }} FCFA</td>
            </tr>
        </table>
    </div>
    
    <div class="section">
        <h4>Détail par type de collecte</h4>
        <table class="table">
            <thead>
                <tr>
                    <th>Type</th>
                    <th>Nombre</th>
                    <th>Montant total</th>
                    <th>Pourcentage</th>
                </tr>
            </thead>
            <tbody>
                @foreach($totauxParType as $type => $data)
                <tr>
                    <td>{{ $type }}</td>
                    <td>{{ $data['nombre'] }}</td>
                    <td>{{ number_format($data['montant'], 0, ',', ' ') }} FCFA</td>
                    <td>{{ $data['pourcentage'] }}%</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    @if($collectes->count() > 0)
    <div class="section">
        <h4>Liste détaillée des collectes</h4>
        <table class="table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Type</th>
                    <th>Montant</th>
                    <th>Place</th>
                    <th>Marché</th>
                </tr>
            </thead>
            <tbody>
                @foreach($collectes as $collecte)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($collecte->date_collecte)->format('d/m/Y') }}</td>
                    <td>{{ $collecte->type_collecte }}</td>
                    <td>{{ number_format($collecte->montant, 0, ',', ' ') }} FCFA</td>
                    <td>{{ $collecte->place->nom ?? 'N/A' }}</td>
                    <td>{{ $collecte->place->hangar->zone->marche->nom ?? 'N/A' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
    
    <div class="footer">
         Généré le {{ $dateGeneration }} | @CollectePlus 2025
    </div>
</body>
</html>