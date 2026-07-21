<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GalerieMedia extends Model
{
    protected $table = 'galerie_media';

    protected $fillable = [
        'titre_fr',
        'titre_ar',
        'type',
        'fichier',
        'url_video',
        'description_fr',
        'description_ar',
        'featured',
        'status',
    ];

    protected $casts = [
        'featured' => 'boolean',
    ];
}
