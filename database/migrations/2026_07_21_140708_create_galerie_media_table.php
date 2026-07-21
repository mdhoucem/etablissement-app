<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('galerie_media', function (Blueprint $table) {
            $table->id();
            $table->string('titre_fr');
            $table->string('titre_ar')->nullable();
            $table->enum('type', ['photo', 'video'])->default('photo');
            $table->string('fichier')->nullable(); // Image locale ou thumbnail
            $table->string('url_video')->nullable(); // Ex: Lien Youtube/Vimeo si type = video
            $table->text('description_fr')->nullable();
            $table->text('description_ar')->nullable();
            $table->boolean('featured')->default(false);
            $table->enum('status', ['actif', 'inactif'])->default('actif');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('galerie_media');
    }
};
