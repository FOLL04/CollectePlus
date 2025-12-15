<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\Marche;
use App\Models\Zone;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1 Créer les rôles (sans doublons)
        $adminRole = Role::firstOrCreate(
            ['name' => 'admin'],
            ['description' => 'Administrateur']
        );

        $agentRole = Role::firstOrCreate(
            ['name' => 'agent'],
            ['description' => 'Agent de collecte']
        );

        $regisseurRole = Role::firstOrCreate(
            ['name' => 'regisseur'],
            ['description' => 'Régisseur']
        );

        // 2 Créer un Admin par défaut (sans doublons)
        $admin = User::firstOrCreate(
            ['email' => 'admin@plus.com'],
            [
                'name' => 'Super Admin',
                'password' => 'admin01', // ⚠️ à hasher en prod
                'role_id' => $adminRole->id,
                'phone' => '90000000',
                'status' => true,
            ]
        );

        // 3 Créer un Agent par défaut (sans doublons)
        $agent = User::firstOrCreate(
            ['email' => 'agent@plus.com'],
            [
                'name' => 'Agent Démo',
                'password' => 'agent01', // ⚠️ à hasher en prod
                'role_id' => $agentRole->id,
                'phone' => '91111111',
                'status' => true,
                'created_by' => $admin->id,
            ]
        );

        // 4 Créer un Régisseur par défaut (sans doublons)
        $regisseur = User::firstOrCreate(
            ['email' => 'regisseur@plus.com'],
            [
                'name' => 'Régisseur Démo',
                'password' => 'regisseur01', // ⚠️ à hasher en prod
                'role_id' => $regisseurRole->id,
                'phone' => '92222222',
                'status' => true,
                'created_by' => $admin->id,
            ]
        );

        // 5 Créer deux marchés (sans doublons)
        $marche1 = Marche::firstOrCreate(
            ['nom' => 'Marché de Bè'],
            [
                'localisation' => 'Lomé centre',
                'description' => 'Marché principal du Golfe1',
                'created_by' => $admin->id,
            ]
        );

        $marche2 = Marche::firstOrCreate(
            ['nom' => 'Marché Arigo'],
            [
                'localisation' => 'Bè périphérie',
                'description' => 'Marché périphérique',
                'created_by' => $admin->id,
            ]
        );

        // 6 Créer deux zones par marché (sans doublons)
        Zone::firstOrCreate(
            ['nom_zone' => 'Zone A', 'marche_id' => $marche1->id],
            [
                'description' => 'Zone principale',
                'agent_id' => $agent->id,
            ]
        );

        Zone::firstOrCreate(
            ['nom_zone' => 'Zone B', 'marche_id' => $marche1->id],
            [
                'description' => 'Zone secondaire',
                'agent_id' => $agent->id,
            ]
        );

        Zone::firstOrCreate(
            ['nom_zone' => 'Zone C', 'marche_id' => $marche2->id],
            [
                'description' => 'Zone principale',
                'agent_id' => $agent->id,
            ]
        );

        Zone::firstOrCreate(
            ['nom_zone' => 'Zone D', 'marche_id' => $marche2->id],
            [
                'description' => 'Zone secondaire',
                'agent_id' => $agent->id,
            ]
        );

        // 7 Appel des autres seeders (si besoin)
        $this->call(RoleSeeder::class);
    }
}
