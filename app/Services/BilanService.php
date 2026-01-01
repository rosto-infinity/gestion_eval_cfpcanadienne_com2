<?php

declare(strict_types=1);

namespace App\Services;

use Log;
use App\Models\User;
use App\Models\BilanCompetence;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class BilanService
{
    /**
     * -Vérifie si un bilan existe déjà pour un étudiant
     */
    public function bilanExists(int $userId, int $anneeAcademiqueId): bool
    {
        return BilanCompetence::where('user_id', $userId)
            ->where('annee_academique_id', $anneeAcademiqueId)
            ->exists();
    }

    /**
     * --Crée un bilan de compétences
     */
    public function createBilan(User $user, float $moyCompetences, ?string $observations = null): BilanCompetence
    {
        // CORRECTION 1: -Vérifier si l'étudiant a une année académique avant de continuer
        if (is_null($user->annee_academique_id)) {
            throw new \InvalidArgumentException("Erreur : L'étudiant n'est associé à aucune année académique active. Veuillez vérifier son profil.");
        }

        // CORRECTION 2: -Vérifier si un bilan existe déjà (Message demandé)
        if ($this->bilanExists($user->id, (int) $user->annee_academique_id)) {
            throw new \InvalidArgumentException("Un bilan de compétences existe déjà pour cet étudiant pour l'année en cours. Veuillez modifier le bilan existant.");
        }

        $bilan = new BilanCompetence([
            'user_id' => $user->id,
            'annee_academique_id' => $user->annee_academique_id,
            'observations' => $observations,
        ]);

        $bilan->calculateAndSave($moyCompetences);

        return $bilan;
    }

    /**
     * -Met à jour un bilan de compétences
     */
    public function updateBilan(BilanCompetence $bilan, float $moyCompetences, ?string $observations = null): BilanCompetence
    {
        $bilan->observations = $observations;
        $bilan->calculateAndSave($moyCompetences);

        return $bilan;
    }

    /**
     * -Génère des bilans en masse
     */
    public function generateBilansEnMasse(int $anneeAcademiqueId, float $moyCompetencesDefaut, ?int $specialiteId = null): int
    {
        DB::beginTransaction();

        try {
            $query = User::where('annee_academique_id', $anneeAcademiqueId)
                ->whereDoesntHave('bilanCompetence', function ($q) use ($anneeAcademiqueId): void {
                    $q->where('annee_academique_id', $anneeAcademiqueId);
                });

            if ($specialiteId) {
                $query->where('specialite_id', $specialiteId);
            }

            $users = $query->get();
            $count = 0;

            foreach ($users as $user) {
                // Note: createBilan peut lever une exception, mais ici on filtre déjà 'whereDoesntHave'
                // Cependant, c'est une bonne pratique de laisser try/catch ici aussi si nécessaire
                try {
                    $this->createBilan($user, $moyCompetencesDefaut);
                    $count++;
                } catch (\InvalidArgumentException $e) {
                    // On ignore les erreurs de doublon ou d'année manquante dans le script de masse
                    Log::warning('Erreur génération masse pour user ' . $user->id . ': ' . $e->getMessage());
                }
            }

            DB::commit();

            return $count;
        } catch (\Exception $e) {
            DB::rollBack();

            throw $e;
        }
    }

    /**
     * Calcule les statistiques des bilans
     */
    public function calculateStatsGlobales(Collection $bilans): array
    {
        if ($bilans->isEmpty()) {
            return [
                'total' => 0,
                'admis' => 0,
                'moyenne_generale' => 0,
                'meilleure_moyenne' => 0,
                'moyenne_la_plus_basse' => 0,
            ];
        }

        return [
            'total' => $bilans->count(),
            'admis' => $bilans->filter(fn ($b) => $b->isAdmis())->count(),
            'moyenne_generale' => $bilans->avg('moyenne_generale'),
            'meilleure_moyenne' => $bilans->max('moyenne_generale'),
            'moyenne_la_plus_basse' => $bilans->min('moyenne_generale'),
        ];
    }

    /**
     * Récupère les bilans avec filtres
     */
    public function getBilansWithFilters(?int $anneeId = null, ?int $specialiteId = null): Collection
    {
        $query = BilanCompetence::with(['user.specialite', 'anneeAcademique'])
            ->whereNotNull('moyenne_generale');

        if ($anneeId) {
            $query->where('annee_academique_id', $anneeId);
        }

        if ($specialiteId) {
            $query->whereHas('user', fn ($q) => $q->where('specialite_id', $specialiteId));
        }

        return $query->get()->sortByDesc('moyenne_generale');
    }
}
