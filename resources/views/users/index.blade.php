@extends('layouts.app')

@section('title', 'Gestion des utilisateurs')

@section('content')
<div class="users-container">
    <!-- En-tête de la page -->
    <div class="page-header">
        <div class="header-content">
            <div class="title-section">
                <h1><i class="fas fa-users-cog"></i> Gestion des utilisateurs</h1>
                <p class="subtitle">Administration des comptes et des permissions</p>
            </div>
            <div class="header-actions">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" id="searchInput" placeholder="Rechercher un utilisateur...">
                </div>
                <a href="{{ route('users.create') }}" class="btn btn-primary">
                    <i class="fas fa-user-plus"></i> Nouvel utilisateur
                </a>
            </div>
        </div>
        
        <!-- Statistiques rapides -->
        <div class="quick-stats">
            <div class="stat-item">
                <span class="stat-number">{{ $totalUsers ?? $users->count() }}</span>
                <span class="stat-label">Total utilisateurs</span>
            </div>
            <div class="stat-item">
                <span class="stat-number">{{ $adminCount ?? 0 }}</span>
                <span class="stat-label">Administrateurs</span>
            </div>
            <div class="stat-item">
                <span class="stat-number">{{ $activeUsers ?? 0 }}</span>
                <span class="stat-label">Actifs</span>
            </div>
            <div class="stat-item">
                <span class="stat-number">{{ $newThisMonth ?? 0 }}</span>
                <span class="stat-label">Nouveaux ce mois</span>
            </div>
        </div>
    </div>

    <!-- Messages de notification -->
    @if (session('success'))
        <div class="alert alert-success">
            <div class="alert-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="alert-content">
                <h4>Succès !</h4>
                <p>{{ session('success') }}</p>
            </div>
            <button class="alert-close">&times;</button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            <div class="alert-icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="alert-content">
                <h4>Erreur</h4>
                <p>{{ session('error') }}</p>
            </div>
            <button class="alert-close">&times;</button>
        </div>
    @endif

    <!-- Tableau des utilisateurs -->
    <div class="table-container card">
        <div class="table-header">
            <h3><i class="fas fa-list"></i> Liste des utilisateurs</h3>
            <div class="table-filters">
                <select class="filter-select" id="roleFilter">
                    <option value="all">Tous les rôles</option>
                    @if(isset($roles))
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    @endif
                </select>
                <select class="filter-select" id="statusFilter">
                    <option value="all">Tous les statuts</option>
                    <option value="active">Actifs seulement</option>
                    <option value="inactive">Inactifs</option>
                </select>
            </div>
        </div>

        @if ($users->isEmpty())
            <div class="empty-state">
                <i class="fas fa-user-slash"></i>
                <h3>Aucun utilisateur enregistré</h3>
                <p>Commencez par ajouter votre premier utilisateur</p>
                <a href="{{ route('users.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Ajouter un utilisateur
                </a>
            </div>
        @else
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th class="user-column">Utilisateur</th>
                            <th>Contact</th>
                            <th>Rôle</th>
                            <th>Statut</th>
                            <th>Créé le</th>
                            <th class="actions-column">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        <tr data-role="{{ $user->role_id }}" data-status="{{ $user->status ? 'active' : 'inactive' }}">
                            <td>
                                <div class="user-info">
                                    <div class="user-avatar">
                                        @if($user->gender == 'Femme')
                                            <i class="fas fa-female"></i>
                                        @else
                                            <i class="fas fa-male"></i>
                                        @endif
                                    </div>
                                    <div class="user-details">
                                        <strong>{{ $user->name }}</strong>
                                        <small>{{ $user->email }}</small>
                                        @if($user->identity_card_number)
                                        <div class="badge">
                                            <i class="fas fa-id-card"></i> {{ $user->identity_card_number }}
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="contact-info">
                                    <div class="contact-item">
                                        <i class="fas fa-phone"></i>
                                        <span>{{ $user->phone }}</span>
                                    </div>
                                    @if($user->address)
                                    <div class="contact-item">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <span>{{ Str::limit($user->address, 30) }}</span>
                                    </div>
                                    @endif
                                    @if($user->emergency_contact_name)
                                    <div class="contact-item">
                                        <i class="fas fa-user-md"></i>
                                        <span>{{ Str::limit($user->emergency_contact_name, 20) }}</span>
                                    </div>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <span class="role-badge role-{{ strtolower($user->role->name ?? 'user') }}">
                                    {{ $user->role->name ?? 'Utilisateur' }}
                                </span>
                                @if($user->birth_date)
                                <div class="age-info">
                                    <i class="fas fa-birthday-cake"></i>
                                    {{ \Carbon\Carbon::parse($user->birth_date)->age }} ans
                                </div>
                                @endif
                            </td>
                            <td>
                                <div class="status-cell">
                                    <span class="status-badge {{ $user->status ? 'active' : 'inactive' }}">
                                        {{ $user->status ? 'Actif' : 'Inactif' }}
                                    </span>
                                    @if($user->created_by)
                                    <div class="created-by">
                                        <small>Par: {{ $user->creator->name ?? 'Admin' }}</small>
                                    </div>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="date-info">
                                    <div>{{ $user->created_at->format('d/m/Y') }}</div>
                                    <small>{{ $user->created_at->diffForHumans() }}</small>
                                </div>
                            </td>
                            <td>
                                <div class="table-actions">
                                    <a href="{{ route('users.edit', $user->id) }}" class="btn-icon" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    
                                    <button class="btn-icon toggle-status-btn" 
                                            title="{{ $user->status ? 'Désactiver' : 'Activer' }}"
                                            data-id="{{ $user->id }}"
                                            data-status="{{ $user->status ? 1 : 0 }}">
                                        <i class="fas fa-power-off"></i>
                                    </button>
                                    
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn-icon delete-btn" title="Supprimer">
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
            
            <!-- Pagination -->
           
        @endif
    </div>
</div>

<!-- ================== CSS ================== -->
<style>
/* Variables */
:root {
    --primary: #10b981;
    --primary-dark: #059669;
    --primary-light: #d1fae5;
    --secondary: #3b82f6;
    --warning: #f59e0b;
    --danger: #ef4444;
    --info: #06b6d4;
    --dark: #1f2937;
    --light: #f9fafb;
    --gray: #6b7280;
    --gray-light: #e5e7eb;
    --radius: 10px;
    --radius-sm: 6px;
    --shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    --shadow-lg: 0 4px 6px rgba(0, 0, 0, 0.07);
}

/* Conteneur principal */
.users-container {
    padding: 20px;
    max-width: 1400px;
    margin: 0 auto;
}

/* En-tête de page */
.page-header {
    margin-bottom: 25px;
}

.header-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    flex-wrap: wrap;
    gap: 20px;
}

.title-section h1 {
    font-size: 1.8rem;
    color: var(--dark);
    margin-bottom: 5px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.subtitle {
    color: var(--gray);
    font-size: 0.95rem;
}

.header-actions {
    display: flex;
    align-items: center;
    gap: 15px;
    flex-wrap: wrap;
}

.search-box {
    position: relative;
    min-width: 250px;
}

.search-box i {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--gray);
    font-size: 0.9rem;
}

.search-box input {
    width: 100%;
    padding: 10px 15px 10px 35px;
    border: 1px solid var(--gray-light);
    border-radius: var(--radius-sm);
    font-size: 0.9rem;
    background: white;
    transition: border-color 0.2s;
}

.search-box input:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 2px var(--primary-light);
}

.btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 16px;
    border-radius: var(--radius-sm);
    font-weight: 500;
    font-size: 0.9rem;
    text-decoration: none;
    cursor: pointer;
    border: none;
    transition: all 0.2s ease;
}

.btn-primary {
    background: var(--primary);
    color: white;
}

.btn-primary:hover {
    background: var(--primary-dark);
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
}

/* Statistiques rapides */
.quick-stats {
    display: flex;
    gap: 20px;
    padding: 15px;
    background: white;
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    flex-wrap: wrap;
}

.stat-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 10px 20px;
    border-right: 1px solid var(--gray-light);
}

.stat-item:last-child {
    border-right: none;
}

.stat-number {
    font-size: 1.8rem;
    font-weight: 700;
    color: var(--primary);
}

.stat-label {
    font-size: 0.85rem;
    color: var(--gray);
    margin-top: 5px;
}

/* Alertes */
.alert {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 15px 20px;
    border-radius: var(--radius);
    margin-bottom: 20px;
    animation: slideIn 0.3s ease;
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.alert-success {
    background: #dcfce7;
    border: 1px solid #86efac;
}

.alert-danger {
    background: #fee2e2;
    border: 1px solid #fca5a5;
}

.alert-icon {
    font-size: 1.3rem;
}

.alert-success .alert-icon {
    color: #16a34a;
}

.alert-danger .alert-icon {
    color: #dc2626;
}

.alert-content {
    flex: 1;
}

.alert-content h4 {
    margin: 0 0 5px 0;
    font-size: 1rem;
    font-weight: 600;
}

.alert-content p {
    margin: 0;
    font-size: 0.9rem;
}

.alert-close {
    background: none;
    border: none;
    font-size: 1.2rem;
    cursor: pointer;
    color: var(--gray);
    padding: 0;
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.alert-close:hover {
    color: var(--dark);
}

/* Tableau principal */
.table-container {
    background: white;
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    padding: 20px;
    margin-bottom: 30px;
}

.table-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    padding-bottom: 15px;
    border-bottom: 1px solid var(--gray-light);
}

.table-header h3 {
    font-size: 1.3rem;
    color: var(--dark);
    margin: 0;
    display: flex;
    align-items: center;
    gap: 10px;
}

.table-filters {
    display: flex;
    align-items: center;
    gap: 10px;
}

.filter-select {
    padding: 8px 12px;
    border: 1px solid var(--gray-light);
    border-radius: var(--radius-sm);
    background: white;
    color: var(--dark);
    font-size: 0.9rem;
    cursor: pointer;
    min-width: 150px;
}

.filter-select:focus {
    outline: none;
    border-color: var(--primary);
}

/* Table responsive */
.table-responsive {
    overflow-x: auto;
}

.data-table {
    width: 100%;
    border-collapse: collapse;
    min-width: 1000px;
}

.data-table thead {
    background: var(--light);
    border-bottom: 2px solid var(--gray-light);
}

.data-table th {
    padding: 12px 15px;
    text-align: left;
    font-weight: 600;
    color: var(--dark);
    font-size: 0.9rem;
}

.data-table th.user-column {
    min-width: 200px;
}

.data-table th.actions-column {
    min-width: 120px;
}

.data-table tbody tr {
    border-bottom: 1px solid var(--gray-light);
    transition: background 0.2s;
}

.data-table tbody tr:hover {
    background: var(--light);
}

.data-table td {
    padding: 15px;
    font-size: 0.9rem;
    vertical-align: top;
}

/* Informations utilisateur */
.user-info {
    display: flex;
    align-items: center;
    gap: 12px;
}

.user-avatar {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    background: var(--primary-light);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--primary);
    font-size: 1.2rem;
}

.user-avatar i.fa-female {
    color: #ec4899;
}

.user-avatar i.fa-male {
    color: var(--secondary);
}

.user-details {
    display: flex;
    flex-direction: column;
}

.user-details strong {
    color: var(--dark);
    margin-bottom: 2px;
}

.user-details small {
    color: var(--gray);
    font-size: 0.85rem;
}

.badge {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    background: var(--light);
    color: var(--gray);
    padding: 2px 8px;
    border-radius: 10px;
    font-size: 0.75rem;
    margin-top: 5px;
    width: fit-content;
}

/* Informations de contact */
.contact-info {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.contact-item {
    display: flex;
    align-items: center;
    gap: 8px;
    color: var(--gray);
    font-size: 0.85rem;
}

.contact-item i {
    width: 16px;
    color: var(--primary);
}

/* Badges de rôle */
.role-badge {
    display: inline-block;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: capitalize;
}

.role-admin {
    background: #f3e8ff;
    color: #7c3aed;
}

.role-manager {
    background: #dbeafe;
    color: var(--secondary);
}

.role-collector {
    background: var(--primary-light);
    color: var(--primary-dark);
}

.role-user {
    background: var(--light);
    color: var(--gray);
}

.age-info {
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: 0.8rem;
    color: var(--gray);
    margin-top: 5px;
}

/* Statut */
.status-cell {
    display: flex;
    flex-direction: column;
    gap: 5px;
}

.status-badge {
    display: inline-block;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    width: fit-content;
}

.status-badge.active {
    background: var(--primary-light);
    color: var(--primary-dark);
}

.status-badge.inactive {
    background: #fee2e2;
    color: var(--danger);
}

.created-by small {
    font-size: 0.75rem;
    color: var(--gray);
}

/* Date */
.date-info {
    display: flex;
    flex-direction: column;
}

.date-info small {
    color: var(--gray);
    font-size: 0.8rem;
}

/* Actions */
.table-actions {
    display: flex;
    gap: 8px;
}

.btn-icon {
    width: 34px;
    height: 34px;
    border-radius: var(--radius-sm);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: var(--light);
    color: var(--gray);
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: all 0.2s;
    font-size: 0.9rem;
}

.btn-icon:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow);
}

.btn-icon:hover i.fa-edit {
    color: var(--warning);
}

.btn-icon:hover i.fa-power-off {
    color: var(--info);
}

.btn-icon:hover i.fa-trash {
    color: var(--danger);
}

.delete-form {
    display: inline;
}

/* État vide */
.empty-state {
    text-align: center;
    padding: 60px 20px;
}

.empty-state i {
    font-size: 4rem;
    color: var(--gray-light);
    margin-bottom: 20px;
}

.empty-state h3 {
    color: var(--dark);
    margin-bottom: 10px;
}

.empty-state p {
    color: var(--gray);
    margin-bottom: 20px;
}

/* Pagination */
.pagination {
    display: flex;
    justify-content: center;
    margin-top: 30px;
    padding-top: 20px;
    border-top: 1px solid var(--gray-light);
}

.pagination nav {
    display: flex;
    gap: 5px;
}

.pagination .page-item {
    list-style: none;
}

.pagination .page-link {
    padding: 8px 12px;
    border: 1px solid var(--gray-light);
    border-radius: 6px;
    color: var(--dark);
    text-decoration: none;
    font-size: 0.9rem;
    transition: all 0.2s;
}

.pagination .page-link:hover {
    background: var(--primary-light);
    border-color: var(--primary);
}

.pagination .active .page-link {
    background: var(--primary);
    border-color: var(--primary);
    color: white;
}

/* Responsive */
@media (max-width: 768px) {
    .header-content {
        flex-direction: column;
        align-items: stretch;
    }
    
    .header-actions {
        flex-direction: column;
    }
    
    .search-box {
        min-width: 100%;
    }
    
    .quick-stats {
        flex-direction: column;
        gap: 10px;
    }
    
    .stat-item {
        border-right: none;
        border-bottom: 1px solid var(--gray-light);
        padding: 10px 0;
    }
    
    .stat-item:last-child {
        border-bottom: none;
    }
    
    .table-header {
        flex-direction: column;
        align-items: stretch;
        gap: 15px;
    }
    
    .table-filters {
        flex-wrap: wrap;
    }
    
    .filter-select {
        min-width: calc(50% - 5px);
    }
}
</style>

<!-- ================== JavaScript ================== -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Fermeture des alertes
    document.querySelectorAll('.alert-close').forEach(btn => {
        btn.addEventListener('click', function() {
            this.closest('.alert').style.display = 'none';
        });
    });
    
    // Filtrage par rôle
    const roleFilter = document.getElementById('roleFilter');
    if (roleFilter) {
        roleFilter.addEventListener('change', function() {
            const roleId = this.value;
            const rows = document.querySelectorAll('.data-table tbody tr');
            
            rows.forEach(row => {
                if (roleId === 'all' || row.dataset.role === roleId) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }
    
    // Filtrage par statut
    const statusFilter = document.getElementById('statusFilter');
    if (statusFilter) {
        statusFilter.addEventListener('change', function() {
            const status = this.value;
            const rows = document.querySelectorAll('.data-table tbody tr');
            
            rows.forEach(row => {
                if (status === 'all' || row.dataset.status === status) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }
    
    // Recherche en temps réel
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('.data-table tbody tr');
            
            rows.forEach(row => {
                const cells = row.querySelectorAll('td');
                let found = false;
                
                cells.forEach(cell => {
                    if (cell.textContent.toLowerCase().includes(searchTerm)) {
                        found = true;
                    }
                });
                
                row.style.display = found ? '' : 'none';
            });
        });
    }
    
    // Confirmation de suppression
    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            if (confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ? Cette action est irréversible.')) {
                this.closest('.delete-form').submit();
            }
        });
    });
    
    // Toggle status (activation/désactivation)
    document.querySelectorAll('.toggle-status-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const userId = this.dataset.id;
            const currentStatus = parseInt(this.dataset.status);
            const newStatus = currentStatus ? 0 : 1;
            const action = newStatus ? 'activer' : 'désactiver';
            
            if (confirm(`Voulez-vous vraiment ${action} cet utilisateur ?`)) {
                // Envoyer la requête AJAX pour changer le statut
                fetch(`/users/${userId}/toggle-status`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ status: newStatus })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Mettre à jour l'affichage
                        const statusBadge = this.closest('tr').querySelector('.status-badge');
                        statusBadge.textContent = newStatus ? 'Actif' : 'Inactif';
                        statusBadge.className = newStatus ? 'status-badge active' : 'status-badge inactive';
                        this.dataset.status = newStatus;
                        this.title = newStatus ? 'Désactiver' : 'Activer';
                        
                        // Afficher un message de succès
                        alert(data.message);
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    alert('Une erreur est survenue');
                });
            }
        });
    });
});
</script>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endsection