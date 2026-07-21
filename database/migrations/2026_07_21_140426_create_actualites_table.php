<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('actualites', function (Blueprint $table) {
            $table->id();
            $table->string('titre_fr');
            $table->string('titre_ar');
            $table->string('slug')->unique();
            $table->string('image')->nullable();
            $table->text('resume_fr')->nullable();
            $table->text('resume_ar')->nullable();
            $table->longText('contenu_fr')->nullable();
            $table->longText('contenu_ar')->nullable();
            $table->enum('type', ['actualite', 'evenement', 'annonce'])->default('actualite');
            $table->dateTime('date_evenement')->nullable(); // Pour les événements
            $table->string('lieu_evenement')->nullable();
            $table->boolean('featured')->default(false);
            $table->enum('status', ['brouillon', 'publie', 'archive'])->default('publie');
            $table->timestamp('date_publication')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('actualites');
    }
};
