<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GroupeService extends Model
{
    protected $fillable = [
        'titre_fr',
        'titre_ar',
        'description_fr',
        'description_ar',
        'icone',
        'status',
    ];

    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }
}
