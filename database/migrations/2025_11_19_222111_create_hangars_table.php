<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('hangars', function (Blueprint $table) {
            $table->id(); // Identifiant unique du hangar
            $table->string('code'); // Code du hangar (ex: A, B, C...)

            // Lien vers la zone
            $table->foreignId('zone_id')
                  ->constrained('zones')
                  ->onDelete('cascade');

            $table->string('type')->default('standard'); // Type de hangar (standard, boutique, etc.)

            $table->timestamps(); // Dates de création et mise à jour
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hangars');
    }
};
