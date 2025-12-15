<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Marche;


class Marche extends Model
{

    use HasFactory;

    
    protected $fillable = ['nom', 'localisation', 'description', 'created_by'];

    // Un marché appartient à un admin
    public function admin()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Un marché contient plusieurs zones
    public function zones()
    {
        return $this->hasMany(Zone::class);
    }


   public function collectes()
{
    return $this->hasManyThrough(
        Collecte::class,   // modèle cible
        Zone::class,       // modèle intermédiaire
        'marche_id',       // clé étrangère sur Zone
        'agent_id',        // clé étrangère sur Collecte
        'id',              // clé locale sur Marche
        'agent_id'         // clé locale sur Zone (si Zone a agent_id)
    );
}


        
}
