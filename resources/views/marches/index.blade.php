@extends('layouts.app')

@section('title', 'Gestion des Marchés')

@section('content')
<div class="container-fluid px-4">
    <!-- Header avec bouton création -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2 mb-1 text-dark fw-bold">Gestion des Marchés</h1>
            
        </div>
        <a href="{{ route('marches.create') }}" class="btn btn-success btn-lg fw-bold">
            <i class="fas fa-plus me-2"></i>Nouveau Marché
        </a>
    </div>

    <!-- 4 Cartes de statistiques -->
    <div class="row mb-4 stats-row">
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 h-100">
                <div class="card-body text-center">
                    <div class="stat-icon bg-green-soft mb-3">
                        <i class="fas fa-calendar-alt text-green"></i>
                    </div>
                    <h5 class="text-muted mb-2">Créés ce mois</h5>
                    <h2 class="mb-0 fw-bold text-green">{{ $recentMarchesCount }}</h2>
                    <small class="text-muted">Nouveaux marchés</small>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 h-100">
                <div class="card-body text-center">
                    <div class="stat-icon bg-green-soft mb-3">
                        <i class="fas fa-map-marked-alt text-green"></i>
                    </div>
                    <h5 class="text-muted mb-2">Zones</h5>
                    <h2 class="mb-0 fw-bold text-green">{{ $marches->sum('zones_count') }}</h2>
                    <small class="text-muted">Total de toutes les zones</small>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 h-100">
                <div class="card-body text-center">
                    <div class="stat-icon bg-green-soft mb-3">
                        <i class="fas fa-warehouse text-green"></i>
                    </div>
                    <h5 class="text-muted mb-2">Hangars</h5>
                    <h2 class="mb-0 fw-bold text-green">{{ $marches->sum('hangars_count') }}</h2>
                    <small class="text-muted">Total de tous les hangars</small>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 h-100">
                <div class="card-body text-center">
                    <div class="stat-icon bg-green-soft mb-3">
                        <i class="fas fa-parking text-green"></i>
                    </div>
                    <h5 class="text-muted mb-2">Places</h5>
                    <h2 class="mb-0 fw-bold text-green">{{ $marches->sum('places_count') }}</h2>
                    <small class="text-muted">Total de toutes les places</small>
                </div>
            </div>
        </div>
    </div>

    

    <!-- Tableau des marchés -->
    <div class="card border-0">
        <div class="card-header bg-white border-0 py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold">
                    <i class="fas fa-list me-2 text-green"></i>
                    Liste des Marchés
                </h5>
                <div class="text-muted">
                    {{ $marches->total() }} marchés au total
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            @if($marches->isEmpty())
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-store-alt fa-4x text-green opacity-50"></i>
                    </div>
                    <h4 class="text-muted fw-bold mb-3">Aucun marché trouvé</h4>
                    <p class="text-muted mb-4">Commencez par créer votre premier marché</p>
                    <a href="{{ route('marches.create') }}" class="btn btn-success btn-lg">
                        <i class="fas fa-plus me-2"></i>Créer un marché
                    </a>
                </div>
            @else
                <div class="table-container">
                    <table class="market-table">
                        <thead>
                            <tr>
                                <th class="text-start">Nom du Marché</th>
                                <th>Date de création</th>
                                <th class="text-center">Zones</th>
                                <th class="text-center">Hangars</th>
                                <th class="text-center">Places</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($marches as $marche)
                                <tr>
                                    <td class="market-name">
                                        <div class="market-info">
                                            <div class="market-icon">
                                                <i class="fas fa-store"></i>
                                            </div>
                                            <div class="market-details">
                                                <h6>{{ $marche->nom ?? 'Marché sans nom' }}</h6>
                                                @if($marche->description)
                                                    <small>{{ Str::limit($marche->description, 60) }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="date-cell">
                                        <div class="date-info">
                                            <span class="date">{{ $marche->created_at->format('d/m/Y') }}</span>
                                            <small class="time-ago">{{ $marche->created_at->diffForHumans() }}</small>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="count-badge zones">{{ $marche->zones_count }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="count-badge hangars">{{ $marche->hangars_count }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="count-badge places">{{ $marche->places_count }}</span>
                                    </td>
                                    <td class="text-end">
                                        <div class="action-buttons">
                                            <a href="{{ route('marches.show', $marche->id) }}" 
                                               class="btn-view">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('marches.edit', $marche->id) }}" 
                                               class="btn-edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form method="POST" action="{{ route('marches.destroy', $marche->id) }}" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-delete" onclick="return confirm('Supprimer ce marché ?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
        
        <!-- Pagination -->
        @if($marches->hasPages())
            <div class="card-footer bg-white border-top py-3">
                <div class="d-flex justify-content-center">
                    {{ $marches->links() }}
                </div>
            </div>
        @endif
    </div>
</div>
<style>
    /* Variables inspirées du dashboard */
    :root {
        --vert-dashboard: #10b981;
        --vert-dashboard-clair: #d1fae5;
        --gris-fond: #f9fafb;
        --gris-clair: #f3f4f6;
        --gris-border: #e5e7eb;
        --gris-texte: #6b7280;
        --texte-noir: #111827;
        --blanc: #ffffff;
        --ombre-legere: 0 1px 3px rgba(0, 0, 0, 0.1);
        --ombre: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    /* Fond général */
    body {
        background-color: var(--gris-fond);
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        color: var(--texte-noir);
    }

    .container-fluid {
        padding: 2rem;
    }

    /* Header */
    .d-flex.justify-content-between.align-items-center.mb-4 {
        margin-bottom: 3rem !important;
    }

    .h2.mb-1 {
        font-size: 1.875rem;
        font-weight: 700;
        color: var(--texte-noir);
        margin-bottom: 2.5rem !important;
    }

    .text-muted.mb-0 {
        color: var(--gris-texte) !important;
        font-size: 1.125rem;
        margin: 0;
    }

    /* Bouton nouveau marché */
    .btn-success.btn-lg {
        background-color: var(--vert-dashboard);
        border: none;
        border-radius: 0.5rem;
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        font-size: 1rem;
        transition: all 0.2s;
        box-shadow: var(--ombre);
        
        
    }

    .btn-success.btn-lg:hover {
        background-color: #0da271;
        transform: translateY(-1px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
     
    }

    /* 4 cartes de statistiques */
    .stats-row {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.5rem;
        margin-bottom: 3rem;
    }

    .stats-row .col-xl-3 {
        margin: 0;
        padding: 0;
    }

    .card.border-0.h-100 {
        background: var(--blanc);
        border-radius: 0.75rem;
        border: 1px solid var(--gris-border);
        box-shadow: var(--ombre-legere);
        transition: all 0.2s;
        height: 100%;
        overflow: hidden;
    }

    .card.border-0.h-100:hover {
        box-shadow: var(--ombre);
        transform: translateY(-2px);
        border-color: var(--vert-dashboard-clair);
    }

    .card-body.text-center {
        padding: 1.5rem !important;
    }

    .stat-icon {
        width: 4rem;
        height: 4rem;
        border-radius: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        font-size: 1.5rem;
        color: var(--vert-dashboard);
        background: var(--vert-dashboard-clair);
    }

    .text-green {
        color: var(--vert-dashboard) !important;
    }

    .text-muted.mb-2 {
        color: var(--gris-texte) !important;
        font-size: 0.875rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.025em;
        margin-bottom: 0.5rem !important;
    }

    .fw-bold.text-green {
        font-size: 2.5rem;
        font-weight: 700;
        margin: 0.5rem 0;
        line-height: 1;
    }

    .card-body.text-center small {
        color: var(--gris-texte);
        font-size: 0.875rem;
        display: block;
        margin-top: 0.25rem;
    }

    /* Tableau */
    .card.border-0 {
        background: var(--blanc);
        border-radius: 0.75rem;
        box-shadow: var(--ombre);
        border: 1px solid var(--gris-border);
        overflow: hidden;
    }

    .card-header.bg-white.border-0.py-3 {
        padding: 1.5rem 1.5rem 0 1.5rem !important;
        border-bottom: 1px solid var(--gris-border);
        background: var(--blanc) !important;
    }

    .card-header h5 {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--texte-noir);
        margin: 0;
    }

    .card-header .text-muted {
        color: var(--gris-texte) !important;
        font-size: 0.875rem;
        background: var(--gris-fond);
        padding: 0.25rem 0.75rem;
        border-radius: 1rem;
        border: 1px solid var(--gris-border);
    }

    /* Table */
    .table-container {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .market-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.875rem;
    }

    .market-table thead {
        background: var(--gris-fond);
    }

    .market-table th {
        padding: 1rem 1.5rem;
        text-align: left;
        font-weight: 600;
        color: var(--gris-texte);
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        border-bottom: 1px solid var(--gris-border);
        white-space: nowrap;
    }

    .market-table tbody tr {
        border-bottom: 1px solid var(--gris-border);
        transition: background 0.15s;
    }

    .market-table tbody tr:hover {
        background: var(--gris-fond);
    }

    .market-table td {
        padding: 1rem 1.5rem;
        vertical-align: middle;
        color: var(--texte-noir);
    }

    /* Infos marché */
    .market-info {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .market-icon {
        width: 2.5rem;
        height: 2.5rem;
        background: var(--vert-dashboard-clair);
        border-radius: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--vert-dashboard);
        flex-shrink: 0;
    }

    .market-details h6 {
        font-size: 0.875rem;
        font-weight: 500;
        color: var(--texte-noir);
        margin: 0 0 0.125rem 0;
        line-height: 1.4;
    }

    .market-details small {
        font-size: 0.75rem;
        color: var(--gris-texte);
        line-height: 1.4;
        display: block;
    }

    /* Date */
    .date-info {
        display: flex;
        flex-direction: column;
        gap: 0.125rem;
    }

    .date-info .date {
        font-size: 0.875rem;
        font-weight: 500;
        color: var(--texte-noir);
    }

    .date-info .time-ago {
        font-size: 0.75rem;
        color: var(--gris-texte);
    }

    /* Badges */
    .count-badge {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 1rem;
        font-size: 0.875rem;
        font-weight: 500;
        min-width: 2.5rem;
        text-align: center;
    }

    .count-badge.zones {
        background: var(--vert-dashboard-clair);
        color: var(--vert-dashboard);
    }

    .count-badge.hangars {
        background: #fef3c7;
        color: #d97706;
    }

    .count-badge.places {
        background: #dbeafe;
        color: #1d4ed8;
    }

    /* Actions */
    .action-buttons {
        display: flex;
        gap: 0.5rem;
        justify-content: flex-end;
    }

    .btn-view, .btn-edit, .btn-delete {
        width: 2rem;
        height: 2rem;
        border-radius: 0.375rem;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        border: 1px solid var(--gris-border);
        background: var(--blanc);
        transition: all 0.15s;
    }

    .btn-view {
        color: #2563eb;
    }

    .btn-edit {
        color: #d97706;
    }

    .btn-delete {
        color: #dc2626;
    }

    .btn-view:hover {
        background: #2563eb;
        color: white;
        border-color: #2563eb;
    }

    .btn-edit:hover {
        background: #d97706;
        color: white;
        border-color: #d97706;
    }

    .btn-delete:hover {
        background: #dc2626;
        color: white;
        border-color: #dc2626;
    }

    /* Pagination */
    .card-footer.bg-white.border-top.py-3 {
        padding: 1.5rem !important;
        border-top: 1px solid var(--gris-border);
    }

    .pagination {
        margin: 0;
    }

    .pagination .page-link {
        border: 1px solid var(--gris-border);
        color: var(--gris-texte);
        border-radius: 0.375rem;
        padding: 0.5rem 0.75rem;
        margin: 0 0.125rem;
        font-size: 0.875rem;
    }

    .pagination .page-item.active .page-link {
        background: var(--vert-dashboard);
        border-color: var(--vert-dashboard);
        color: white;
    }

    /* État vide */
    .text-center.py-5 {
        padding: 4rem 2rem !important;
    }

    .fa-store-alt {
        color: var(--vert-dashboard-clair);
        font-size: 3rem;
        margin-bottom: 1rem;
    }

    /* Responsive */
    @media (max-width: 1200px) {
        .stats-row {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .container-fluid {
            padding: 1rem;
        }

        .stats-row {
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        .d-flex.justify-content-between.align-items-center.mb-4 {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }

        .btn-success.btn-lg {
            width: 100%;
            justify-content: center;
        }

        .market-table {
            font-size: 0.75rem;
        }

        .market-table th,
        .market-table td {
            padding: 0.75rem;
        }

        .action-buttons {
            justify-content: center;
        }
    }

    @media (max-width: 480px) {
        .card-body.text-center {
            padding: 1rem !important;
        }

        .fw-bold.text-green {
            font-size: 2rem;
        }
    }
</style>
@endsection