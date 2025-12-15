@extends('regisseur.layouts.app')

@section('title', 'Marchés')

@section('content')
<div class="container">
    <h1 class="mb-4"><i class="fas fa-store"></i> Liste des Marchés</h1>

    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th><i class="fas fa-hashtag"></i> ID</th>
                <th><i class="fas fa-store"></i> Nom du Marché</th>
                <th><i class="fas fa-map"></i> Zones</th>
                <th><i class="fas fa-truck"></i> Collectes</th>
                <th><i class="fas fa-user-shield"></i> Agents Responsables</th>
            </tr>
        </thead>
        <tbody>
            @foreach($marches as $marche)
                <tr>
                    <td>{{ $marche->id }}</td>
                    <td>{{ $marche->nom }}</td>
                    <td>{{ $marche->zones_count }}</td>
                    <td>{{ $marche->collectes_count }}</td>
                    <td>
                        @foreach($marche->zones as $zone)
                            <span class="badge bg-primary">
                                {{ $zone->agent->name ?? 'Inconnue XOXO' }}
                            </span>
                        @endforeach
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $marches->links() }}
    </div>
</div>
@endsection
