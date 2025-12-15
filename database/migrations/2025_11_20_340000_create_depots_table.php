<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
     {
        Schema::create('depots', function (Blueprint $table) {
        $table->id(); // Identifiant unique du dépôt

        // Régisseur qui reçoit
        $table->foreignId('regisseur_id')->constrained('users')->onDelete('cascade');
        $table->foreignId('agent_id')->constrained('users')->onDelete('cascade');// Agent qui dépose
        $table->decimal('montant', 10, 2); // Montant du dépôt
        $table->date('date_depot'); // Date du dépôt
        $table->string('recu_path')->nullable(); // Chemin du reçu PDF généré
        $table->string('observations')->nullable();
        $table->string('numero_recu')->nullable();
        $table->timestamps();
    });

    }

    public function down(): void
    {
        Schema::dropIfExists('depots');
    }
};
