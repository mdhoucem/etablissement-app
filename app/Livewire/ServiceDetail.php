<?php

namespace App\Livewire;

use App\Models\Service;
use Livewire\Component;

class ServiceDetail extends Component
{
    public Service $service;

    public function mount(string $slug): void
    {
        $this->service = Service::where('slug', $slug)
            ->where('status', 'actif')
            ->with('groupeService')
            ->firstOrFail();
    }

    public function render()
    {
        return view('livewire.service-detail', [
            'locale' => app()->getLocale(),
        ]);
    }
}
