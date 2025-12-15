<!DOCTYPE html>
<html>
<head>
    <title>Rapport Synthèse Globale</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            font-size: 12px; 
            margin: 0; 
            padding: 20px; 
            color: #333; 
        }
        .header { 
            text-align: center; 
            margin-bottom: 25px; 
            border-bottom: 3px solid #16a34a; 
            padding-bottom: 15px;
        }
        .title { 
            font-size: 24px; 
            font-weight: bold;
            color: #111827;
            margin-bottom: 5px;
        }
        .subtitle { 
            font-size: 16px; 
            color: #6b7280;
            margin-bottom: 10px;
        }
        .period { 
            font-size: 13px; 
            margin-top: 8px;
            color: #4b5563;
        }

        .section { 
            margin-bottom: 25px;
        }
        .section h4 { 
            background: #16a34a; 
            color: #fff; 
            padding: 8px 12px; 
            border-radius: 4px; 
            font-size: 14px; 
            margin: 0 0 12px 0; 
            font-weight: 600;
        }

        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-bottom: 20px;
        }
        th, td { 
            border: 1px solid #d1d5db; 
            padding: 10px; 
            font-size: 11px;
        }
        th { 
            background: #f3f4f6; 
            font-weight: bold;
            color: #111827;
        }
        tr:nth-child(even) { 
            background: #f9fafb; 
        }
        .highlight { 
            background: #dcfce7; 
            font-weight: bold;
        }
        .text-right { 
            text-align: right;
        }
        .text-center { 
            text-align: center;
        }

        .summary-box { 
            display: flex; 
            justify-content: space-between; 
            margin-bottom: 30px; 
            gap: 15px;
        }
        .summary-item { 
            flex: 1; 
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        .summary-item .label { 
            font-size: 11px; 
            color: #6b7280; 
            text-transform: uppercase;
            font-weight: 600;
            margin-bottom: 5px;
        }
        .summary-item .value { 
            font-size: 20px; 
            font-weight: bold; 
            margin: 8px 0;
        }
        .summary-item .sub { 
            font-size: 10px; 
            color: #9ca3af; 
        }
        .value-green { 
            color: #16a34a; 
        }
        .value-blue { 
            color: #2563eb; 
        }
        .value-purple { 
            color: #7c3aed; 
        }

        .footer { 
            margin-top: 40px; 
            text-align: center; 
            font-size: 10px; 
            color: #9ca3af;
            border-top: 1px solid #e5e7eb; 
            padding-top: 15px; 
        }
        
        .rank-badge {
            display: inline-block;
            width: 26px;
            height: 26px;
            line-height: 26px;
            border-radius: 50%;
            text-align: center;
            font-weight: bold;
            font-size: 11px;
        }
        .rank-1 { background-color: #ffd700; color: #000; }
        .rank-2 { background-color: #c0c0c0; color: #000; }
        .rank-3 { background-color: #cd7f32; color: #000; }
        .rank-other { background-color: #e5e7eb; color: #6b7280; }
    </style>
</head>
<body>
    <!-- HEADER -->
    <div class="header">
        <div class="title">RAPPORT SYNTHÈSE GLOBALE</div>
        <div class="subtitle">Vue d'ensemble complète de toutes les activités</div>
        <div class="period">
            Période du <strong>{{ \Carbon\Carbon::parse($dateDebut)->format('d/m/Y') }}</strong>
            au <strong>{{ \Carbon\Carbon::parse($dateFin)->format('d/m/Y') }}</strong>
        </div>
    </div>

    <!-- SUMMARY -->
    <div class="summary-box">
        <div class="summary-item">
            <div class="label">TOTAL COLLECTÉ</div>
            <div class="value value-green">
                {{ number_format($statistiques['collectes']['montant'], 0, ',', ' ') }} FCFA
            </div>
            <div class="sub">{{ $statistiques['collectes']['total'] }} collectes</div>
        </div>
        <div class="summary-item">
            <div class="label">TOTAL DÉPOSÉ</div>
            <div class="value value-blue">
                {{ number_format($statistiques['depots']['montant'], 0, ',', ' ') }} FCFA
            </div>
            <div class="sub">{{ $statistiques['depots']['total'] }} dépôts</div>
        </div>
        <div class="summary-item">
            <div class="label">SOLDE NET</div>
            @php 
                $solde = $statistiques['collectes']['montant'] - $statistiques['depots']['montant']; 
            @endphp
            <div class="value value-purple">
                {{ number_format($solde, 0, ',', ' ') }} FCFA
            </div>
            <div class="sub">{{ $solde >= 0 ? 'Excédent' : 'Déficit' }}</div>
        </div>
        <div class="summary-item">
            <div class="label">AGENTS ACTIFS</div>
            <div class="value" style="color: #059669;">
                {{ count($statistiques['collectes']['top_agents']) }}
            </div>
            <div class="sub">Agents ayant collecté</div>
        </div>
    </div>

    <!-- DETAIL GLOBAL -->
    <div class="section">
        <h4>📊 Détail global des opérations</h4>
        <table>
            <thead>
                <tr>
                    <th class="text-center">Type d'opération</th>
                    <th class="text-center">Nombre</th>
                    <th class="text-right">Montant total</th>
                    <th class="text-right">Moyenne</th>
                    <th class="text-center">Taux</th>
                </tr>
            </thead>
            <tbody>
                <!-- Ligne Collectes -->
                <tr>
                    <td><strong>Collectes</strong></td>
                    <td class="text-center">{{ $statistiques['collectes']['total'] }}</td>
                    <td class="text-right">{{ number_format($statistiques['collectes']['montant'], 0, ',', ' ') }} FCFA</td>
                    <td class="text-right">
                        @php
                            $moyenneCollecte = $statistiques['collectes']['total'] > 0 
                                ? $statistiques['collectes']['montant'] / $statistiques['collectes']['total']
                                : 0;
                        @endphp
                        {{ number_format($moyenneCollecte, 0, ',', ' ') }} FCFA
                    </td>
                    <td class="text-center">100%</td>
                </tr>
                
                <!-- Ligne Dépôts -->
                <tr>
                    <td><strong>Dépôts</strong></td>
                    <td class="text-center">{{ $statistiques['depots']['total'] }}</td>
                    <td class="text-right">{{ number_format($statistiques['depots']['montant'], 0, ',', ' ') }} FCFA</td>
                    <td class="text-right">
                        @php
                            $moyenneDepot = $statistiques['depots']['total'] > 0 
                                ? $statistiques['depots']['montant'] / $statistiques['depots']['total']
                                : 0;
                        @endphp
                        {{ number_format($moyenneDepot, 0, ',', ' ') }} FCFA
                    </td>
                    <td class="text-center">
                        @php
                            $tauxDepot = $statistiques['collectes']['montant'] > 0 
                                ? ($statistiques['depots']['montant'] / $statistiques['collectes']['montant']) * 100 
                                : 0;
                        @endphp
                        {{ number_format($tauxDepot, 1, ',', ' ') }}%
                    </td>
                </tr>
                
                <!-- Ligne Solde -->
                <tr class="highlight">
                    <td><strong>SOLDE NET</strong></td>
                    <td class="text-center">-</td>
                    <td class="text-right">{{ number_format($solde, 0, ',', ' ') }} FCFA</td>
                    <td class="text-right">-</td>
                    <td class="text-center">
                        @if($solde >= 0)
                            <span style="color: #16a34a; font-weight: bold;">✓ Excédent</span>
                        @else
                            <span style="color: #ef4444; font-weight: bold;">⚠ Déficit</span>
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- TOP AGENTS -->
    <div class="section">
        <h4>👑 Top 10 des agents par performance</h4>
        @if(count($statistiques['collectes']['top_agents']) > 0)
        <table>
            <thead>
                <tr>
                    <th style="width: 50px;">Rang</th>
                    <th>Agent</th>
                    <th class="text-center">Collectes</th>
                    <th class="text-right">Montant total</th>
                    <th class="text-right">Moyenne</th>
                    <th class="text-center">% du total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($statistiques['collectes']['top_agents'] as $index => $agent)
                @php
                    $pourcentage = $statistiques['collectes']['montant'] > 0 
                        ? ($agent['montant'] / $statistiques['collectes']['montant']) * 100 
                        : 0;
                    $moyenneAgent = $agent['nombre'] > 0 ? $agent['montant'] / $agent['nombre'] : 0;
                @endphp
                <tr @if($index < 3) style="background-color: rgba(255, 215, 0, 0.1);" @endif>
                    <td class="text-center">
                        <span class="rank-badge rank-{{ $index + 1 }}">
                            {{ $index + 1 }}
                        </span>
                    </td>
                    <td><strong>{{ $agent['nom'] }}</strong></td>
                    <td class="text-center">{{ $agent['nombre'] }}</td>
                    <td class="text-right">{{ number_format($agent['montant'], 0, ',', ' ') }} FCFA</td>
                    <td class="text-right">{{ number_format($moyenneAgent, 0, ',', ' ') }} FCFA</td>
                    <td class="text-center">{{ number_format($pourcentage, 1, ',', ' ') }}%</td>
                </tr>
                @endforeach
                
                <!-- Ligne de total -->
                <tr style="background-color: #111827; color: white; font-weight: bold;">
                    <td colspan="2">TOTAL</td>
                    <td class="text-center">{{ $statistiques['collectes']['total'] }}</td>
                    <td class="text-right">{{ number_format($statistiques['collectes']['montant'], 0, ',', ' ') }} FCFA</td>
                    <td class="text-right">
                        @php
                            $moyenneGlobale = $statistiques['collectes']['total'] > 0 
                                ? $statistiques['collectes']['montant'] / $statistiques['collectes']['total']
                                : 0;
                        @endphp
                        {{ number_format($moyenneGlobale, 0, ',', ' ') }} FCFA
                    </td>
                    <td class="text-center">100%</td>
                </tr>
            </tbody>
        </table>
        @else
        <div style="text-align: center; padding: 20px; color: #6b7280; font-style: italic;">
            Aucune donnée d'agent disponible pour cette période
        </div>
        @endif
    </div>

    <!-- COLLECTES PAR TYPE (optionnel) -->
    @if(isset($statistiques['collectes']['par_type']) && count($statistiques['collectes']['par_type']) > 0)
    <div class="section">
        <h4>🏷️ Collectes par type</h4>
        <table>
            <thead>
                <tr>
                    <th>Type</th>
                    <th class="text-center">Nombre</th>
                    <th class="text-right">Montant</th>
                    <th class="text-center">%</th>
                </tr>
            </thead>
            <tbody>
                @foreach($statistiques['collectes']['par_type'] as $type => $info)
                @php
                    $pourcentage = $statistiques['collectes']['montant'] > 0 
                        ? ($info['montant'] / $statistiques['collectes']['montant']) * 100 
                        : 0;
                @endphp
                <tr>
                    <td>{{ ucfirst($type) }}</td>
                    <td class="text-center">{{ $info['nombre'] }}</td>
                    <td class="text-right">{{ number_format($info['montant'], 0, ',', ' ') }} FCFA</td>
                    <td class="text-center">{{ number_format($pourcentage, 1, ',', ' ') }}%</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    <!-- FOOTER -->
    <div class="footer">
        Généré le {{ now()->format('d/m/Y à H:i') }} | @CollectePlus 
    </div>
</body>
</html>