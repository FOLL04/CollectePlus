<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // Identifiant unique de l'utilisateur
            $table->string('name'); // Nom complet
            $table->string('email')->unique(); // Email unique
            $table->timestamp('email_verified_at')->nullable(); // Vérification email
            $table->string('password'); // Mot de passe hashé
            $table->rememberToken(); // Token pour "remember me"

            //  Ajouts spécifiques CollectePlus
            $table->foreignId('role_id')->constrained('roles'); // Rôle lié à la table roles
            $table->string('phone')->nullable(); // Numéro de téléphone
            $table->boolean('status')->default(true); // Statut actif/inactif
            $table->unsignedBigInteger('created_by')->nullable(); // Admin qui a créé le compte

            //  Nouveaux champs demandés
            $table->string('identity_card_number')->nullable(); // Numéro de carte d'identité
            $table->string('address')->nullable(); // Adresse de l'utilisateur
            $table->string('emergency_contact_name')->nullable(); // Nom de la personne à prévenir
            $table->string('emergency_contact_phone')->nullable(); // Téléphone de la personne à prévenir
            $table->enum('gender', ['Homme', 'Femme'])->nullable(); // Sexe
            $table->date('birth_date')->nullable(); // Date de naissance

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
