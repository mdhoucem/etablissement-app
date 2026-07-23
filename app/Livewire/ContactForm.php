<?php

namespace App\Livewire;

use App\Models\ContactMessage;
use Livewire\Component;

class ContactForm extends Component
{
    public string $nom = '';
    public string $email = '';
    public string $telephone = '';
    public string $sujet = '';
    public string $message = '';
    public bool $consent = false;

    public bool $envoye = false;

    protected function rules(): array
    {
        return [
            'nom' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'telephone' => ['nullable', 'string', 'max:20'],
            'sujet' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:2000'],
            'consent' => ['accepted'],
        ];
    }

    protected function messages(): array
    {
        return [
            'consent.accepted' => app()->getLocale() === 'ar'
                ? 'يجب الموافقة على معالجة بياناتكم للمتابعة.'
                : 'Vous devez accepter le traitement de vos données pour continuer.',
        ];
    }

    public function submit(): void
    {
        $validated = $this->validate();

        ContactMessage::create([
            'nom' => $validated['nom'],
            'email' => $validated['email'],
            'telephone' => $validated['telephone'],
            'sujet' => $validated['sujet'],
            'message' => $validated['message'],
            'status' => 'nouveau',
        ]);

        $this->envoye = true;
        $this->reset(['nom', 'email', 'telephone', 'sujet', 'message', 'consent']);
    }

    public function render()
    {
        return view('livewire.contact-form', [
            'locale' => app()->getLocale(),
        ]);
    }
}
