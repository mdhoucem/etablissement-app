<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Livewire\ServicesList;
use App\Livewire\ServiceDetail;

Route::get('lang/{locale}', function ($locale) {
    if (in_array($locale, ['fr', 'ar'])) {
        Session::put('locale', $locale);
    }
    return redirect()->back();
})->name('lang.switch');

Route::get('/', function () {
    return view('welcome');
});
Route::get('/test-language-switcher', function () {
    return view('test-language-switcher');
})->name('language-switcher-test');

Route::get('/services', ServicesList::class)->name('services.index');
Route::get('/services/{slug}', ServiceDetail::class)->name('services.detail');
