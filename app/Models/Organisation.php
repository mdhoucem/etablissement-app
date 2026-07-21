<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organisation extends Model
{
    protected $fillable = [
        'nom_fr',
        'nom_ar',
        'logo',
        'adresse_fr',
        'adresse_ar',
        'telephone',
        'numero_vert',
        'email',
        'reseaux_sociaux',
        'meta_description_fr_default',
        'meta_description_ar_default',
        'og_image_default',
        'status',
    ];

    protected $casts = [
        'reseaux_sociaux' => 'array',
    ];
}
