<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('groupe_service_id')->constrained('groupe_services')->cascadeOnDelete();
            $table->string('titre_fr');
            $table->string('titre_ar');
            $table->string('slug')->unique();
            $table->string('type_service')->nullable();
            $table->text('description_fr')->nullable();
            $table->text('description_ar')->nullable();
            $table->text('documents_requis_fr')->nullable();
            $table->text('documents_requis_ar')->nullable();
            $table->boolean('featured')->default(false);
            $table->enum('status', ['actif', 'inactif'])->default('actif');
            $table->timestamp('date_publication')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
