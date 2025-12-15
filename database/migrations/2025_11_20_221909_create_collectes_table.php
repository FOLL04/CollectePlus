<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('collectes', function (Blueprint $table) {
            $table->id();
            
            // Agent qui effectue la collecte
            $table->foreignId('agent_id')
                  ->constrained('users')
                  ->onDelete('cascade');
            
            // Place (boutique/hangar) concernée
            $table->foreignId('place_id')
                  ->constrained('places')
                  ->onDelete('cascade');
            
            // Zone (pour faciliter les rapports)
            $table->foreignId('zone_id')
                  ->constrained('zones')
                  ->onDelete('cascade');
            
            // Type de collecte : journalier, loyer, mensuel, etc.
            $table->enum('type_collecte', [
                'journalier',   // 100F quotidien
                'loyer',        // Loyer boutique
                'mensuel',      // Abonnement mensuel
                'taxe',         // Taxe spéciale
                'amende'        // Amende
            ])->default('journalier');
            
            // Montant collecté
            $table->decimal('montant', 10, 2);
            
            // Date de la collecte
            $table->date('date_collecte');
            
            // Numéro de reçu automatique
            $table->string('numero_recu')->nullable();
            
            // Observations
            $table->text('observations')->nullable();
            
            // Statut
            $table->enum('statut', ['collectée', 'validée', 'annulée'])->default('collectée');
            
            $table->timestamps();
            
            // Index
            $table->index(['agent_id', 'date_collecte']);
            $table->index(['place_id', 'date_collecte']);
            $table->index('type_collecte');
            $table->index('numero_recu');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('collectes');
    }
};