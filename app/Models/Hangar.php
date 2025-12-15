<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Hangar extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'zone_id', 'type'];

    public function zone()
    {
        return $this->belongsTo(Zone::class, 'zone_id');
    }

    public function places()
    {
        return $this->hasMany(Place::class, 'hangar_id');
    }
}
