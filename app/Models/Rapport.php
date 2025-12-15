<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rapport extends Model
{
    protected $fillable = [
        'user_id',
        'titre',
        'fichier'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}