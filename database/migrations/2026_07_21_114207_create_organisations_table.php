<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('organisations', function (Blueprint $table) {
            $table->id();
            $table->string('nom_fr');
            $table->string('nom_ar');
            $table->string('logo')->nullable();
            $table->string('adresse_fr')->nullable();
            $table->string('adresse_ar')->nullable();
            $table->string('telephone')->nullable();
            $table->string('numero_vert')->nullable();
            $table->string('email')->nullable();
            $table->json('reseaux_sociaux')->nullable();
            $table->string('meta_description_fr_default')->nullable();
            $table->string('meta_description_ar_default')->nullable();
            $table->string('og_image_default')->nullable();
            $table->enum('status', ['actif', 'inactif'])->default('actif');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('organisations');
    }
};
