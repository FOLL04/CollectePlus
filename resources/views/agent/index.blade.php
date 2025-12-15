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
        <button type="submit">Enregistrer et imprimer</button>
    </form>
</div>

<style>
.container { max-width: 500px; margin: 20px auto; padding: 25px; background: white; 
    border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.08); }
.agent-header { background: #d1fae5; padding: 15px; border-radius: 8px; margin-bottom: 25px;
    border-left: 5px solid #10b981; display: flex; justify-content: space-between; 
    align-items: center; flex-wrap: wrap; }
.agent-details { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }
.agent-name, .zone { font-weight: 600; color: #064e3b; }
.separator { color: #6b7280; }
.btn-collectes { background: #10b981; color: white; padding: 5px 12px; border-radius: 20px;
    text-decoration: none; font-size: 0.85rem; transition: all 0.3s; }
.btn-collectes:hover { background: #059669; transform: translateY(-2px); }
.date { color: #065f46; font-weight: 600; font-size: 0.9rem; }
h2 { color: #064e3b; font-size: 1.5rem; margin-bottom: 20px; padding-bottom: 10px;
    border-bottom: 2px solid #10b981; }
.form-group { margin-bottom: 20px; }
.form-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #374151; }
.form-group input, .form-group select { width: 100%; padding: 10px; border: 1px solid #d1d5db;
    border-radius: 6px; font-size: 1rem; }
.form-group input:focus, .form-group select:focus { outline: none; border-color: #10b981;
    box-shadow: 0 0 0 3px rgba(16,185,129,0.1); }
button { width: 100%; padding: 12px; background: #10b981; color: white; border: none;
    border-radius: 6px; font-size: 1rem; font-weight: 600; cursor: pointer; transition: all 0.3s; }
button:hover { background: #059669; transform: translateY(-2px); }
@media (max-width: 640px) { 
    .container { margin: 10px; padding: 20px; }
    .agent-header { flex-direction: column; align-items: flex-start; gap: 10px; }
    .agent-details { flex-direction: column; align-items: flex-start; }
}
</style>
