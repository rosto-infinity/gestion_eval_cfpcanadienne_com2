<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\SpecialiteController;
use App\Http\Controllers\AnneeAcademiqueController;
use App\Http\Controllers\BilanCompetenceController;

Route::get('/', fn () => view('welcome'));

Route::get('/dashboard', fn () => view('dashboard'))->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function (): void {

    Route::resource('annees', AnneeAcademiqueController::class);
    Route::post('annees/{annee}/activate', [AnneeAcademiqueController::class, 'activate'])->name('annees.activate');
    Route::resource('specialites', SpecialiteController::class);
    Route::resource('modules', ModuleController::class);
     // Évaluations
    Route::resource('evaluations', EvaluationController::class);
    Route::get('evaluations/saisir-multiple', [EvaluationController::class, 'saisirMultiple'])->name('evaluations.saisir-multiple');
    Route::post('evaluations/store-multiple', [EvaluationController::class, 'storeMultiple'])->name('evaluations.store-multiple');
    Route::get('users/{user}/releve-notes', [EvaluationController::class, 'releveNotes'])->name('evaluations.releve-notes');

    // Bilans
    Route::resource('bilans', BilanCompetenceController::class);
    Route::post('bilans/{bilan}/recalculer', [BilanCompetenceController::class, 'recalculer'])->name('bilans.recalculer');
    Route::post('bilans/generer-tous', [BilanCompetenceController::class, 'genererTous'])->name('bilans.generer-tous');
    Route::get('bilans/tableau-recapitulatif', [BilanCompetenceController::class, 'tableauRecapitulatif'])->name('bilans.tableau-recapitulatif');
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
