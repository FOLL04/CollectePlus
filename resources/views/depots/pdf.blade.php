<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rapport des Dépôts</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        h1 { text-align: center; margin-bottom: 20px; color: #15803d; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: center; }
        th { background-color: #15803d; color: #fff; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        .footer { margin-top: 30px; text-align: center; font-size: 10px; color: #666; }
    </style>
</head>
<body>
    <h1>📊 Rapport des Dépôts</h1>
    <p>Période : 
        @if(request()->date_debut && request()->date_fin)
            du {{ \Carbon\Carbon::parse(request()->date_debut)->format('d/m/Y') }} 
            au {{ \Carbon\Carbon::parse(request()->date_fin)->format('d/m/Y') }}
        @else
            Toutes périodes
        @endif
    </p>
    <p>Généré le {{ now()->format('d/m/Y H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th>Agent</th>
                <th>Régisseur</th>
                <th>Montant</th>
                <th>Date</th>
                <th>Reçu</th>
            </tr>
        </thead>
        <tbody>
            @forelse($depots as $depot)
                <tr>
                    <td>{{ $depot->agent->name ?? 'N/A' }}</td>
                    <td>{{ $depot->regisseur->name ?? 'N/A' }}</td>
                    <td>{{ number_format($depot->montant, 0, ',', ' ') }} F</td>
                    <td>{{ \Carbon\Carbon::parse($depot->date_depot)->format('d/m/Y') }}</td>
                    <td>
                        @if($depot->recu_path)
                            {{ $depot->recu_path }}
                        @else
                            Aucun
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">Aucun dépôt trouvé pour cette période</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Système de Gestion des Marchés | Rapport des dépôts
    </div>
</body>
</html>
