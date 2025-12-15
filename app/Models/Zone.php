<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Zone extends Model
{
    use HasFactory;

    protected $fillable = ['nom_zone', 'marche_id', 'agent_id'];

    public function marche()
    {
        return $this->belongsTo(Marche::class, 'marche_id');
    }

    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function hangars()
    {
        return $this->hasMany(Hangar::class, 'zone_id');
    }

    public function places()
    {
        return $this->hasManyThrough(Place::class, Hangar::class, 'zone_id', 'hangar_id');
    }
}
