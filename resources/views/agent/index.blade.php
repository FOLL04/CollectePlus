@section('content')
<div class="container">
    <div class="agent-header">
        <div class="agent-details">
            <span class="agent-name">{{ $agent->name }}</span>
            <span class="separator">|</span>
            <span class="zone">{{ $zone ? $zone->nom_zone : 'Non définie' }}</span>
            <a href="{{ route('agent.collectes.journalier') }}" class="btn-collectes">
                Voir mes collectes du jour
            </a>
        </div>
        <div class="date">{{ date('d/m/Y H:i') }}</div>
    </div>

    <h2>Nouvelle collecte</h2>
    <form action="{{ route('agent.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Numéro de place</label>
            <input type="text" name="numero_place" placeholder="A001" required>
        </div>
        <div class="form-group">
            <label>Type de collecte</label>
            <select name="type_collecte" required>
                <option value="journalier">Journalier</option>
                <option value="loyer">Loyer</option>
                <option value="mensuel">Mensuel</option>
                <option value="taxe">Taxe</option>
                <option value="amende">Amende</option>
            </select>
        </div>
        <div class="form-group">
            <label>Montant</label>
            <input type="number" name="montant" placeholder="1000" required>
        </div>
        <input type="hidden" name="date_collecte" value="{{ date('Y-m-d') }}">
        <button type="submit" class="submit-btn">Enregistrer et imprimer</button>
    </form>
</div>

<style>
/* Variables pour maintenir la cohérence */
:root {
    --primary-color: #10b981;
    --primary-dark: #059669;
    --primary-light: #d1fae5;
    --text-dark: #064e3b;
    --text-medium: #374151;
    --border-color: #d1d5db;
    --shadow-color: rgba(0,0,0,0.08);
    --white: #ffffff;
    --radius: 8px;
    --transition: all 0.3s ease;
}

/* Container responsive */
.container {
    max-width: 500px;
    width: 100%;
    margin: 20px auto;
    padding: 25px;
    background: var(--white);
    border-radius: var(--radius);
    box-shadow: 0 4px 12px var(--shadow-color);
    box-sizing: border-box;
}

/* Agent header responsive */
.agent-header {
    background: var(--primary-light);
    padding: 20px;
    border-radius: var(--radius);
    margin-bottom: 30px;
    border-left: 5px solid var(--primary-color);
    display: flex;
    flex-direction: column;
    gap: 15px;
}

/* Layout pour desktop */
@media (min-width: 768px) {
    .agent-header {
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
    }
}

.agent-details {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    gap: 10px;
    flex: 1;
}

/* Layout pour desktop */
@media (min-width: 640px) {
    .agent-details {
        flex-direction: row;
        align-items: center;
        flex-wrap: wrap;
    }
}

.agent-name, .zone {
    font-weight: 600;
    color: var(--text-dark);
    font-size: 1rem;
    line-height: 1.4;
}

.separator {
    color: #6b7280;
    display: none; /* Masqué sur mobile */
}

@media (min-width: 640px) {
    .separator {
        display: inline-block;
    }
}

.btn-collectes {
    background: var(--primary-color);
    color: var(--white);
    padding: 8px 16px;
    border-radius: 20px;
    text-decoration: none;
    font-size: 0.9rem;
    font-weight: 500;
    transition: var(--transition);
    display: inline-block;
    text-align: center;
    white-space: nowrap;
    margin-top: 5px;
}

.btn-collectes:hover {
    background: var(--primary-dark);
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.date {
    color: var(--text-dark);
    font-weight: 600;
    font-size: 0.95rem;
    text-align: left;
    margin-top: 5px;
}

@media (min-width: 768px) {
    .date {
        text-align: right;
        margin-top: 0;
        min-width: 150px;
    }
}

/* Titre */
h2 {
    color: var(--text-dark);
    font-size: 1.5rem;
    margin-bottom: 25px;
    padding-bottom: 12px;
    border-bottom: 2px solid var(--primary-color);
    font-weight: 700;
    line-height: 1.3;
}

/* Formulaire */
.form-group {
    margin-bottom: 25px;
    width: 100%;
}

.form-group label {
    display: block;
    margin-bottom: 10px;
    font-weight: 600;
    color: var(--text-medium);
    font-size: 0.95rem;
}

.form-group input, 
.form-group select {
    width: 100%;
    padding: 12px 15px;
    border: 1px solid var(--border-color);
    border-radius: 6px;
    font-size: 1rem;
    box-sizing: border-box;
    transition: var(--transition);
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    background-color: var(--white);
}

/* Placeholder styling */
.form-group input::placeholder {
    color: #9ca3af;
}

/* Focus states */
.form-group input:focus, 
.form-group select:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.15);
    transform: translateY(-1px);
}

/* Pour les select sur mobile */
.form-group select {
    background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right 15px center;
    background-size: 16px;
    padding-right: 45px;
}

/* Bouton de soumission */
.submit-btn {
    width: 100%;
    padding: 15px;
    background: var(--primary-color);
    color: var(--white);
    border: none;
    border-radius: 6px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: var(--transition);
    margin-top: 10px;
    box-sizing: border-box;
    letter-spacing: 0.5px;
    text-transform: uppercase;
}

.submit-btn:hover {
    background: var(--primary-dark);
    transform: translateY(-3px);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
}

.submit-btn:active {
    transform: translateY(-1px);
    box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
}

/* Media Queries pour différentes tailles d'écran */

/* Très petits écrans (mobile portrait) */
@media (max-width: 375px) {
    .container {
        padding: 20px 15px;
        margin: 10px;
        border-radius: 6px;
    }
    
    .agent-header {
        padding: 15px;
        margin-bottom: 20px;
    }
    
    h2 {
        font-size: 1.3rem;
        margin-bottom: 20px;
    }
    
    .btn-collectes {
        padding: 7px 14px;
        font-size: 0.85rem;
    }
    
    .submit-btn {
        padding: 13px;
        font-size: 0.95rem;
    }
}

/* Mobiles */
@media (max-width: 640px) {
    .container {
        padding: 20px;
        margin: 15px;
    }
    
    .agent-details {
        width: 100%;
    }
    
    .agent-name, .zone {
        font-size: 0.95rem;
    }
    
    .date {
        width: 100%;
        text-align: left;
    }
}

/* Tablettes */
@media (min-width: 641px) and (max-width: 1024px) {
    .container {
        max-width: 600px;
        padding: 30px;
    }
    
    .agent-header {
        padding: 25px;
    }
    
    h2 {
        font-size: 1.6rem;
    }
}

/* Desktop */
@media (min-width: 1025px) {
    .container {
        max-width: 550px;
        margin: 30px auto;
    }
    
    .agent-header {
        padding: 25px;
    }
    
    .agent-name, .zone {
        font-size: 1.05rem;
    }
    
    .btn-collectes {
        font-size: 0.95rem;
        padding: 9px 18px;
    }
    
    .form-group input, 
    .form-group select {
        padding: 14px 18px;
        font-size: 1.05rem;
    }
    
    .submit-btn {
        padding: 16px;
        font-size: 1.05rem;
    }
}

/* Large desktop */
@media (min-width: 1440px) {
    .container {
        max-width: 600px;
        margin: 40px auto;
    }
    
    h2 {
        font-size: 1.8rem;
    }
}

/* Pour éviter le zoom sur iOS */
@media screen and (max-width: 768px) {
    input[type="text"],
    input[type="number"],
    select {
        font-size: 16px !important; /* Empêche le zoom sur iOS */
    }
}

/* Animation pour les champs */
.form-group input:focus, 
.form-group select:focus {
    animation: focus-animation 0.3s ease-out;
}

@keyframes focus-animation {
    0% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-2px);
    }
    100% {
        transform: translateY(-1px);
    }
}

/* Support pour le mode somme */
@media (prefers-color-scheme: dark) {
    .container {
        background: #1f2937;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }
    
    h2 {
        color: #d1fae5;
    }
    
    .form-group label {
        color: #e5e7eb;
    }
    
    .form-group input,
    .form-group select {
        background-color: #374151;
        border-color: #4b5563;
        color: #f3f4f6;
    }
}
</style>