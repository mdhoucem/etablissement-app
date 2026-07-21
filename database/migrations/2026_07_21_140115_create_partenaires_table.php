<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('partenaires', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('logo'); // Chemin vers le fichier image
            $table->string('site_web')->nullable();
            $table->string('type_partenariat')->nullable(); // ex: Institutionnel, Financier, Technique
            $table->integer('ordre_affichage')->default(0);
            $table->enum('status', ['actif', 'inactif'])->default('actif');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('partenaires');
    }
};
