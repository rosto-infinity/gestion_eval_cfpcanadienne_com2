<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Evaluation;
use App\Models\Module;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class EvaluationService
{
    /**
     * Vérifie si le module appartient à la spécialité
     */
    public function validateModuleForSpecialite(Module $module, int $specialiteId): bool
    {
        return $module->specialite_id === $specialiteId;
    }

    /**
     * Vérifie si une évaluation existe déjà
     */
    public function evaluationExists(int $userId, int $moduleId, int $semestre, int $anneeAcademiqueId): bool
    {
        return Evaluation::where('user_id', $userId)
            ->where('module_id', $moduleId)
            ->where('semestre', $semestre)
            ->where('annee_academique_id', $anneeAcademiqueId)
            ->exists();
    }

    /**
     * Crée une évaluation avec validation
     */
    public function createEvaluation(array $data): Evaluation
    {
        $module = Module::findOrFail($data['module_id']);

        if (! $this->validateModuleForSpecialite($module, $data['specialite_id'])) {
            throw new \InvalidArgumentException('Ce module n\'appartient pas à cette spécialité.');
        }

        if ($this->evaluationExists(
            $data['user_id'],
            $data['module_id'],
            $data['semestre'],
            $data['annee_academique_id']
        )) {
            throw new \InvalidArgumentException('Cette évaluation existe déjà pour cet étudiant.');
        }

        return Evaluation::create($data);
    }

    /**
     * Crée plusieurs évaluations pour une spécialité/module
     */
    public function createMultipleEvaluations(
        int $specialiteId,
        int $moduleId,
        int $semestre,
        int $anneeAcademiqueId,
        array $notes
    ): array {
        DB::beginTransaction();

        try {
            $module = Module::findOrFail($moduleId);

            if (! $this->validateModuleForSpecialite($module, $specialiteId)) {
                throw new \InvalidArgumentException('Ce module n\'appartient pas à cette spécialité.');
            }

            $created = [];
            $updated = [];
            $errors = [];

            foreach ($notes as $userId => $noteValue) {
                try {
                    $user = User::findOrFail($userId);

                    if ($user->specialite_id !== $specialiteId) {
                        $errors[$userId] = 'L\'étudiant n\'appartient pas à cette spécialité';

                        continue;
                    }

                    $evaluation = Evaluation::updateOrCreate(
                        [
                            'user_id' => $userId,
                            'module_id' => $moduleId,
                            'semestre' => $semestre,
                            'annee_academique_id' => $anneeAcademiqueId,
                        ],
                        [
                            'specialite_id' => $specialiteId,
                            'note' => $noteValue,
                        ]
                    );

                    if ($evaluation->wasRecentlyCreated) {
                        $created[] = $userId;
                    } else {
                        $updated[] = $userId;
                    }
                } catch (\Exception $e) {
                    $errors[$userId] = $e->getMessage();
                }
            }

            DB::commit();

            return [
                'created' => count($created),
                'updated' => count($updated),
                'errors' => $errors,
            ];
        } catch (\Exception $e) {
            DB::rollBack();

            throw $e;
        }
    }

    /**
     * Récupère les étudiants d'une spécialité pour un semestre donné
     */
    public function getStudentsBySpecialiteAndSemestre(
        int $specialiteId,
        int $moduleId,
        int $semestre,
        int $anneeAcademiqueId
    ): Collection {
        $users = User::where('specialite_id', $specialiteId)
            ->where('annee_academique_id', $anneeAcademiqueId)
            ->ordered()
            ->get();

        return $users->map(function ($user) use ($moduleId, $semestre, $anneeAcademiqueId) {
            $evaluation = Evaluation::where('user_id', $user->id)
                ->where('module_id', $moduleId)
                ->where('semestre', $semestre)
                ->where('annee_academique_id', $anneeAcademiqueId)
                ->first();

            return (object) [
                'user' => $user,
                'evaluation' => $evaluation,
                'note' => $evaluation?->note,
                'has_evaluation' => $evaluation !== null,
            ];
        });
    }

    /**
     * Récupère les modules d'une spécialité pour un semestre
     */
    public function getModulesBySpecialiteAndSemestre(int $specialiteId, int $semestre): Collection
    {
        return Module::where('specialite_id', $specialiteId)
            ->bySemestre($semestre)
            ->ordered()
            ->get();
    }

    /**
     * Calcule les statistiques pour une spécialité/module
     */
    public function calculateModuleStatistics(
        int $moduleId,
        int $semestre,
        int $anneeAcademiqueId
    ): array {
        $evaluations = Evaluation::where('module_id', $moduleId)
            ->where('semestre', $semestre)
            ->where('annee_academique_id', $anneeAcademiqueId)
            ->get();

        if ($evaluations->isEmpty()) {
            return [
                'total' => 0,
                'moyenne' => 0,
                'admis' => 0,
                'non_admis' => 0,
                'taux_reussite' => 0,
            ];
        }

        $total = $evaluations->count();
        $admis = $evaluations->where('note', '>=', 10)->count();

        return [
            'total' => $total,
            'moyenne' => round($evaluations->avg('note'), 2),
            'admis' => $admis,
            'non_admis' => $total - $admis,
            'taux_reussite' => $total > 0 ? round(($admis / $total) * 100, 2) : 0,
            'note_min' => $evaluations->min('note'),
            'note_max' => $evaluations->max('note'),
        ];
    }

    /**
     * Calcule la moyenne générale à partir de deux moyennes de semestre
     */
    public function calculateMoyenneGenerale(?float $moyenneSemestre1, ?float $moyenneSemestre2): float
    {
        if (empty($moyenneSemestre1) || empty($moyenneSemestre2)) {
            return 0;
        }

        return ($moyenneSemestre1 + $moyenneSemestre2) / 2;
    }

    /**
     * -Calcule les statistiques des évaluations
     */
    public function calculateStatistiques(Collection $evaluationsSemestre1, Collection $evaluationsSemestre2): array
    {
        $allEvaluations = $evaluationsSemestre1->merge($evaluationsSemestre2);

        $modulesValides = 0;
        $modulesEchoues = 0;

        foreach ($allEvaluations as $eval) {
            $note = $eval->note ?? 0;

            if ($note >= 10) {
                $modulesValides++;
            } else {
                $modulesEchoues++;
            }
        }

        return [
            'totalModules' => $allEvaluations->count(),
            'modulesValides' => $modulesValides,
            'modulesEchoues' => $modulesEchoues,
        ];
    }

    /**
     * -Vérifie si le module appartient à la spécialité de l'étudiant
     */
    public function validateModuleForUser(User $user, Module $module): bool
    {
        return $user->specialite_id === $module->specialite_id;
    }

   

    /**
     * -Crée ou met à jour plusieurs évaluations
     */
    public function createOrUpdateMultiple(User $user, array $evaluations, int $semestre): int
    {
        $count = 0;

        DB::beginTransaction();

        try {
            // -Vérifier que tous les modules appartiennent à la spécialité
            $moduleIds = collect($evaluations)->pluck('module_id');
            $invalidModules = Module::whereIn('id', $moduleIds)
                ->where('specialite_id', '!=', $user->specialite_id)
                ->exists();

            if ($invalidModules) {
                throw new \InvalidArgumentException(
                    'Certains modules n\'appartiennent pas à la spécialité de l\'étudiant.'
                );
            }

            foreach ($evaluations as $evalData) {
                Evaluation::updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'module_id' => $evalData['module_id'],
                        'semestre' => $semestre,
                        'annee_academique_id' => $user->annee_academique_id,
                    ],
                    [
                        'specialite_id' => $user->specialite_id,
                        'note' => $evalData['note'],
                    ]
                );
                $count++;
            }

            DB::commit();

            return $count;
        } catch (\Exception $e) {
            DB::rollBack();

            throw $e;
        }
    }

    /**
     * Récupère les évaluations d'un étudiant pour un semestre
     */
    public function getEvaluationsBySemestre(User $user, int $semestre): Collection
    {
        return Evaluation::where('user_id', $user->id)
            ->where('semestre', $semestre)
            ->where('annee_academique_id', $user->annee_academique_id)
            ->with('module')
            ->get()
            ->keyBy('module_id');
    }

    /**
     * Calcule la moyenne générale à partir de deux moyennes de semestre
     */
    // public function calculateMoyenneGenerale(?float $moyenneSemestre1, ?float $moyenneSemestre2): float
    // {
    //     if (empty($moyenneSemestre1) || empty($moyenneSemestre2)) {
    //         return 0;
    //     }

    //     return ($moyenneSemestre1 + $moyenneSemestre2) / 2;
    // }

    /**
     * Calcule les statistiques des évaluations
     */
    // public function calculateStatistiques(Collection $evaluationsSemestre1, Collection $evaluationsSemestre2): array
    // {
    //     $allEvaluations = $evaluationsSemestre1->merge($evaluationsSemestre2);

    //     $modulesValides = 0;
    //     $modulesEchoues = 0;

    //     foreach ($allEvaluations as $eval) {
    //         $note = $eval->note ?? 0;

    //         if ($note >= 10) {
    //             $modulesValides++;
    //         } else {
    //             $modulesEchoues++;
    //         }
    //     }

    //     return [
    //         'totalModules' => $allEvaluations->count(),
    //         'modulesValides' => $modulesValides,
    //         'modulesEchoues' => $modulesEchoues,
    //     ];
    // }
}
