@extends('regisseur.layouts.app')

@section('title', 'Dashboard Régisseur')

@section('content')
<div class="container-fluid">
    <!-- En-tête -->
    <div class="dashboard-header mb-3">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="h3 fw-bold mb-1">
                    <i class="fas fa-tachometer-alt me-2 text-primary"></i>Dashboard
                </h1>
                <p class="text-muted small mb-0">
                    Bienvenue, <span class="fw-medium text-dark">{{ Auth::user()->name }}</span> 
                    • {{ now()->translatedFormat('l d F Y') }}
                </p>
            </div>
            <div class="col-md-4 text-md-end">
                <div class="online-status d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill bg-light">
                    <span class="status-dot"></span>
                    <span class="small fw-medium text-success">En ligne</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Cartes de statistiques -->
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card stat-card border-start border-3 border-primary h-100">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon me-3">
                            <i class="fas fa-store fa-lg text-primary"></i>
                        </div>
                        <div>
                            <h4 class="stat-value mb-0 fw-bold">{{ $stats['total_marches'] ?? 0 }}</h4>
                            <p class="stat-label text-muted small mb-0">Marchés</p>
                        </div>
                    </div>
                    <a href="{{ route('regisseur.marches') }}" class="stretched-link"></a>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card stat-card border-start border-3 border-success h-100">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon me-3">
                            <i class="fas fa-user-shield fa-lg text-success"></i>
                        </div>
                        <div>
                            <h4 class="stat-value mb-0 fw-bold">{{ $stats['total_agents'] ?? 0 }}</h4>
                            <p class="stat-label text-muted small mb-0">Agents</p>
                        </div>
                    </div>
                    <a href="{{ route('regisseur.zones') }}" class="stretched-link"></a>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card stat-card border-start border-3 border-warning h-100">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon me-3">
                            <i class="fas fa-truck fa-lg text-warning"></i>
                        </div>
                        <div>
                            <h4 class="stat-value mb-0 fw-bold">{{ $stats['collectes_aujourdhui'] ?? 0 }}</h4>
                            <p class="stat-label text-muted small mb-0">Collectes aujourd'hui</p>
                        </div>
                    </div>
                    <a href="{{ route('regisseur.collectes.index') }}" class="stretched-link"></a>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card stat-card border-start border-3 border-info h-100">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon me-3">
                            <i class="fas fa-money-bill-wave fa-lg text-info"></i>
                        </div>
                        <div>
                            <h4 class="stat-value mb-0 fw-bold">{{ number_format($stats['montant_depots_aujourdhui'] ?? 0, 0, ',', ' ') }} FCFA</h4>
                            <p class="stat-label text-muted small mb-0">Dépôts du jour</p>
                        </div>
                    </div>
                    <a href="{{ route('regisseur.depots') }}" class="stretched-link"></a>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <!-- Colonne principale -->
        <div class="col-lg-8">
            <!-- Derniers dépôts -->
            <div class="card h-100">
                <div class="card-header bg-white border-bottom py-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 fw-bold">
                            <i class="fas fa-history me-2 text-primary"></i>Derniers dépôts
                        </h6>
                        <a href="{{ route('regisseur.depots') }}" class="btn btn-sm btn-outline-primary btn-sm">
                            Voir tout <i class="fas fa-arrow-right ms-1 fa-xs"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body p-3">
                    @if($depots_recents->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm table-hover mb-0">
                                <thead>
                                    <tr class="small">
                                        <th>Date</th>
                                        <th>Agent</th>
                                        <th>Montant</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($depots_recents as $depot)
                                    <tr class="small">
                                        <td class="text-nowrap">{{ $depot->created_at->format('d/m H:i') }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-xs me-2">
                                                    <div class="avatar-title bg-light-primary rounded">
                                                        <i class="fas fa-user fa-xs text-primary"></i>
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="fw-medium">{{ $depot->agent->name ?? 'N/A' }}</div>
                                                    <small class="text-muted">{{ $depot->agent->email ?? '' }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="fw-bold text-success">
                                            {{ number_format($depot->montant, 0, ',', ' ') }} FCFA
                                        </td>
                                        <td>
                                            <span class="badge bg-success py-1">
                                                <i class="fas fa-check me-1 fa-xs"></i>Terminé
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-inbox fa-2x text-muted mb-2"></i>
                            <p class="text-muted small mb-3">Aucun dépôt effectué récemment</p>
                            <a href="{{ route('regisseur.depots.create') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus me-1 fa-xs"></i>Faire un dépôt
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Colonne secondaire -->
        <div class="col-lg-4">
            <!-- Agents actifs -->
            <div class="card mb-3">
                <div class="card-header bg-white border-bottom py-2">
                    <h6 class="mb-0 fw-bold">
                        <i class="fas fa-user-friends me-2 text-primary"></i>Agents actifs
                    </h6>
                </div>
                <div class="card-body p-3">
                    @if($agents->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($agents as $agent)
                            <a href="{{ route('regisseur.collectes.agent', $agent) }}" 
                               class="list-group-item list-group-item-action border-0 px-0 py-2">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="avatar-xs">
                                            <div class="avatar-title bg-light-primary rounded">
                                                <i class="fas fa-user-shield fa-xs text-primary"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-2">
                                        <div class="fw-medium small">{{ $agent->name }}</div>
                                        <div class="text-muted x-small">
                                            @if($agent->zone)
                                                {{ $agent->zone->nom_zone }}
                                                @if($agent->zone->marche)
                                                    • {{ $agent->zone->marche->nom }}
                                                @endif
                                            @else
                                                <span class="text-warning">Non assigné</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-chevron-right fa-xs text-muted"></i>
                                    </div>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-3">
                            <i class="fas fa-users fa-lg text-muted mb-2"></i>
                            <p class="text-muted small mb-0">Aucun agent trouvé</p>
                        </div>
                    @endif
                </div>
                <div class="card-footer bg-white border-top py-2 text-center">
                    <a href="{{ route('regisseur.zones') }}" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-eye me-1 fa-xs"></i>Voir tous
                    </a>
                </div>
            </div>

            <!-- Actions rapides -->
            <div class="card">
                <div class="card-header bg-white border-bottom py-2">
                    <h6 class="mb-0 fw-bold">
                        <i class="fas fa-bolt me-2 text-primary"></i>Actions rapides
                    </h6>
                </div>
                <div class="card-body p-3">
                    <div class="row g-2">
                        <div class="col-6">
                            <a href="{{ route('regisseur.depots.create') }}" class="btn btn-success w-100 h-100 py-2">
                                <i class="fas fa-money-bill-transfer fa-lg mb-1"></i>
                                <div class="x-small mt-1">Nouveau dépôt</div>
                            </a>
                        </div>
                    
                         
                        <div class="col-6">
                            <a href="{{ route('regisseur.rapports.agent') }}"  class="btn btn-warning w-100 h-100 py-2">
                                <i class="fas fa-money-bill-transfer fa-lg mb-1"></i>
                                <div class="x-small mt-1">Rapport par Agent</div>
                            </a>
                        </div>
                         
                        <div class="col-6">
                            <a href="{{ route('regisseur.collectes.index') }}" class="btn btn-warning w-100 h-100 py-2">
                                <i class="fas fa-truck fa-lg mb-1"></i>
                                <div class="x-small mt-1">Collectes</div>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('regisseur.marches') }}" class="btn btn-primary w-100 h-100 py-2">
                                <i class="fas fa-store fa-lg mb-1"></i>
                                <div class="x-small mt-1">Marchés</div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* ========== STYLES OPTIMISÉS ========== */
    :root {
        --primary-color: #0f766e;
        --success-color: #10b981;
        --warning-color: #f59e0b;
        --info-color: #06b6d4;
    }

    /* Header */
    .dashboard-header {
        padding: 15px 0;
        border-bottom: 1px solid #e9ecef;
    }

    .online-status {
        background-color: rgba(16, 185, 129, 0.1) !important;
    }

    .status-dot {
        width: 8px;
        height: 8px;
        background-color: var(--success-color);
        border-radius: 50%;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% { opacity: 1; }
        50% { opacity: 0.5; }
        100% { opacity: 1; }
    }

    /* Cartes de statistiques */
    .stat-card {
        transition: all 0.3s ease;
        cursor: pointer;
        min-height: 80px;
    }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(15, 118, 110, 0.08);
        border-radius: 8px;
    }

    .stat-value {
        font-size: 1.3rem;
        color: #1f2937;
    }

    .stat-label {
        font-size: 0.8rem;
    }

    /* Bordures colorées */
    .border-primary { border-color: var(--primary-color) !important; }
    .border-success { border-color: var(--success-color) !important; }
    .border-warning { border-color: var(--warning-color) !important; }
    .border-info { border-color: var(--info-color) !important; }

    /* Avatars */
    .avatar-xs {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .avatar-sm {
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .avatar-title {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .bg-light-primary {
        background-color: rgba(15, 118, 110, 0.08) !important;
    }

    /* Tailles de texte réduites */
    .x-small {
        font-size: 0.75rem;
    }

    .small {
        font-size: 0.85rem;
    }

    /* Tableau */
    .table-sm th,
    .table-sm td {
        padding: 8px 12px;
        font-size: 0.85rem;
    }

    /* Boutons */
    .btn-sm {
        padding: 4px 10px;
        font-size: 0.8rem;
    }

    /* Listes */
    .list-group-item {
        padding: 8px 0;
        font-size: 0.85rem;
    }

    .list-group-item:hover {
        background-color: rgba(15, 118, 110, 0.05);
    }

    /* Icônes */
    .fa-xs {
        font-size: 0.75rem;
    }

    .fa-sm {
        font-size: 0.875rem;
    }

    .fa-lg {
        font-size: 1.125rem;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .stat-value {
            font-size: 1.1rem;
        }
        
        .stat-icon {
            width: 40px;
            height: 40px;
        }
        
        .dashboard-header h1 {
            font-size: 1.2rem;
        }
        
        .btn {
            padding: 6px 12px;
        }
    }

    @media (max-width: 576px) {
        .container-fluid {
            padding-left: 10px;
            padding-right: 10px;
        }
        
        .card-body {
            padding: 15px !important;
        }
    }
</style>

<script>
    // Animation pour les cartes de statistiques
    document.addEventListener('DOMContentLoaded', function() {
        const statCards = document.querySelectorAll('.stat-card');
        statCards.forEach((card, index) => {
            setTimeout(() => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                card.style.transition = 'all 0.4s ease';
                
                setTimeout(() => {
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, 50);
            }, index * 100);
        });
    });
</script>
@endsection