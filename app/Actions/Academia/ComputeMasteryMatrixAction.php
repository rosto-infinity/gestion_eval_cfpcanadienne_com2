<?php

declare(strict_types=1);

namespace App\Actions\Academia;

use App\Http\Resources\MasteryMatrixResource;
use App\Models\Evaluation;
use App\Models\User;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Context;
use Illuminate\Support\Facades\Log;

class ComputeMasteryMatrixAction
{
    /**
     * Paliers d'acquisition.
     */
    private const array MASTERY_LEVELS = [
        ['seuil' => 17, 'label' => 'Dépassé',      'key' => 'depasse'],
        ['seuil' => 14, 'label' => 'Acquis',        'key' => 'acquis'],
        ['seuil' => 10, 'label' => 'En cours',      'key' => 'en_cours'],
        ['seuil' => 0,  'label' => 'Non acquis',    'key' => 'non_acquis'],
    ];

    /**
     * Calcule la matrice de maîtrise par paliers d'acquisition.
     * Utilise lazyById pour traiter de grands volumes sans explosion mémoire.
     */
    public function execute(?int $specialiteId = null, ?int $anneeAcademiqueId = null): ResourceCollection
    {
        $query = User::studentsOnly()
            ->with('specialite:id,intitule')
            ->select('id', 'name', 'matricule', 'specialite_id', 'annee_academique_id');

        if ($specialiteId) {
            $query->where('specialite_id', $specialiteId);
        }

        if ($anneeAcademiqueId) {
            $query->where('annee_academique_id', $anneeAcademiqueId);
        }

        $matrix = [];

        foreach ($query->lazyById(100) as $student) {
            $evaluations = Evaluation::where('user_id', $student->id)
                ->with('module:id,code,intitule')
                ->get();

            $modules = [];
            $totalModules = 0;
            $modulesMaîtrisés = 0;
            $totalAverage = 0;

            foreach ($evaluations->groupBy('module_id') as $moduleId => $moduleEvals) {
                $avg = round($moduleEvals->avg('note'), 2);
                $firstEval = $moduleEvals->first();
                $level = $this->determineLevel($avg);

                $modules[] = [
                    'module_id' => $moduleId,
                    'module_code' => $firstEval->module?->code,
                    'module_intitule' => $firstEval->module?->intitule,
                    'moyenne' => $avg,
                    'palier' => $level,
                    'semestre' => $firstEval->semestre,
                ];

                $totalModules++;
                $totalAverage += $avg;

                if ($level['key'] === 'acquis' || $level['key'] === 'depasse') {
                    $modulesMaîtrisés++;
                }
            }

            $overallAvg = $totalModules > 0 ? round($totalAverage / $totalModules, 2) : 0;

            $matrix[] = [
                'student_id' => $student->id,
                'student_name' => $student->name,
                'student_matricule' => $student->matricule,
                'specialite' => $student->specialite?->intitule,
                'overall_average' => $overallAvg,
                'overall_level' => $this->determineLevel($overallAvg),
                'modules_count' => $totalModules,
                'modules_maitrises' => $modulesMaîtrisés,
                'taux_maitrise' => $totalModules > 0 ? round(($modulesMaîtrisés / $totalModules) * 100, 1) : 0,
                'modules' => $modules,
            ];
        }

        Context::add('mastery_matrix', [
            'filters' => [
                'specialite_id' => $specialiteId,
                'annee_academique_id' => $anneeAcademiqueId,
            ],
            'students_processed' => count($matrix),
        ]);

        Log::info('Matrice de maîtrise calculée', [
            'students_count' => count($matrix),
            'specialite_id' => $specialiteId,
        ]);

        return collect($matrix)->toResourceCollection(MasteryMatrixResource::class);
    }

    /**
     * Détermine le palier d'acquisition pour une note donnée.
     */
    private function determineLevel(float $note): array
    {
        foreach (self::MASTERY_LEVELS as $level) {
            if ($note >= $level['seuil']) {
                return $level;
            }
        }

        return self::MASTERY_LEVELS[3];
    }
}
