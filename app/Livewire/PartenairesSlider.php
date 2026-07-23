<?php

namespace App\Livewire;

use App\Models\Partenaire;
use Livewire\Component;

class PartenairesSlider extends Component
{
    public function render()
    {
        return view('livewire.partenaires-slider', [
            'partenaires' => Partenaire::where('status', 'actif')
                ->orderBy('ordre_affichage')
                ->get(),
        ]);
    }
}
