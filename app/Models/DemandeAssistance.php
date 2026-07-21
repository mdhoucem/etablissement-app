<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DemandeAssistance extends Model
{
    protected $fillable = [
        'numero_suivi',
        'service_id',
        'nom_complet',
        'cin',
        'telephone',
        'email',
        'description',
        'pieces_justificatives',
        'statut',
    ];

    protected $casts = [
        'pieces_justificatives' => 'array', // Conversion automatique JSON <=> Array PHP
    ];

    /**
     * Génération automatique du Numéro de Suivi à la création
     */
    protected static function booted(): void
    {
        static::creating(function ($demande) {
            if (empty($demande->numero_suivi)) {
                $year = date('Y');
                $count = static::whereYear('created_at', $year)->count() + 1;
                $demande->numero_suivi = sprintf('DEM-%s-%04d', $year, $count);
            }
        });
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
}
