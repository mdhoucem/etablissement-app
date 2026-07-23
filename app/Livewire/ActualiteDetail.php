<?php

namespace App\Livewire;

use App\Models\Actualite;
use Livewire\Component;

class ActualiteDetail extends Component
{
    public Actualite $actualite;

    public function mount(int $id): void
    {
        $this->actualite = Actualite::where('id', $id)
            ->where('status', 'publie')
            ->firstOrFail();
    }

    public function render()
    {
        return view('livewire.actualite-detail', [
            'locale' => app()->getLocale(),
        ]);
    }
}
