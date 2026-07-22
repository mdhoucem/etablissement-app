<?php

namespace App\Livewire;

use App\Models\Actualite;
use Livewire\Component;

class ActualiteDetail extends Component
{
    public Actualite $actualite;

    public function mount($id): void
    {
        $this->actualite = Actualite::findOrFail($id);
    }

    public function render()
    {
        // Récupérer 3 autres actualités récentes (excluant celle en cours de lecture)
        $recentes = Actualite::where('id', '!=', $this->actualite->id)
            ->latest()
            ->take(3)
            ->get();

        return view('livewire.actualite-detail', [
            'recentes' => $recentes,
        ]);
    }
}
