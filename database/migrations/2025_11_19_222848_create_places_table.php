<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('places', function (Blueprint $table) {
            $table->id(); // Identifiant unique de la place ou boutique

            // Lien vers le hangar (obligatoire)
            $table->foreignId('hangar_id')
                  ->constrained('hangars')
                  ->onDelete('cascade'); 
            // Si un hangar est supprimé, les places associées le sont aussi

            $table->string('numero_place'); // Numéro de la place (identifiant métier)

            $table->enum('type_place', ['hangar', 'boutique'])
                  ->default('hangar'); // Type de place

            $table->decimal('loyer_mensuel', 10, 2)->nullable(); // Loyer mensuel (optionnel)
            $table->decimal('taxe_mensuelle', 10, 2)->nullable(); // Taxe mensuelle (optionnelle)

            $table->timestamps(); // Dates de création et de mise à jour
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('places');
    }
};
