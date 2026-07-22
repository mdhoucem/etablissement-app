<?php

namespace App\Livewire;

use App\Models\GroupeService;
use App\Models\Service;
use Livewire\Component;
use Livewire\WithPagination;

class ServicesList extends Component
{
    use WithPagination;

    public string $search = '';

    public ?int $groupeServiceId = null;

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingGroupeServiceId(): void
    {
        $this->resetPage();
    }

    public function resetFilters(): void
    {
        $this->reset('search', 'groupeServiceId');
        $this->resetPage();
    }

    public function render()
    {
        $locale = app()->getLocale();
        $titreField = "titre_{$locale}";

        $services = Service::query()
            ->where('status', 'actif')
            ->when($this->groupeServiceId, fn ($q) => $q->where('groupe_service_id', $this->groupeServiceId))
            ->when($this->search, function ($q) use ($titreField) {
                $q->where(function ($q2) use ($titreField) {
                    $q2->where('titre_fr', 'like', "%{$this->search}%")
                        ->orWhere('titre_ar', 'like', "%{$this->search}%");
                });
            })
            ->with('groupeService')
            ->orderByDesc('featured')
            ->orderByDesc('date_publication')
            ->paginate(9);

        $groupes = GroupeService::where('status', 'actif')
            ->orderBy("titre_{$locale}")
            ->get();

        return view('livewire.services-list', [
            'services' => $services,
            'groupes' => $groupes,
            'locale' => $locale,
        ]);
    }
}
