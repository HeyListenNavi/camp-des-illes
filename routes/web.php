<?php

use App\Livewire\Public\CamperRegistrationForm;
use App\Livewire\Public\GroupEventRegistrationForm;
use App\Livewire\Public\MedicalConsentUpdateForm;
use Illuminate\Support\Facades\Route;

Route::get('/', CamperRegistrationForm::class)->name('home');

// Portal Web Público / Form Ingestion Routes
Route::prefix('public')->group(function () {
    Route::get('/camper-register', CamperRegistrationForm::class)->name('public.camper.register');
    Route::get('/group-request', GroupEventRegistrationForm::class)->name('public.group.register');
    Route::get('/medical/{token}', MedicalConsentUpdateForm::class)->name('public.medical.update');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

require __DIR__.'/settings.php';

