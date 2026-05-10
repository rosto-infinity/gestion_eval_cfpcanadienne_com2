<?php

declare(strict_types=1);

namespace App\Actions\Academia;

use App\Http\Resources\BilanResource;
use App\Models\BilanCompetence;
use App\Models\Specialite;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Context;
use Illuminate\Support\Facades\Log;

class GenerateSpecialtyReportAction
{
    /**
     * Agrégation SQL latérale via withAvg + Eloquent.
     * Produit un rapport de spécialité avec moyennes par étudiant.
     */
    public function execute(int $specialiteId, int $anneeAcademiqueId): ResourceCollection
    {
        $specialite = Specialite::findOrFail($specialiteId);

        $results = BilanCompetence::with(['user', 'anneeAcademique'])
            ->withAvg('evaluations as moyenne_evaluations_brute', 'note')
            ->whereHas('user', fn ($q) => $q->where('specialite_id', $specialiteId))
            ->where('annee_academique_id', $anneeAcademiqueId)
            ->orderByDesc('moyenne_generale')
            ->get();

        Context::add('specialty_report', [
            'specialite_id' => $specialiteId,
            'specialite_intitule' => $specialite->intitule,
            'annee_academique_id' => $anneeAcademiqueId,
            'students_count' => $results->count(),
        ]);

        Log::info('Rapport de spécialité généré', [
            'specialite_id' => $specialiteId,
            'annee_academique_id' => $anneeAcademiqueId,
            'count' => $results->count(),
        ]);

        return $results->toResourceCollection(BilanResource::class);
    }
}
