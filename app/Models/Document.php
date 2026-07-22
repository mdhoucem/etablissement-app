<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'categorie',
        'type',
        'titre_fr',
        'titre_ar',
        'slug',
        'description_fr',
        'description_ar',
        'fichier',
        'format',
        'taille',
        'status',
        'date_publication',
        'user_id',
    ];

    protected $casts = [
        'date_publication' => 'datetime',
    ];

    /**
     * Relation avec l'utilisateur (publieur)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
