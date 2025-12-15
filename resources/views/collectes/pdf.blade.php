<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rapport Collectes - Admin</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        h1 { text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h1>Liste des Collectes (Admin)</h1>
    <p>Période : {{ $mois ?? 'Toutes' }}</p>

    <table>
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
                    <td>{{ $collecte->id }}</td>
                    <td>{{ $collecte->agent->name ?? 'N/A' }}</td>
                    <td>{{ ucfirst($collecte->type_collecte) }}</td>
                    <td>{{ $collecte->formattedMontant }}</td>
                    <td>{{ $collecte->formattedDate }}</td>
                    <td>{{ $collecte->heureCollecte }}</td>
                    <td>{{ $collecte->numero_recu }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">Aucune collecte trouvée</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
