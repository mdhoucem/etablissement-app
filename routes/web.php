<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Livewire\ContactForm;
use App\Livewire\ActualitesList;
use App\Livewire\ActualiteDetail;



Route::get('lang/{locale}', function ($locale) {
    if (in_array($locale, ['fr', 'ar'])) {
        Session::put('locale', $locale);
    }
    return redirect()->back();
})->name('lang.switch');

Route::get('/', function () {
    return view('welcome');
});
// Route pour tester le Formulaire de Contact
Route::get('/contact', ContactForm::class)->name('contact');

// Route pour tester la Liste des Actualités
Route::get('/actualites', ActualitesList::class)->name('actualites.index');
Route::get('/actualites/{id}', ActualiteDetail::class)->name('actualites.show');
