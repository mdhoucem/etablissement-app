<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();

            // Catégories & Types normalisés (Enum)
            $table->enum('categorie', [
                'administratif',
                'pedagogique',
                'reglementation',
                'procedures',
            ])->default('administratif');

            $table->enum('type', [
                'formulaire',
                'decret_loi',
                'rapport',
                'guide',
                'autre',
            ])->default('formulaire');

            // Informations générales (Français & Arabe)
            $table->string('titre_fr');
            $table->string('titre_ar')->nullable();
            $table->string('slug')->unique();
            $table->text('description_fr')->nullable();
            $table->text('description_ar')->nullable();

            // Fichier & Métadonnées
            $table->string('fichier'); // Chemin sur le disque
            $table->string('format')->nullable(); // Extension technique (ex: PDF, DOCX, ZIP)
            $table->string('taille')->nullable(); // Taille lisible (ex: "2.4 MB")

            // Publication & Statut
            $table->enum('status', ['brouillon', 'publie', 'archive'])->default('publie');
            $table->timestamp('date_publication')->nullable();

            // Auteur / Utilisateur ayant publié le document
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
