<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Depot extends Model
{
    use HasFactory;

    protected $fillable = ['regisseur_id', 'agent_id', 'montant', 'date_depot', 'recu_path', 'observations', 'numero_recu'];

    // Un dépôt appartient à un régisseur
    public function regisseur()
    {
        return $this->belongsTo(User::class, 'regisseur_id');
    }

    // Un dépôt appartient à un agent
    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }
    
}
