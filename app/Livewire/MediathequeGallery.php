<?php

namespace App\Livewire;

use App\Models\GalerieMedia;
use Livewire\Component;
use Livewire\WithPagination;

class MediathequeGallery extends Component
{
    use WithPagination;

    public string $typeFiltre = '';
    public string $search = '';

    // Lightbox state
    public ?int $activeMediaId = null;

    public function updatingTypeFiltre(): void { $this->resetPage(); }
    public function updatingSearch(): void { $this->resetPage(); }

    public function openLightbox(int $id): void
    {
        $this->activeMediaId = $id;
    }

    public function closeLightbox(): void
    {
        $this->activeMediaId = null;
    }

    public function nextMedia(): void
    {
        $ids = $this->getFilteredIds();
        $pos = array_search($this->activeMediaId, $ids);
        $this->activeMediaId = $ids[($pos + 1) % count($ids)] ?? null;
    }

    public function prevMedia(): void
    {
        $ids = $this->getFilteredIds();
        $pos = array_search($this->activeMediaId, $ids);
        $this->activeMediaId = $ids[($pos - 1 + count($ids)) % count($ids)] ?? null;
    }

    protected function getFilteredIds(): array
    {
        return $this->baseQuery()->pluck('id')->toArray();
    }

    protected function baseQuery()
    {
        return GalerieMedia::query()
            ->where('status', 'actif')
            ->when($this->typeFiltre, fn ($q) => $q->where('type', $this->typeFiltre))
            ->when($this->search, function ($q) {
                $q->where(function ($q2) {
                    $q2->where('titre_fr', 'like', "%{$this->search}%")
                        ->orWhere('titre_ar', 'like', "%{$this->search}%");
                });
            })
            ->orderByDesc('featured')
            ->orderByDesc('created_at');
    }

    public function getActiveMediaProperty()
    {
        return $this->activeMediaId ? GalerieMedia::find($this->activeMediaId) : null;
    }

    public function render()
    {
        return view('livewire.mediatheque-gallery', [
            'medias' => $this->baseQuery()->paginate(12),
            'locale' => app()->getLocale(),
        ]);
    }
}
