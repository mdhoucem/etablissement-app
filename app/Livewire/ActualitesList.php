<?php

namespace App\Livewire;

use App\Models\Actualite;
use Livewire\Component;
use Livewire\WithPagination;

class ActualitesList extends Component
{
    use WithPagination;

    public string $search = '';
    public string $category = 'all';

    // Réinitialiser la pagination lors d'une recherche
    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingCategory(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Actualite::query();

        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('content', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->category !== 'all') {
            $query->where('category', $this->category);
        }

        $actualites = $query->latest()->paginate(6);

        return view('livewire.actualites-list', [
            'actualites' => $actualites,
        ]);
    }
}
