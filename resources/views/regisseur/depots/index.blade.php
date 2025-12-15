@extends('regisseur.layouts.app')

@section('title', 'Dépôts du Régisseur')

@section('content')
<div class="container">
    <h1 class="mb-4"><i class="fas fa-money-check-alt"></i> Liste des Dépôts</h1>

    @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th><i class="fas fa-hashtag"></i> ID</th>
                <th><i class="fas fa-receipt"></i> Numéro Reçu</th>
                <th><i class="fas fa-user"></i> Agent</th>
                <th><i class="fas fa-map-marker-alt"></i> Zone</th>
                <th><i class="fas fa-store"></i> Marché</th>
                <th><i class="fas fa-coins"></i> Montant</th>
                <th><i class="fas fa-calendar-day"></i> Date Dépôt</th>
                <th><i class="fas fa-eye"></i> Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($depots as $depot)
                <tr>
                    <td>{{ $depot->id }}</td>
                    <td>{{ $depot->numero_recu ?? 'N/A' }}</td>
                    <td>{{ $depot->agent->name ?? 'Non défini' }}</td>
                    <td>{{ $depot->agent->zone->nom_zone ?? 'Non défini' }}</td>
                    <td>{{ $depot->agent->zone->marche->nom ?? 'Non défini' }}</td>
                    <td>{{ number_format($depot->montant, 0, ',', ' ') }} FCFA</td>
                    <td>{{ $depot->date_depot ?? $depot->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <a href="{{ route('regisseur.depots.recu', $depot->id) }}" class="btn btn-sm btn-info">
                            <i class="fas fa-file-invoice"></i> Voir Reçu
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">Aucun dépôt trouvé.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $depots->links() }}
    </div>
</div>
@endsection
