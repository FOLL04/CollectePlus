<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Place extends Model
{
    use HasFactory;

    protected $fillable = [
        'hangar_id',
        'numero_place',
        'type_place',
        'loyer_mensuel',
        'taxe_mensuelle',
    ];

    public function hangar()
    {
        return $this->belongsTo(Hangar::class, 'hangar_id');
    }

    public function zone()
    {
        return $this->hangar ? $this->hangar->zone : null;
    }

    public function marche()
    {
        return $this->hangar && $this->hangar->zone
            ? $this->hangar->zone->marche : null;
    }

    public function isBoutique(): bool
    {
        return $this->type_place === 'boutique' || is_null($this->hangar_id);
    }

    public function isHangar(): bool
    {
        return $this->type_place === 'hangar' && !is_null($this->hangar_id);
    }
}
