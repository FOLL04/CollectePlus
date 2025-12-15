<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rapports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // lien avec l'utilisateur
            $table->string('titre');               // titre du rapport
            $table->text('description')->nullable(); // description ou résumé
            $table->string('fichier')->nullable(); // chemin du fichier PDF généré
            $table->timestamps();

            // clé étrangère vers la table users
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rapports');
    }
};
