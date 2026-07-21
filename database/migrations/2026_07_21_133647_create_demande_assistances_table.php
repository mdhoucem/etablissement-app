<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('demande_assistances', function (Blueprint $table) {
            $table->id();
            $table->string('numero_suivi')->unique();
            $table->foreignId('service_id')->nullable()->constrained('services')->nullOnDelete();
            $table->string('nom_complet');
            $table->string('cin', 20);
            $table->string('telephone');
            $table->string('email')->nullable();
            $table->text('description');

            // Stockage direct des pièces justificatives (JSON)
            $table->json('pieces_justificatives')->nullable();

            $table->enum('statut', ['en_attente', 'en_cours', 'traitee', 'rejetee'])->default('en_attente');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('demande_assistances');
    }
};
