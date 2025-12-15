<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('zones', function (Blueprint $table) {
            $table->id(); // Identifiant unique de la zone

            // Lien vers le marché
            $table->foreignId('marche_id')
                  ->constrained('marches')
                  ->onDelete('cascade');

            $table->string('nom_zone'); // Nom de la zone
            $table->text('description')->nullable(); // Description optionnelle

            // Agent responsable de la zone
            $table->foreignId('agent_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            $table->timestamps(); // Dates de création et mise à jour
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('zones');
    }
};
