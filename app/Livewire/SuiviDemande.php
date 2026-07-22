<?php

namespace App\Livewire;

use App\Models\DemandeAssistance;
use Livewire\Component;

class SuiviDemande extends Component
{
    public string $numero_suivi = '';
    public string $cin = '';

    public ?DemandeAssistance $demande = null;

    public bool $recherche_effectuee = false;

    protected function rules(): array
    {
        return [
            'numero_suivi' => ['required', 'string'],
            'cin' => ['required', 'string'],
        ];
    }

    public function rechercher(): void
    {
        $this->validate();

        $this->recherche_effectuee = true;

        $this->demande = DemandeAssistance::where('numero_suivi', $this->numero_suivi)
            ->where('cin', $this->cin)
            ->with('service')
            ->first();
    }

    public function render()
    {
        return view('livewire.suivi-demande', [
            'locale' => app()->getLocale(),
        ]);
    }
}
