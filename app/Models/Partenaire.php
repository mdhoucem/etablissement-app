<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Partenaire extends Model
{
    protected $fillable = [
        'nom',
        'logo',
        'site_web',
        'type_partenariat',
        'ordre_affichage',
        'status',
    ];
}
