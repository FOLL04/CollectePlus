<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
                    // 🔽 Insertion des rôles par défaut
                    Role::firstOrCreate(
                ['name' => 'admin'],
                ['description' => 'Administrateur du système']
            );

            Role::firstOrCreate(
                ['name' => 'agent'],
                ['description' => 'Agent de collecte']
            );

            Role::firstOrCreate(
                ['name' => 'regisseur'],
                ['description' => 'Régisseur qui reçoit les dépôts']
            );

            Role::firstOrCreate(
                ['name' => 'user'],
                ['description' => 'Utilisateur standard ou marchand']
            );

    }
}
