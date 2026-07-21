<?php

namespace Database\Seeders; // <-- Anti-slash obligatoire ici

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Organisation;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Administrateur unique
        User::create([
            'nom' => 'Admin Etablissement',
            'email' => 'admin@etablissement.tn',
            'password' => Hash::make('password123'),
            'status' => 'actif',
        ]);

        // Organisation globale
        Organisation::create([
            'nom_fr' => 'Établissement des Ayants Droit et Blessés',
            'nom_ar' => 'مؤسسة فداء لرعاية ضحايا الاعتداءات الإرهابية',
            'adresse_fr' => 'Tunis, Tunisie',
            'adresse_ar' => 'تونس، تونس',
            'telephone' => '+216 71 000 000',
            'numero_vert' => '80 100 000',
            'email' => 'contact@etablissement.tn',
            'status' => 'actif',
        ]);
    }
}
