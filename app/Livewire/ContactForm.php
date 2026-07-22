<?php

namespace App\Livewire;

use App\Models\ContactMessage;
use Livewire\Component;

class ContactForm extends Component
{
    public string $name = '';
    public string $email = '';
    public string $subject = '';
    public string $message = '';

    public bool $successMessage = false;

    protected array $rules = [
        'name' => 'required|min:3|max:255',
        'email' => 'required|email|max:255',
        'subject' => 'nullable|min:3|max:255',
        'message' => 'required|min:10',
    ];

    protected array $messages = [
        'name.required' => 'Le nom est obligatoire.',
        'name.min' => 'Le nom doit contenir au moins 3 caractères.',
        'email.required' => 'L\'adresse e-mail est obligatoire.',
        'email.email' => 'Veuillez saisir une adresse e-mail valide.',
        'message.required' => 'Le message ne peut pas être vide.',
        'message.min' => 'Le message doit contenir au moins 10 caractères.',
    ];

    public function updated($propertyName): void
    {
        $this->validateOnly($propertyName);
    }

    public function sendMessage(): void
    {
        $validatedData = $this->validate();

        ContactMessage::create($validatedData);

        $this->reset(['name', 'email', 'subject', 'message']);
        $this->successMessage = true;
    }

    public function render()
    {
        return view('livewire.contact-form');
    }
}
