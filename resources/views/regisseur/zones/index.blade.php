@extends('regisseur.layouts.app')

@section('title', 'Zones')

@section('content')
<div class="container">
    <h1 class="mb-4"><i class="fas fa-map-marker-alt"></i> Liste des Zones</h1>

    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th><i class="fas fa-hashtag"></i> ID</th>
                <th><i class="fas fa-map"></i> Nom de la Zone</th>
                <th><i class="fas fa-store"></i> Marché</th>
                <th><i class="fas fa-user-shield"></i> Agent Responsable</th>
                <th><i class="fas fa-warehouse"></i> Hangars</th>
                <th><i class="fas fa-cube"></i> Places</th>
            </tr>
        </thead>
        <tbody>
            @foreach($zones as $zone)
                <tr>
                    <td>{{ $zone->id }}</td>
                    <td>{{ $zone->nom_zone }}</td>
                    <td>{{ $zone->marche->nom ?? 'Non défini' }}</td>
                    <td>{{ $zone->agent->name ?? 'Non défini' }}</td>
                    <td>{{ $zone->hangars->count() }}</td>
                    <td>{{ $zone->places->count() }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $zones->links() }}
    </div>
</div>
@endsection
