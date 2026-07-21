<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Actualite extends Model
{
    protected $fillable = [
        'titre_fr',
        'titre_ar',
        'slug',
        'image',
        'galerie_photos',
        'resume_fr',
        'resume_ar',
        'contenu_fr',
        'contenu_ar',
        'type',
        'date_evenement',
        'lieu_evenement',
        'featured',
        'status',
        'date_publication',
    ];

    protected $casts = [
        'galerie_photos' => 'array', // Convertit le JSON en tableau automatiquement
        'featured' => 'boolean',
        'date_evenement' => 'datetime',
        'date_publication' => 'datetime',
    ];
}
