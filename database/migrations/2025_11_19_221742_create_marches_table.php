<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('marches', function (Blueprint $table) {
            $table->id(); // Identifiant unique du marché
            $table->string('nom'); // Nom du marché
            $table->string('localisation')->nullable(); // Localisation géographique
            $table->text('description')->nullable(); // Description optionnelle

            // Admin ou utilisateur qui a créé le marché
            $table->foreignId('created_by')
                  ->constrained('users')
                  ->onDelete('cascade');

            $table->timestamps(); // Dates de création et mise à jour
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('marches');
    }
};
