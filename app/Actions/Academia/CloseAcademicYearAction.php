<?php

declare(strict_types=1);

namespace App\Actions\Academia;

use App\Models\AnneeAcademique;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Context;
use Illuminate\Support\Facades\Log;

class CloseAcademicYearAction
{
    /**
     * Activer une année académique en désactivant les autres.
     * Toute action affectant l'année active met à jour le Context
     * pour propagation vers les logs d'audit.
     */
    public function execute(AnneeAcademique $annee): void
    {
        $previousActive = AnneeAcademique::active()->first();

        if ($previousActive && $previousActive->id !== $annee->id) {
            $previousActive->update(['is_active' => false]);
        }

        if (! $annee->is_active) {
            $annee->update(['is_active' => true]);
        }

        $user = Auth::user();

        Context::add('academic_year_id', $annee->id);
        Context::add('academic_year', [
            'activated_id' => $annee->id,
            'activated_libelle' => $annee->libelle,
            'previous_active_id' => $previousActive?->id,
            'previous_active_libelle' => $previousActive?->libelle,
            'action' => 'close_academic_year',
            'admin_id' => $user?->id,
            'admin_name' => $user?->name,
        ]);

        Log::info('Année académique activée', [
            'annee_id' => $annee->id,
            'annee_libelle' => $annee->libelle,
            'previous_active_id' => $previousActive?->id,
        ]);
    }
}
