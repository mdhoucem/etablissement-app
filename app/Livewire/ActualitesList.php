<?php

namespace App\Livewire;

use App\Models\Actualite;
use Livewire\Component;
use Livewire\WithPagination;

class ActualitesList extends Component
{
    use WithPagination;

    public string $typeFiltre = '';

    public function updatingTypeFiltre(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $locale = app()->getLocale();

        $actualites = Actualite::query()
            ->where('status', 'publie')
            ->when($this->typeFiltre, fn ($q) => $q->where('type', $this->typeFiltre))
            ->orderByDesc('featured')
            ->orderByDesc('date_publication')
            ->paginate(6);

        return view('livewire.actualites-list', [
            'actualites' => $actualites,
            'locale' => $locale,
        ]);
    }
}
