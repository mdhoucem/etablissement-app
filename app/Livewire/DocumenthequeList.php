<?php

namespace App\Livewire;

use App\Models\Document;
use Livewire\Component;
use Livewire\WithPagination;

class DocumenthequeList extends Component
{
    use WithPagination;

    public string $search = '';
    public string $categorieFiltre = '';

    public function updatingSearch(): void { $this->resetPage(); }
    public function updatingCategorieFiltre(): void { $this->resetPage(); }

    public function selectCategorie(string $categorie): void
    {
        $this->categorieFiltre = $categorie;
        $this->resetPage();
    }

    public function render()
    {
        $locale = app()->getLocale();

        $documents = Document::query()
            ->where('status', 'publie')
            ->when($this->categorieFiltre, fn ($q) => $q->where('categorie', $this->categorieFiltre))
            ->when($this->search, function ($q) {
                $q->where(function ($q2) {
                    $q2->where('titre_fr', 'like', "%{$this->search}%")
                        ->orWhere('titre_ar', 'like', "%{$this->search}%");
                });
            })
            ->orderByDesc('date_publication')
            ->paginate(10);

        $categories = [
            'administratif' => ['fr' => 'Administratif', 'ar' => 'إداري'],
            'pedagogique' => ['fr' => 'Pédagogique', 'ar' => 'تربوي'],
            'reglementation' => ['fr' => 'Réglementation', 'ar' => 'تشريعات'],
            'procedures' => ['fr' => 'Procédures & Guides', 'ar' => 'إجراءات وأدلة'],
        ];

        $counts = Document::where('status', 'publie')
            ->selectRaw('categorie, count(*) as total')
            ->groupBy('categorie')
            ->pluck('total', 'categorie');

        return view('livewire.documentheque-list', [
            'documents' => $documents,
            'categories' => $categories,
            'counts' => $counts,
            'totalAll' => Document::where('status', 'publie')->count(),
            'locale' => $locale,
        ]);
    }
}
