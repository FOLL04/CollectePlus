<aside class="sidebar">
    <!-- Header -->
    <div class="sidebar-header">
        <div class="user-info">
            <div class="user-avatar">
                <i class="fas fa-user-tie"></i>
            </div>
            <div class="user-details">
                <h3>Régisseur</h3>
                <p>{{ Auth::user()->name ?? 'Utilisateur' }}</p>
                <small><i class="fas fa-circle text-success"></i> En ligne</small>
            </div>
        </div>
    </div>

    <!-- Menu -->
    <nav class="sidebar-menu">
        <ul>
            <li>
                <a href="{{ route('regisseur.dashboard') }}" class="{{ request()->routeIs('regisseur.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Tableau de bord</span>
                </a>
            </li>

            <!-- Marchés -->
            <li>
                <a href="{{ route('regisseur.marches') }}" class="{{ request()->routeIs('regisseur.marches') ? 'active' : '' }}">
                    <i class="fas fa-store"></i>
                    <span>Marchés</span>
                </a>
            </li>

            <!-- Zones -->
            <li>
                <a href="{{ route('regisseur.zones') }}" class="{{ request()->routeIs('regisseur.zones') ? 'active' : '' }}">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>Zones</span>
                </a>
            </li>

            <!-- Collectes -->
            <li class="menu-section">
                <div class="section-title" onclick="toggleMenu('collecte-menu')">
                    <i class="fas fa-truck"></i>
                    <span>Collectes</span>
                    <i class="fas fa-chevron-down menu-arrow" id="collecte-arrow"></i>
                </div>
                <ul class="sub-menu" id="collecte-menu">
                    <li>
                        <a href="{{ route('regisseur.collectes.index') }}" 
                        class="{{ request()->routeIs('regisseur.collectes.index') ? 'active' : '' }}">
                            <i class="fas fa-list"></i>
                            <span>Toutes les collectes</span>
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Dépôts -->
            <li class="menu-section">
                <div class="section-title" onclick="toggleMenu('depot-menu')">
                    <i class="fas fa-money-check-alt"></i>
                    <span>Dépôts</span>
                    <i class="fas fa-chevron-down menu-arrow" id="depot-arrow"></i>
                </div>
                <ul class="sub-menu" id="depot-menu">
                    <li>
                        <a href="{{ route('regisseur.depots') }}" class="{{ request()->routeIs('regisseur.depots') ? 'active' : '' }}">
                            <i class="fas fa-list"></i>
                            <span>Tous les dépôts</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('regisseur.depots.create') }}" class="{{ request()->routeIs('regisseur.depots.create') ? 'active' : '' }}">
                            <i class="fas fa-plus-circle"></i>
                            <span>Nouveau dépôt</span>
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Rapports -->
            <li class="menu-section">
                <div class="section-title" onclick="toggleMenu('rapport-menu')">
                    <i class="fas fa-chart-bar"></i>
                    <span>Rapports & Statistiques</span>
                    <i class="fas fa-chevron-down menu-arrow" id="rapport-arrow"></i>
                </div>
                
                    <!-- NOUVEAUX LIENS DE RAPPORTS -->
                    <li>
                        <a href="{{ route('regisseur.rapports.agent') }}" 
                        class="{{ request()->routeIs('regisseur.rapports.agent') ? 'active' : '' }}">
                            <i class="fas fa-user-chart"></i>
                            <span>Rapport par Agent</span>
                        </a>
                    </li>
                    
                    <li>
                        <a href="{{ route('regisseur.rapports.marche') }}" 
                        class="{{ request()->routeIs('regisseur.rapports.marche') ? 'active' : '' }}">
                            <i class="fas fa-store-alt"></i>
                            <span>Rapport par Marché</span>
                        </a>
                    </li>
                    
                    <li>
                        <a href="{{ route('regisseur.rapports.synthese') }}" 
                        class="{{ request()->routeIs('regisseur.rapports.synthese') ? 'active' : '' }}">
                            <i class="fas fa-chart-pie"></i>
                            <span>Synthèse Globale</span>
                        </a>
                    </li>
                    
                   
                    
                    
                </ul>
            </li>
        </ul>
    </nav>

    <!-- Footer -->
    <div class="sidebar-footer">
        <form method="POST" action="{{ route('logout') }}" class="logout-form">
            @csrf
            <button type="submit" class="logout-btn">
                <i class="fas fa-sign-out-alt"></i>
                <span>Déconnexion</span>
            </button>
        </form>
        <div class="sidebar-version">
            <small>CollectePlus v1.1</small>
        </div>
    </div>
</aside>

<style>
    /* ========== SIDEBAR STYLES ========== */
    .sidebar {
        width: 280px;
        background: linear-gradient(135deg, #0f766e 0%, #047857 100%);
        color: white;
        display: flex;
        flex-direction: column;
        height: 100vh;
        position: fixed;
        left: 0;
        top: 0;
        z-index: 1000;
        box-shadow: 4px 0 20px rgba(0, 0, 0, 0.1);
    }

    /* Header */
    .sidebar-header {
        padding: 25px 20px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .user-info {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .user-avatar {
        width: 60px;
        height: 60px;
        background: rgba(255, 255, 255, 0.15);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        color: white;
    }

    .user-details h3 {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 4px;
    }

    .user-details p {
        font-size: 0.95rem;
        opacity: 0.9;
        margin-bottom: 4px;
    }

    .user-details small {
        font-size: 0.8rem;
        opacity: 0.8;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .text-success {
        color: #4ade80 !important;
    }

    /* Menu */
    .sidebar-menu {
        flex: 1;
        padding: 20px 0;
        overflow-y: auto;
    }

    .sidebar-menu ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .sidebar-menu > ul > li {
        margin-bottom: 5px;
    }

    /* Menu Sections */
    .menu-section {
        margin-bottom: 5px;
    }

    .section-title {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px 20px;
        font-size: 0.95rem;
        font-weight: 500;
        color: rgba(255, 255, 255, 0.9);
        cursor: pointer;
        transition: all 0.3s ease;
        border-left: 4px solid transparent;
    }

    .section-title:hover {
        background: rgba(255, 255, 255, 0.08);
        color: white;
    }

    .section-title i:first-child {
        width: 20px;
        margin-right: 12px;
        text-align: center;
    }

    .menu-arrow {
        font-size: 0.8rem;
        transition: transform 0.3s ease;
    }

    .menu-arrow.rotated {
        transform: rotate(180deg);
    }

    /* Sub-menu */
    .sub-menu {
        display: none;
        background: rgba(0, 0, 0, 0.1);
        border-left: 4px solid rgba(59, 130, 246, 0.5);
        margin-left: 20px;
        padding-left: 0;
    }

    .sub-menu.active {
        display: block;
    }

    .sub-menu li {
        margin: 0;
    }

    .sub-menu a {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 20px;
        color: rgba(255, 255, 255, 0.8);
        text-decoration: none;
        font-size: 0.9rem;
        font-weight: 400;
        transition: all 0.3s ease;
        border-left: 4px solid transparent;
    }

    .sub-menu a:hover {
        background: rgba(255, 255, 255, 0.1);
        color: white;
        border-left-color: #60a5fa;
    }

    .sub-menu a.active {
        background: rgba(255, 255, 255, 0.15);
        color: white;
        border-left-color: #3b82f6;
        font-weight: 500;
    }

    .sub-menu a i {
        width: 20px;
        text-align: center;
        font-size: 0.9rem;
    }

    /* Dashboard link (not in menu section) */
    .sidebar-menu > ul > li > a {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 20px;
        color: rgba(255, 255, 255, 0.85);
        text-decoration: none;
        font-size: 0.95rem;
        font-weight: 500;
        transition: all 0.3s ease;
        border-left: 4px solid transparent;
    }

    .sidebar-menu > ul > li > a:hover {
        background: rgba(255, 255, 255, 0.1);
        color: white;
        border-left-color: #60a5fa;
    }

    .sidebar-menu > ul > li > a.active {
        background: rgba(255, 255, 255, 0.15);
        color: white;
        border-left-color: #3b82f6;
        font-weight: 600;
    }

    .sidebar-menu > ul > li > a i {
        width: 20px;
        text-align: center;
        font-size: 1.1rem;
    }

    /* Footer */
    .sidebar-footer {
        padding: 20px;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
    }

    .logout-btn {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 12px;
        background: rgba(220, 38, 38, 0.9);
        color: white;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.95rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .logout-btn:hover {
        background: #dc2626;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
    }

    .sidebar-version {
        text-align: center;
        margin-top: 15px;
        color: rgba(255, 255, 255, 0.5);
        font-size: 0.75rem;
    }

    /* Scrollbar */
    .sidebar-menu::-webkit-scrollbar {
        width: 4px;
    }

    .sidebar-menu::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.05);
    }

    .sidebar-menu::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.2);
        border-radius: 4px;
    }

    .sidebar-menu::-webkit-scrollbar-thumb:hover {
        background: rgba(255, 255, 255, 0.3);
    }

    /* Nouveau style pour le titre des rapports */
    .sidebar-menu .section-title span {
        flex-grow: 1;
    }
</style>

<script>
    // Fonction pour toggle les menus
    function toggleMenu(menuId) {
        const menu = document.getElementById(menuId);
        const arrow = document.getElementById(menuId.replace('-menu', '-arrow'));
        
        menu.classList.toggle('active');
        arrow.classList.toggle('rotated');
        
        // Sauvegarder l'état dans localStorage
        const isOpen = menu.classList.contains('active');
        localStorage.setItem(menuId + '_state', isOpen ? 'open' : 'closed');
    }

    // Ouvrir automatiquement le menu actif au chargement
    document.addEventListener('DOMContentLoaded', function() {
        const path = window.location.pathname;
        
        // Restaurer l'état des menus depuis localStorage
        const menus = ['depot-menu', 'rapport-menu', 'collecte-menu'];
        menus.forEach(menuId => {
            const savedState = localStorage.getItem(menuId + '_state');
            const menu = document.getElementById(menuId);
            const arrow = document.getElementById(menuId.replace('-menu', '-arrow'));
            
            if (savedState === 'open') {
                menu.classList.add('active');
                arrow.classList.add('rotated');
            }
        });
        
        // Vérifier la route active et ouvrir le menu correspondant
        if (path.includes('/depots') || path.includes('/depot')) {
            if (!document.getElementById('depot-menu').classList.contains('active')) {
                toggleMenu('depot-menu');
            }
        } 
        else if (path.includes('/collectes')) {
            if (!document.getElementById('collecte-menu').classList.contains('active')) {
                toggleMenu('collecte-menu');
            }
        }
        else if (path.includes('/rapports') || path.includes('/statistiques')) {
            if (!document.getElementById('rapport-menu').classList.contains('active')) {
                toggleMenu('rapport-menu');
            }
        }
        
        // Marquer comme actif le lien parent si un sous-menu est actif
        const activeSubMenuLink = document.querySelector('.sub-menu a.active');
        if (activeSubMenuLink) {
            const parentSection = activeSubMenuLink.closest('.menu-section');
            if (parentSection) {
                const menuId = parentSection.querySelector('.sub-menu').id;
                if (!document.getElementById(menuId).classList.contains('active')) {
                    toggleMenu(menuId);
                }
            }
        }
    });
</script>