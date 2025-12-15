<!DOCTYPE html>
<html>
<head>
    <title>Rapport {{ $marche ? $marche->nom : 'Tous les Marchés' }}</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            font-size: 12px; 
            margin: 0;
            padding: 15px;
            color: #333;
        }
        .header { 
            text-align: center; 
            margin-bottom: 20px; 
            border-bottom: 3px solid #16a34a; 
            padding-bottom: 15px;
        }
        .title { 
            font-size: 22px; 
            font-weight: bold;
            color: #111827;
            margin-bottom: 5px;
        }
        .subtitle { 
            font-size: 16px; 
            color: #6b7280;
            margin-bottom: 10px;
        }
        .table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-bottom: 20px;
        }
        .table th, .table td { 
            border: 1px solid #d1d5db; 
            padding: 10px; 
            text-align: left;
            font-size: 11px;
        }
        .table th { 
            background-color: #f3f4f6; 
            font-weight: bold;
            color: #111827;
        }
        .table tr:nth-child(even) {
            background-color: #f9fafb;
        }
        .section { 
            margin-bottom: 25px;
        }
        .section h4 {
            background-color: #16a34a;
            color: white;
            padding: 8px 12px;
            margin: 0 0 12px 0;
            font-size: 14px;
            border-radius: 4px;
        }
        .footer { 
            margin-top: 40px; 
            text-align: center; 
            font-size: 10px; 
            color: #9ca3af;
            border-top: 1px solid #e5e7eb;
            padding-top: 15px;
        }
        .highlight {
            background-color: #dcfce7;
            font-weight: bold;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">RAPPORT {{ $marche ? 'DU MARCHÉ' : 'TOUS LES MARCHÉS' }}</div>
        <div class="subtitle">{{ $marche ? $marche->nom : 'Vue globale de tous les marchés' }}</div>
        <div style="font-size: 13px; margin-top: 5px;">
            Période du <strong>{{ \Carbon\Carbon::parse($dateDebut)->format('d/m/Y') }}</strong> 
            au <strong>{{ \Carbon\Carbon::parse($dateFin)->format('d/m/Y') }}</strong>
        </div>
    </div>

    <!-- Informations marché (seulement si $marche existe) -->
    @if($marche)
    <div class="section">
        <h4>📋 Informations du marché</h4>
        <table class="table">
            <tr>
                <th>Nom du marché</th>
                <td>{{ $marche->nom }}</td>
            </tr>
            @if($marche->description)
            <tr>
                <th>Description</th>
                <td>{{ $marche->description }}</td>
            </tr>
            @endif
        </table>
    </div>
    @endif

    <!-- Statistiques générales -->
    <div class="section">
        <h4>📊 Statistiques générales</h4>
        <table class="table">
            <thead>
                <tr>
                    <th>Total collectes</th>
                    <th>Total montant</th>
                    <th>Moyenne par collecte</th>
                    <th>Nombre d'agents</th>
                    <th>Nombre de zones</th>
                </tr>
            </thead>
            <tbody>
                <tr class="highlight">
                    <td class="text-center">{{ $statistiques['total_collectes'] }}</td>
                    <td class="text-right">{{ number_format($statistiques['total_montant'], 0, ',', ' ') }} FCFA</td>
                    <td class="text-right">{{ number_format($statistiques['moyenne_par_collecte'], 0, ',', ' ') }} FCFA</td>
                    <td class="text-center">{{ $statistiques['nombre_agents'] }}</td>
                    <td class="text-center">{{ $statistiques['nombre_zones'] }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Collectes par zone -->
    @if(!empty($collectesParZone))
    <div class="section">
        <h4>📍 Collectes par zone</h4>
        <table class="table">
            <thead>
                <tr>
                    <th>Zone</th>
                    <th class="text-right">Montant</th>
                    <th class="text-center">Nombre</th>
                    <th>Agents</th>
                </tr>
            </thead>
            <tbody>
                @foreach($collectesParZone as $zone => $info)
                <tr>
                    <td>{{ $zone }}</td>
                    <td class="text-right">{{ number_format($info['montant'], 0, ',', ' ') }} FCFA</td>
                    <td class="text-center">{{ $info['nombre'] }}</td>
                    <td>{{ $info['agents'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    <!-- Collectes par type -->
    @if(!empty($collectesParType))
    <div class="section">
        <h4>🏷️ Collectes par type</h4>
        <table class="table">
            <thead>
                <tr>
                    <th>Type</th>
                    <th class="text-right">Montant</th>
                    <th class="text-center">Nombre</th>
                    <th class="text-center">%</th>
                </tr>
            </thead>
            <tbody>
                @foreach($collectesParType as $type => $info)
                <tr>
                    <td>{{ ucfirst($type) }}</td>
                    <td class="text-right">{{ number_format($info['montant'], 0, ',', ' ') }} FCFA</td>
                    <td class="text-center">{{ $info['nombre'] }}</td>
                    <td class="text-center">{{ number_format($info['pourcentage'], 2, ',', ' ') }}%</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    <!-- Détail des collectes (optionnel) -->
    @if(isset($collectes) && $collectes->count() > 0)
    <div class="section">
        <h4>📋 Détail des collectes</h4>
        <table class="table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Agent</th>
                    <th>Type</th>
                    <th class="text-right">Montant</th>
                    <th>Place</th>
                    <th>Zone</th>
                </tr>
            </thead>
            <tbody>
                @foreach($collectes as $collecte)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($collecte->date_collecte)->format('d/m/Y') }}</td>
                    <td>{{ $collecte->agent->name ?? 'N/A' }}</td>
                    <td>{{ ucfirst($collecte->type_collecte) }}</td>
                    <td class="text-right">{{ number_format($collecte->montant, 0, ',', ' ') }} FCFA</td>
                    <td>{{ $collecte->place->numero_place ?? 'N/A' }}</td>
                    <td>{{ $collecte->place->hangar->zone->nom ?? 'N/A' }}</td>
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