<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //Model pour la table roles
 
    protected $fillable = ['name', 'description'];

    // Un rôle peut avoir plusieurs utilisateurs
    public function users()
    {
        return $this->hasMany(User::class);
    }
}


