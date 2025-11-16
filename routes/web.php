<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SpecialiteController;
use App\Http\Controllers\AnneeAcademiqueController;

Route::get('/', fn () => view('welcome'));

Route::get('/dashboard', fn () => view('dashboard'))->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function (): void {

         // Années académiques
    Route::resource('annees', AnneeAcademiqueController::class);
    Route::post('annees/{annee}/activate', [AnneeAcademiqueController::class, 'activate'])->name('annees.activate');

    // Spécialités
    Route::resource('specialites', SpecialiteController::class);

    // Modules
    Route::resource('modules', ModuleController::class);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
