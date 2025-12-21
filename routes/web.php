<?php

declare(strict_types=1);

use App\Enums\Role;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    UserController,
    ModuleController,
    ProfileController,
    EvaluationController,
    SpecialiteController,
    BilanSpecialiteController,
    BilanCompetenceController,
    AnneeAcademiqueController
};

Route::get('/', fn () => view('welcome'));

Route::get('/dashboard', fn () => view('dashboard'))
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function (): void {

    // ============================================================
    // 🛡️ ZONE ADMIN & SUPERADMIN (Gestion structurelle)
    // ============================================================
    Route::middleware('role:admin,superadmin')->group(function () {
        
        // Gestion des utilisateurs
        Route::resource('users', UserController::class);
        
        // Paramétrage académique
        Route::resource('annees', AnneeAcademiqueController::class);
        Route::post('annees/{annee}/activate', [AnneeAcademiqueController::class, 'activate'])->name('annees.activate');
        
        Route::resource('specialites', SpecialiteController::class);
        Route::resource('modules', ModuleController::class);
    });

    // ============================================================
    // 📊 ZONE MANAGER & ADMIN (Gestion pédagogique)
    // ============================================================
    Route::middleware('role:manager,admin,superadmin')->group(function () {
        
        // Évaluations (Saisie et gestion)
        Route::get('evaluations/saisir-multiple', [EvaluationController::class, 'saisirMultiple'])->name('evaluations.saisir-multiple');
        Route::post('evaluations/store-multiple', [EvaluationController::class, 'storeMultiple'])->name('evaluations.store-multiple');
        Route::resource('evaluations', EvaluationController::class);

        // Bilans par spécialité
        Route::prefix('bilan/specialite')->name('bilan.specialite.')->group(function (): void {
            Route::get('/', [BilanSpecialiteController::class, 'index'])->name('index');
            Route::get('/export-pdf', [BilanSpecialiteController::class, 'exportPdf'])->name('export-pdf');
            Route::get('/comparaison', [BilanSpecialiteController::class, 'comparaison'])->name('comparaison');
            Route::get('/{specialite}', [BilanSpecialiteController::class, 'show'])->name('show');
            Route::get('/{specialite}/export-pdf', [BilanSpecialiteController::class, 'exportDetailPdf'])->name('export-detail-pdf');
        });

        // Bilans de compétences
        Route::get('bilans/tableau-recapitulatif', [BilanCompetenceController::class, 'tableauRecapitulatif'])->name('bilans.tableau-recapitulatif');
        Route::post('bilans/generer-tous', [BilanCompetenceController::class, 'genererTous'])->name('bilans.generer-tous');
        Route::post('bilans/{bilan}/recalculer', [BilanCompetenceController::class, 'recalculer'])->name('bilans.recalculer');
        Route::resource('bilans', BilanCompetenceController::class);
    });

    // ============================================================
    // 👤 ZONE COMMUNE / USER (Consultation & Profil)
    // ============================================================
    
    // AJAX (Accessibles au moins par Manager/Admin pour la saisie)
    Route::get('/evaluations/get-user-modules/{user}', [EvaluationController::class, 'getUserModules'])->name('evaluations.get-user-modules');
    Route::get('/evaluations/get-modules-by-semestre/{user}/{semestre}', [EvaluationController::class, 'getModulesBySemestre'])
        ->name('evaluations.get-modules-by-semestre')
        ->where('semestre', '[1-2]');

    // Relevé de notes (L'étudiant peut voir le sien, Manager peut voir tous)
    Route::get('users/{user}/releve-notes', [EvaluationController::class, 'releveNotes'])->name('evaluations.releve-notes');
    Route::get('users/{user}/releve-notes/pdf', [EvaluationController::class, 'releveNotesPdf'])->name('evaluations.releve-notes.pdf');
    Route::get('bilans/{bilan}/pdf', [BilanCompetenceController::class, 'exportPdf'])->name('bilans.pdf');

    // Profil personnel
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::patch('/profile', 'update')->name('profile.update');
        Route::delete('/profile', 'destroy')->name('profile.destroy');
    });
});

require __DIR__.'/auth.php';
