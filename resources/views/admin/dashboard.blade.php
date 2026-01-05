@extends('layouts.app')

@section('title', 'Tableau de Bord Admin')

@section('content')
<div class="admin-dashboard">
    <!-- Header avec recherche et notifications -->
    <div class="dashboard-header">
        <div class="header-left">
            <h1>Bonjour, {{ Auth::user()->name ?? 'Administrateur' }}</h1>
            <p class="subtitle">Aperçu de votre activité aujourd'hui</p>
        </div>
        <div class="header-right">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Rechercher..." id="globalSearch">
            </div>
            <div class="header-actions">
                <button class="btn-refresh" onclick="refreshDashboard()" title="Actualiser">
                    <i class="fas fa-sync-alt"></i>
                </button>
                
                <div class="user-avatar">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=10b981&color=fff" alt="Avatar">
                </div>
            </div>
        </div>
    </div>

    <!-- 4 Blocs de statistiques sur la même ligne -->
    <div class="stats-grid">
        <div class="stat-block primary">
            <div class="stat-icon">
                <i class="fas fa-store"></i>
            </div>
            <div class="stat-content">
                <h3>{{ $stats['total_marches'] ?? 0 }}</h3>
                <p>Marchés</p>
                <div class="stat-trend up">
                    <i class="fas fa-arrow-up"></i>
                    <span>12%</span>
                </div>
            </div>
        </div>

        <div class="stat-block success">
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-content">
                <h3>{{ $stats['total_users'] ?? 0 }}</h3>
                <p>Utilisateurs</p>
                <div class="stat-trend up">
                    <i class="fas fa-arrow-up"></i>
                    <span>8%</span>
                </div>
            </div>
        </div>

        <div class="stat-block warning">
            <div class="stat-icon">
                <i class="fas fa-money-bill-wave"></i>
            </div>
            <div class="stat-content">
                <h3>{{ number_format($stats['total_depots'] ?? 0, 0, ',', ' ') }} FCFA</h3>
                <p>Dépôts aujourd'hui</p>
                <div class="stat-trend down">
                    <i class="fas fa-arrow-down"></i>
                    <span>5%</span>
                </div>
            </div>
        </div>

        <div class="stat-block info">
            <div class="stat-icon">
                <i class="fas fa-truck"></i>
            </div>
            <div class="stat-content">
                <h3>{{ $stats['collectes_aujourdhui'] ?? 0 }}</h3>
                <p>Collectes aujourd'hui</p>
                <div class="stat-trend up">
                    <i class="fas fa-arrow-up"></i>
                    <span>15%</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Contenu principal en deux colonnes -->
    <div class="content-grid">
        <!-- Colonne de gauche -->
        <div class="left-column">
            <!-- Marchés actifs -->
            <div class="card">
                <div class="card-header">
                    <h3><i class="fas fa-store"></i> Marchés actifs</h3>
                    <a href="{{ route('marches.index') }}" class="btn-link">Voir tout</a>
                </div>
                <div class="card-body">
                    <div class="marches-list">
                        @forelse($marches ?? [] as $marche)
                        <div class="marche-item">
                            <div class="marche-icon">
                                <i class="fas fa-store"></i>
                            </div>
                            <div class="marche-info">
                                <h4>{{ $marche->nom }}</h4>
                                <div class="marche-meta">
                                    <span><i class="fas fa-users"></i> {{ $marche->agents_count ?? 0 }} agents</span>
                                    <span><i class="fas fa-truck"></i> {{ $marche->collectes_count ?? 0 }} coll.</span>
                                </div>
                            </div>
                            <div class="marche-status">
                                @if(($marche->collectes_count ?? 0) > 0)
                                <span class="badge active">Actif</span>
                                @else
                                <span class="badge inactive">Inactif</span>
                                @endif
                            </div>
                        </div>
                        @empty
                        <div class="empty-state">
                            <i class="fas fa-store-slash"></i>
                            <p>Aucun marché</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Colonne de droite -->
        <div class="right-column">
            <!-- Actions rapides -->
            <div class="card">
                <div class="card-header">
                    <h3><i class="fas fa-bolt"></i> Actions rapides</h3>
                </div>
                <div class="card-body">
                    <div class="quick-actions">
                        <a href="{{ route('depots.index') }}" class="action-btn primary">
                            <i class="fas fa-hand-holding-usd"></i>
                            <span>Gérer les dépôts</span>
                        </a>
                        <a href="{{ route('regisseur.rapports.agent') }}" class="action-btn success">
                            <i class="fas fa-chart-bar"></i>
                            <span>Générer rapport</span>
                        </a>
                        <a href="{{ route('users.create') }}" class="action-btn warning">
                            <i class="fas fa-user-plus"></i>
                            <span>Nouvel utilisateur</span>
                        </a>
                        <a href="{{ route('marches.create') }}" class="action-btn info">
                            <i class="fas fa-store-alt"></i>
                            <span>Nouveau marché</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ================== CSS ================== -->
<style>
/* Variables globales */
:root {
    --primary: #4f46e5;
    --primary-light: #e0e7ff;
    --primary-dark: #3730a3;
    --success: #10b981;
    --success-light: #d1fae5;
    --warning: #f59e0b;
    --warning-light: #fef3c7;
    --danger: #ef4444;
    --danger-light: #fee2e2;
    --info: #06b6d4;
    --info-light: #cffafe;
    --gray-50: #f9fafb;
    --gray-100: #f3f4f6;
    --gray-200: #e5e7eb;
    --gray-300: #d1d5db;
    --gray-400: #9ca3af;
    --gray-500: #6b7280;
    --gray-600: #4b5563;
    --gray-700: #374151;
    --gray-800: #1f2937;
    --gray-900: #111827;
    
    --radius-sm: 8px;
    --radius: 12px;
    --radius-lg: 16px;
    --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.05);
    --shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    --shadow-lg: 0 8px 24px rgba(0, 0, 0, 0.12);
}

/* Base */
.admin-dashboard {
    padding: 24px;
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    min-height: 100vh;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

/* Header */
.dashboard-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 32px;
    background: white;
    padding: 24px 32px;
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow);
    border: 1px solid var(--gray-200);
}

.header-left h1 {
    font-size: 28px;
    font-weight: 700;
    color: var(--gray-900);
    margin: 0 0 6px 0;
    line-height: 1.2;
}

.subtitle {
    color: var(--gray-500);
    font-size: 14px;
    font-weight: 500;
    margin: 0;
}

.header-right {
    display: flex;
    align-items: center;
    gap: 20px;
}

.search-box {
    position: relative;
    width: 300px;
}

.search-box input {
    width: 100%;
    padding: 10px 16px 10px 44px;
    border: 1px solid var(--gray-300);
    border-radius: var(--radius);
    background: white;
    font-size: 14px;
    color: var(--gray-700);
    transition: all 0.2s ease;
}

.search-box input:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
}

.search-box i {
    position: absolute;
    left: 16px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--gray-400);
    font-size: 14px;
}

.header-actions {
    display: flex;
    align-items: center;
    gap: 16px;
}

.btn-refresh {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: white;
    border: 1px solid var(--gray-300);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    color: var(--gray-600);
    transition: all 0.2s ease;
}

.btn-refresh:hover {
    background: var(--gray-100);
    border-color: var(--gray-400);
    transform: rotate(90deg);
}

.user-avatar img {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    border: 2px solid var(--primary-light);
    object-fit: cover;
}

/* 4 Blocs de statistiques sur la même ligne */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    margin-bottom: 32px;
}

@media (max-width: 1200px) {
    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 768px) {
    .stats-grid {
        grid-template-columns: 1fr;
    }
}

.stat-block {
    background: white;
    border-radius: var(--radius);
    padding: 24px;
    display: flex;
    align-items: center;
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--gray-200);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.stat-block:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow);
}

.stat-block::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 4px;
}

.stat-block.primary::before { background: var(--primary); }
.stat-block.success::before { background: var(--success); }
.stat-block.warning::before { background: var(--warning); }
.stat-block.info::before { background: var(--info); }

.stat-icon {
    width: 56px;
    height: 56px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 20px;
    font-size: 24px;
    flex-shrink: 0;
}

.stat-block.primary .stat-icon { background: var(--primary-light); color: var(--primary); }
.stat-block.success .stat-icon { background: var(--success-light); color: var(--success); }
.stat-block.warning .stat-icon { background: var(--warning-light); color: var(--warning); }
.stat-block.info .stat-icon { background: var(--info-light); color: var(--info); }

.stat-content h3 {
    font-size: 32px;
    font-weight: 700;
    color: var(--gray-900);
    margin: 0 0 4px 0;
    line-height: 1;
}

.stat-content p {
    color: var(--gray-500);
    font-size: 14px;
    font-weight: 500;
    margin: 0 0 8px 0;
}

.stat-trend {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 4px 10px;
    border-radius: 16px;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.02em;
}

.stat-trend.up {
    background: var(--success-light);
    color: var(--success);
}

.stat-trend.down {
    background: var(--danger-light);
    color: var(--danger);
}

/* Grille de contenu */
.content-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 24px;
}

@media (max-width: 1024px) {
    .content-grid {
        grid-template-columns: 1fr;
        gap: 20px;
    }
}

/* Cartes */
.card {
    background: white;
    border-radius: var(--radius);
    border: 1px solid var(--gray-200);
    box-shadow: var(--shadow-sm);
    transition: all 0.3s ease;
    height: 100%;
}

.card:hover {
    box-shadow: var(--shadow);
}

.card .card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 24px;
    border-bottom: 1px solid var(--gray-200);
}

.card .card-header h3 {
    font-size: 16px;
    font-weight: 600;
    color: var(--gray-900);
    margin: 0;
    display: flex;
    align-items: center;
    gap: 10px;
}

.card .card-header h3 i {
    color: var(--gray-400);
}

.btn-link {
    color: var(--primary);
    text-decoration: none;
    font-size: 14px;
    font-weight: 500;
    transition: color 0.2s ease;
}

.btn-link:hover {
    color: var(--primary-dark);
}

.card .card-body {
    padding: 24px;
}

/* Marchés */
.marches-list {
    max-height: 400px;
    overflow-y: auto;
    padding-right: 8px;
}

.marche-item {
    display: flex;
    align-items: center;
    padding: 16px;
    background: var(--gray-50);
    border: 1px solid var(--gray-200);
    border-radius: var(--radius-sm);
    margin-bottom: 12px;
    transition: all 0.2s ease;
}

.marche-item:hover {
    background: white;
    border-color: var(--gray-300);
    transform: translateX(4px);
}

.marche-icon {
    width: 40px;
    height: 40px;
    background: var(--primary-light);
    border-radius: var(--radius-sm);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--primary);
    font-size: 18px;
    margin-right: 16px;
    flex-shrink: 0;
}

.marche-info h4 {
    font-size: 15px;
    font-weight: 600;
    color: var(--gray-900);
    margin: 0 0 8px 0;
}

.marche-meta {
    display: flex;
    gap: 16px;
}

.marche-meta span {
    font-size: 13px;
    color: var(--gray-600);
    display: flex;
    align-items: center;
    gap: 6px;
}

.marche-meta i {
    color: var(--gray-400);
}

.badge {
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    letter-spacing: 0.02em;
}

.badge.active {
    background: var(--success-light);
    color: var(--success);
}

.badge.inactive {
    background: var(--gray-100);
    color: var(--gray-500);
}

/* Actions rapides */
.quick-actions {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 16px;
    height: 100%;
}

@media (max-width: 480px) {
    .quick-actions {
        grid-template-columns: 1fr;
    }
}

.action-btn {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 24px 16px;
    border-radius: var(--radius);
    text-decoration: none;
    transition: all 0.3s ease;
    border: 2px solid transparent;
    min-height: 120px;
}

.action-btn i {
    font-size: 28px;
    margin-bottom: 12px;
}

.action-btn span {
    font-size: 14px;
    font-weight: 600;
    text-align: center;
    line-height: 1.3;
}

.action-btn.primary {
    background: var(--primary-light);
    color: var(--primary);
    border-color: var(--primary);
}

.action-btn.success {
    background: var(--success-light);
    color: var(--success);
    border-color: var(--success);
}

.action-btn.warning {
    background: var(--warning-light);
    color: var(--warning);
    border-color: var(--warning);
}

.action-btn.info {
    background: var(--info-light);
    color: var(--info);
    border-color: var(--info);
}

.action-btn:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow);
}

/* États vides */
.empty-state {
    text-align: center;
    padding: 48px 24px;
    color: var(--gray-400);
}

.empty-state i {
    font-size: 56px;
    margin-bottom: 16px;
    opacity: 0.4;
}

.empty-state p {
    margin: 0;
    font-size: 16px;
    font-weight: 500;
    color: var(--gray-500);
}

/* Scrollbar */
::-webkit-scrollbar {
    width: 6px;
}

::-webkit-scrollbar-track {
    background: var(--gray-100);
    border-radius: 3px;
}

::-webkit-scrollbar-thumb {
    background: var(--gray-300);
    border-radius: 3px;
}

::-webkit-scrollbar-thumb:hover {
    background: var(--gray-400);
}

/* Responsive header */
@media (max-width: 1024px) {
    .dashboard-header {
        flex-direction: column;
        gap: 20px;
        align-items: stretch;
    }
    
    .header-right {
        width: 100%;
    }
    
    .search-box {
        width: 100%;
    }
}

@media (max-width: 768px) {
    .admin-dashboard {
        padding: 16px;
    }
}

/* Animations */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.stat-block {
    animation: fadeInUp 0.6s ease-out;
}

.stat-block:nth-child(1) { animation-delay: 0.1s; }
.stat-block:nth-child(2) { animation-delay: 0.2s; }
.stat-block:nth-child(3) { animation-delay: 0.3s; }
.stat-block:nth-child(4) { animation-delay: 0.4s; }

.card {
    animation: fadeInUp 0.8s ease-out;
}
</style>

<!-- ================== JavaScript ================== -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Fonction de rafraîchissement
    window.refreshDashboard = function() {
        const btn = document.querySelector('.btn-refresh i');
        btn.style.transform = 'rotate(180deg)';
        
        setTimeout(() => {
            location.reload();
        }, 300);
    };
    
    // Recherche
    const searchInput = document.getElementById('globalSearch');
    if (searchInput) {
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                const query = this.value.trim();
                if (query) {
                    console.log('Recherche:', query);
                }
            }
        });
    }
    
    // Animation des statistiques
    const statValues = document.querySelectorAll('.stat-content h3');
    statValues.forEach(stat => {
        const text = stat.textContent;
        const matches = text.match(/\d+/g);
        if (matches) {
            const finalValue = parseInt(matches.join(''));
            animateCount(stat, 0, finalValue, 1500, text.includes('FCFA'));
        }
    });
    
    function animateCount(element, start, end, duration, isCurrency) {
        let startTimestamp = null;
        const step = (timestamp) => {
            if (!startTimestamp) startTimestamp = timestamp;
            const progress = Math.min((timestamp - startTimestamp) / duration, 1);
            const value = Math.floor(progress * (end - start) + start);
            element.textContent = formatNumber(value, isCurrency);
            if (progress < 1) {
                window.requestAnimationFrame(step);
            }
        };
        window.requestAnimationFrame(step);
    }
    
    function formatNumber(num, isCurrency) {
        const formatted = new Intl.NumberFormat('fr-FR').format(num);
        return isCurrency ? formatted + ' FCFA' : formatted;
    }
});
</script>
@endsection