<aside class="sidebar">
    <!-- Header -->
    <div class="sidebar-header">
        <div class="user-info">
            <div class="user-avatar">
                <i class="fas fa-user-shield"></i>
            </div>
            <div class="user-details">
                <h3>Administrateur</h3>
                <p>{{ Auth::user()->name ?? 'Admin' }}</p>
                <small><i class="fas fa-circle text-success"></i> En ligne</small>
            </div>
        </div>
    </div>

    <!-- Menu -->
    <nav class="sidebar-menu">
        <ul>
            <li>
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <!-- Gestion des données -->
            <li class="menu-section">
                <div class="section-title">
                    <i class="fas fa-database"></i>
                    <span>Gestion des données</span>
                </div>
                <ul>
                    <li>
                        <a href="{{ route('marches.index') }}" class="{{ request()->routeIs('marches.*') ? 'active' : '' }}">
                            <i class="fas fa-store"></i>
                            <span>Marchés</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('zones.index') }}" class="{{ request()->routeIs('zones.*') ? 'active' : '' }}">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>Zones</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('hangars.index') }}" class="{{ request()->routeIs('hangars.*') ? 'active' : '' }}">
                            <i class="fas fa-building"></i>
                            <span>Hangars</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('places.index') }}" class="{{ request()->routeIs('places.*') ? 'active' : '' }}">
                            <i class="fas fa-cube"></i>
                            <span>Places</span>
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Opérations -->
            <li class="menu-section">
                <div class="section-title">
                    <i class="fas fa-exchange-alt"></i>
                    <span>Opérations</span>
                </div>
                <ul>
                    <li>
                        <a href="{{ route('collectes.index') }}" class="{{ request()->routeIs('collectes.*') ? 'active' : '' }}">
                            <i class="fas fa-truck"></i>
                            <span>Collectes</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('depots.index') }}" class="{{ request()->routeIs('depots.*') ? 'active' : '' }}">
                            <i class="fas fa-warehouse"></i>
                            <span>Dépôts</span>
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Administration -->
            <li class="menu-section">
                <div class="section-title">
                    <i class="fas fa-users-cog"></i>
                    <span>Administration</span>
                </div>
                <ul>
                    <li>
                        <a href="{{ route('users.index') }}" class="{{ request()->routeIs('users.*') ? 'active' : '' }}">
                            <i class="fas fa-users"></i>
                            <span>Utilisateurs</span>
                        </a>
                    </li>
                    
                    <!-- Documentation visible uniquement pour l'admin -->
                    @if(Auth::check() && Auth::user()->role === 'admin')
                    <li>
                        <a href="{{ route('documentation.index') }}" class="{{ request()->routeIs('documentation.*') ? 'active' : '' }}">
                            <i class="fas fa-book"></i>
                            <span>Documentation</span>
                        </a>
                    </li>
                    @endif
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
            <small>CollectePlus v1.0</small>
        </div>
    </div>
</aside>

<style>
    /* ========== SIDEBAR STYLES ========== */
    .sidebar {
        width: 280px;
        background: linear-gradient(180deg, #0f766e 0%, #047857 100%);
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

    .sidebar-menu a {
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

    .sidebar-menu a:hover {
        background: rgba(255, 255, 255, 0.1);
        color: white;
        border-left-color: #60a5fa;
    }

    .sidebar-menu a.active {
        background: rgba(255, 255, 255, 0.15);
        color: white;
        border-left-color: #3b82f6;
        font-weight: 600;
    }

    .sidebar-menu a i {
        width: 20px;
        text-align: center;
        font-size: 1.1rem;
    }

    /* Menu Sections */
    .menu-section {
        margin-top: 15px;
    }

    .section-title {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 20px;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: rgba(255, 255, 255, 0.7);
        font-weight: 600;
        border-left: 3px solid rgba(255, 255, 255, 0.3);
    }

    .menu-section ul {
        margin-left: 10px;
        border-left: 1px solid rgba(255, 255, 255, 0.1);
        padding-left: 10px;
    }

    .menu-section ul a {
        padding: 10px 20px;
        font-size: 0.9rem;
    }

    .menu-section ul a i {
        font-size: 0.9rem;
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
</style>