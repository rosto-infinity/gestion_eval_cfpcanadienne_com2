<?php

declare(strict_types=1);

use App\Http\Controllers\AnneeAcademiqueController;
use App\Http\Controllers\BilanCompetenceController;
use App\Http\Controllers\BilanSpecialiteController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SpecialiteController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => view('welcome'));

Route::get('/dashboard', fn () => view('dashboard'))->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function (): void {

    Route::resource('annees', AnneeAcademiqueController::class);
    Route::post('annees/{annee}/activate', [AnneeAcademiqueController::class, 'activate'])->name('annees.activate');
    Route::resource('specialites', SpecialiteController::class);
    Route::resource('modules', ModuleController::class);
    Route::resource('users', UserController::class);
    // Évaluations

    Route::get('evaluations/saisir-multiple', [EvaluationController::class, 'saisirMultiple'])->name('evaluations.saisir-multiple');
    Route::resource('evaluations', EvaluationController::class);

    // ✅ AJAX pour charger les modules
    Route::get('/evaluations/get-user-modules/{user}', [EvaluationController::class, 'getUserModules'])
        ->name('evaluations.get-user-modules');

    // ✅ AJAX pour filtrer les modules par semestre
    Route::get('/evaluations/get-modules-by-semestre/{user}/{semestre}', [EvaluationController::class, 'getModulesBySemestre'])
        ->name('evaluations.get-modules-by-semestre')
        ->where('semestre', '[1-2]');
    Route::post('evaluations/store-multiple', [EvaluationController::class, 'storeMultiple'])->name('evaluations.store-multiple');

    // Relevé de notes
    Route::get('users/{user}/releve-notes', [EvaluationController::class, 'releveNotes'])
        ->name('evaluations.releve-notes');
    Route::get('users/{user}/releve-notes/pdf', [EvaluationController::class, 'releveNotesPdf'])
        ->name('evaluations.releve-notes.pdf');
    // Routes pour le bilan par spécialité (à ajouter dans web.php)
    Route::prefix('bilan/specialite')->name('bilan.specialite.')->group(function (): void {
        Route::get('/', [BilanSpecialiteController::class, 'index'])->name('index');
        Route::get('/export-pdf', [BilanSpecialiteController::class, 'exportPdf'])->name('export-pdf');
        Route::get('/comparaison', [BilanSpecialiteController::class, 'comparaison'])->name('comparaison');
        Route::get('/{specialite}', [BilanSpecialiteController::class, 'show'])->name('show');
        Route::get('/{specialite}/export-pdf', [BilanSpecialiteController::class, 'exportDetailPdf'])->name('export-detail-pdf');
    });
    // Bilans
    Route::get('bilans/tableau-recapitulatif', [BilanCompetenceController::class, 'tableauRecapitulatif'])->name('bilans.tableau-recapitulatif');
    Route::get('bilans/tableau-recapitulatif/export-pdf', [BilanCompetenceController::class, 'exportPdfTableau'])->name('bilans.tableau-recapitulatif.export-pdf');
    Route::resource('bilans', BilanCompetenceController::class);
    Route::get('bilans/{bilan}/pdf', [BilanCompetenceController::class, 'exportPdf'])->name('bilans.pdf');
    Route::post('bilans/{bilan}/recalculer', [BilanCompetenceController::class, 'recalculer'])->name('bilans.recalculer');
    Route::post('bilans/generer-tous', [BilanCompetenceController::class, 'genererTous'])->name('bilans.generer-tous');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
