<?php

namespace App\Livewire;

use App\Models\DemandeAssistance;
use App\Models\Service;
use Livewire\Component;
use Livewire\WithFileUploads;

class DemandeAssistanceForm extends Component
{
    use WithFileUploads;

    public ?int $service_id = null;

    public string $nom_complet = '';
    public string $cin = '';
    public string $telephone = '';
    public string $email = '';
    public string $description = '';

    /** @var array<int, \Livewire\Features\SupportFileUploads\TemporaryUploadedFile> */
    public array $pieces_justificatives = [];

    public ?string $numeroSuiviGenere = null;

    protected function rules(): array
    {
        return [
            'service_id' => ['nullable', 'exists:services,id'],
            'nom_complet' => ['required', 'string', 'max:255'],
            'cin' => ['required', 'string', 'max:20'],
            'telephone' => ['required', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:255'],
            'description' => ['required', 'string', 'max:2000'],
            'pieces_justificatives' => ['nullable', 'array', 'max:5'],
            'pieces_justificatives.*' => ['file', 'max:5120', 'mimes:pdf,jpg,jpeg,png'],
        ];
    }

    protected function messages(): array
    {
        return [
            'pieces_justificatives.*.max' => 'Chaque fichier ne doit pas dépasser 5 Mo.',
            'pieces_justificatives.*.mimes' => 'Formats acceptés : PDF, JPG, PNG.',
        ];
    }

    public function mount(?int $service_id = null): void
    {
        if ($service_id && Service::where('id', $service_id)->where('status', 'actif')->exists()) {
            $this->service_id = $service_id;
        }
    }

    public function submit(): void
    {
        $validated = $this->validate();

        $paths = [];
        foreach ($this->pieces_justificatives as $file) {
            $paths[] = $file->store('pieces_justificatives', 'public');
        }

        $demande = DemandeAssistance::create([
            'service_id' => $validated['service_id'],
            'nom_complet' => $validated['nom_complet'],
            'cin' => $validated['cin'],
            'telephone' => $validated['telephone'],
            'email' => $validated['email'],
            'description' => $validated['description'],
            'pieces_justificatives' => $paths,
            'statut' => 'en_attente',
        ]);

        $this->numeroSuiviGenere = $demande->numero_suivi;

        $this->reset([
            'nom_complet', 'cin', 'telephone', 'email',
            'description', 'pieces_justificatives',
        ]);
    }

    public function render()
    {
        return view('livewire.demande-assistance-form', [
            'services' => Service::where('status', 'actif')->orderBy('titre_fr')->get(),
            'locale' => app()->getLocale(),
        ]);
    }
}
