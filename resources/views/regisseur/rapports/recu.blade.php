<!-- Totaux globaux -->
<div class="card mb-4">
    <div class="card-header">Totaux globaux</div>
    <div class="card-body">
        <ul>
            <li>Total collectes : {{ $totauxGlobaux['total_collectes'] }}</li>
            <li>Montant collectes : {{ number_format($totauxGlobaux['total_montant_collectes'], 0, ',', ' ') }} FCFA</li>
            <li>Total dépôts : {{ $totauxGlobaux['total_depots'] }}</li>
            <li>Montant dépôts : {{ number_format($totauxGlobaux['total_montant_depots'], 0, ',', ' ') }} FCFA</li>
            <li><strong>Solde : {{ number_format($totauxGlobaux['solde'], 0, ',', ' ') }} FCFA</strong></li>
        </ul>

        <!-- Détail par type de collecte -->
        <h5>Collectes par type</h5>
        <table class="table table-sm">
            <thead>
                <tr>
                    <th>Type</th>
                    <th>Nombre</th>
                    <th>Montant</th>
                </tr>
            </thead>
            <tbody>
                @foreach($totauxGlobaux['par_type'] as $type => $stats)
                    <tr>
                        <td>{{ ucfirst($type) }}</td>
                        <td>{{ $stats['count'] }}</td>
                        <td>{{ number_format($stats['montant'], 0, ',', ' ') }} FCFA</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Rapports par marché -->
<h4>Rapports par marché</h4>
@foreach($rapportsMarches as $rapport)
    <div class="card mb-3">
        <div class="card-header">{{ $rapport['marche']->nom }}</div>
        <div class="card-body">
            <p>Collectes : {{ $rapport['collectes_count'] }} ({{ number_format($rapport['collectes_montant'], 0, ',', ' ') }} FCFA)</p>
            <p>Dépôts : {{ $rapport['depots_count'] }} ({{ number_format($rapport['depots_montant'], 0, ',', ' ') }} FCFA)</p>
            <p><strong>Solde : {{ number_format($rapport['solde'], 0, ',', ' ') }} FCFA</strong></p>

            <!-- Détail par type -->
            <h6>Collectes par type</h6>
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th>Type</th>
                        <th>Nombre</th>
                        <th>Montant</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rapport['collectes_par_type'] as $type => $stats)
                        <tr>
                            <td>{{ ucfirst($type) }}</td>
                            <td>{{ $stats['count'] }}</td>
                            <td>{{ number_format($stats['montant'], 0, ',', ' ') }} FCFA</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endforeach
