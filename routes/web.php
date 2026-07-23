<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Livewire\ServicesList;
use App\Livewire\ServiceDetail;
use App\Livewire\DemandeAssistanceForm;
use App\Livewire\SuiviDemande;
use App\Livewire\ActualitesList;
use App\Livewire\ActualiteDetail;
use App\Livewire\DocumenthequeList;
use App\Livewire\MediathequeGallery;



// Placeholder — sera remplacé par les vrais composants dans les prochaines parties
Route::get('/', function () {
    return view('placeholder', ['title' => 'Accueil (Partie 7)']);
})->name('home');

Route::get('/etablissement', function () {
    return view('placeholder', ['title' => 'L\'Établissement (Partie 7)']);
})->name('etablissement');

Route::get('/documentheque', function () {
    return view('placeholder', ['title' => 'Documenthèque (Partie 4)']);
})->name('documentheque.index');

Route::get('/mediatheque', function () {
    return view('placeholder', ['title' => 'Médiathèque (Partie 5)']);
})->name('mediatheque.index');

Route::get('/contact', function () {
    return view('placeholder', ['title' => 'Contact (Partie 6)']);
})->name('contact.form');



Route::get('lang/{locale}', function ($locale) {
    if (in_array($locale, ['fr', 'ar'])) {
        Session::put('locale', $locale);
    }
    return redirect()->back();
})->name('lang.switch');


Route::get('/test-language-switcher', function () {
    return view('test-language-switcher');
})->name('language-switcher-test');

Route::get('/services', ServicesList::class)->name('services.index');
Route::get('/services/{slug}', ServiceDetail::class)->name('services.detail');

Route::get('/demande-assistance/{service_id?}', DemandeAssistanceForm::class)->name('demande-assistance.form');
Route::get('/suivi-demande', SuiviDemande::class)->name('suivi-demande');
Route::get('/actualites', ActualitesList::class)->name('actualites.index');
Route::get('/actualites/{id}', ActualiteDetail::class)->name('actualites.detail');

Route::get('/test-partenaires', function () {
    return view('test-partenaires');
});
Route::get('/documentheque', DocumenthequeList::class)->name('documentheque.index');
Route::get('/mediatheque', MediathequeGallery::class)->name('mediatheque.index');
