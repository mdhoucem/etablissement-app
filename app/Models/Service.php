<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Service extends Model
{
    protected $fillable = [
        'groupe_service_id',
        'titre_fr',
        'titre_ar',
        'slug',
        'type_service',
        'description_fr',
        'description_ar',
        'documents_requis_fr',
        'documents_requis_ar',
        'featured',
        'status',
        'date_publication',
    ];

    protected $casts = [
        'featured' => 'boolean',
        'date_publication' => 'datetime',
    ];

    public function groupeService(): BelongsTo
    {
        return $this->belongsTo(GroupeService::class);
    }
}
