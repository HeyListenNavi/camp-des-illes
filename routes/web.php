<?php

use App\Livewire\Public\CamperRegistrationForm;
use App\Livewire\Public\GroupEventRegistrationForm;
use App\Livewire\Public\MedicalConsentUpdateForm;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GroupApprovedController;
use App\Http\Controllers\IndividualRegistrationController;

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

// Rutas de la demo sin token
Route::get('/group-approved', [GroupApprovedController::class, 'show'])->name('groups.approved');
Route::get('/register-individual', [IndividualRegistrationController::class, 'create'])->name('groups.register-individual');
Route::post('/register-individual', [IndividualRegistrationController::class, 'store'])->name('groups.store-individual');

require __DIR__.'/settings.php';