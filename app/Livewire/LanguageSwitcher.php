<?php

namespace App\Livewire;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;
use Livewire\Component;

class LanguageSwitcher extends Component
{
    public string $currentLocale;

    public function mount(): void
    {
        $this->currentLocale = App::getLocale();
    }

    public function switchLanguage(string $locale)
    {
        if (! in_array($locale, ['fr', 'ar'])) {
            return;
        }

        session(['locale' => $locale]);
        Cookie::queue(Cookie::forever('locale', $locale));

        return redirect(request()->header('Referer', route('language-switcher-test')));
    }

    public function render()
    {
        return view('livewire.language-switcher');
    }
}
