<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Collecte extends Model
{
    use HasFactory;

    protected $fillable = [
        'agent_id',
        'place_id',
        'zone_id',
        'type_collecte',
        'montant',
        'date_collecte',
        'numero_recu',
        'observations',
        'statut',
    ];

    protected $casts = [
        'date_collecte' => 'date',
        'montant' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();
        
        // Générer le numéro de reçu automatiquement
        static::creating(function ($collecte) {
            $collecte->numero_recu = 'COL-' . date('Ymd') . '-' . str_pad(Collecte::whereDate('created_at', today())->count() + 1, 4, '0', STR_PAD_LEFT);
        });
        
        // Associer automatiquement la zone de la place
        static::creating(function ($collecte) {
            if ($collecte->place && $collecte->place->hangar && $collecte->place->hangar->zone) {
                $collecte->zone_id = $collecte->place->hangar->zone->id;
            }
        });
    }

    // Relations
    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function place()
    {
        return $this->belongsTo(Place::class);
    }

    public function zone()
    { 
        return $this->belongsTo(Zone::class); 
    }
    
    public function hangar()
    {
        return $this->hasOneThrough(Hangar::class, Place::class, 'id', 'id', 'place_id', 'hangar_id');
    }
    
    public function marche()
    {
        return $this->hasOneThrough(Marche::class, Zone::class, 'id', 'id', 'zone_id', 'marche_id');
    }
    
    // Scopes
    public function scopeToday($query)
    {
        return $query->whereDate('date_collecte', today());
    }
    
    public function scopeByAgent($query, $agentId)
    {
        return $query->where('agent_id', $agentId);
    }
    
    public function scopeJournalier($query)
    {
        return $query->where('type_collecte', 'journalier');
    }
    
    public function scopeMensuel($query)
    {
        return $query->whereIn('type_collecte', ['loyer', 'mensuel']);
    }
    
    // Accesseurs
    public function getFormattedMontantAttribute()
    {
        return number_format($this->montant, 0, ',', ' ') . ' FCFA';
    }
    
    public function getFormattedDateAttribute()
    {
        return $this->date_collecte->format('d/m/Y');
    }
    
    public function getHeureCollecteAttribute()
    {
        return $this->created_at->format('H:i');
    }
}