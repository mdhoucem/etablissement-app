<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasName; // <-- Import requis
use Filament\Panel;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements FilamentUser, HasName
{
    use Notifiable;

    protected $fillable = [
        'nom',
        'email',
        'password',
        'status',
        'last_login',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Indique à Filament quel champ utiliser pour le nom de l'utilisateur
     */
    public function getFilamentName(): string
    {
        return $this->nom ?? 'Utilisateur';
    }

    /**
     * Contrôle d'accès au panneau Filament
     */
    public function canAccessPanel(Panel $panel): bool
    {
        return $this->status === 'actif';
    }
}
