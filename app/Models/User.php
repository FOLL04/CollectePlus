<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'phone',
        'status',
        'created_by',
        'identity_card_number',
        'address',
        'emergency_contact_name',
        'emergency_contact_phone',
        'gender',
        'birth_date'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'status' => 'boolean',
        'birth_date' => 'date'
    ];

    // Relation avec le rôle
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    // Relation avec l'admin qui a créé l'utilisateur
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Vérifie si l'utilisateur a un rôle spécifique
    public function hasRole($roleName)
    {
        return $this->role && $this->role->name === $roleName;
    }

    public function isRegisseur()
    {
        return $this->hasRole('regisseur');
    }

    public function isAgent()
    {
        return $this->hasRole('agent');
    }

    // Relation avec les collectes (pour les agents)
    public function collectes()
    {
        return $this->hasMany(Collecte::class, 'agent_id');
    }

    // Relation avec les dépôts (pour les agents)
    public function depotsAgent()
    {
        return $this->hasMany(Depot::class, 'agent_id');
    }

    // Relation avec les dépôts (pour les régisseurs)
    public function depotsRegisseur()
    {
        return $this->hasMany(Depot::class, 'regisseur_id');
    }

    // Chaque agent est lié à une seule zone
    public function zone()
    {
        return $this->hasOne(Zone::class, 'agent_id');
    }
}
