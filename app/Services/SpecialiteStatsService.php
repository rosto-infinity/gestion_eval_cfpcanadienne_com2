<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Specialite;
use App\Models\User;
use Illuminate\Support\Collection;

class SpecialiteStatsService
{
    /**
     * Récupère les données de bilan par spécialité
     */
    public function getBilanParSpecialite(int $anneeId, array $specialiteIds = []): Collection
    {
        if (! $anneeId) {
            return collect([]);
        }

        $query = Specialite::query();

        if (! empty($specialiteIds)) {
            $query->whereIn('id', $specialiteIds);
        }

        return $query->with(['users' => function ($q) use ($anneeId): void {
            $q->where('annee_academique_id', $anneeId)->with(['bilanCompetence']);
        }])
            ->get()
            ->map(fn ($specialite) => $this->calculateSpecialiteStats($specialite))
            ->filter()
            ->sortByDesc('moyenne_generale')
            ->values();
    }

       /**
     * Calcule les statistiques pour une spécialité
     */
    public function calculateSpecialiteStats(Specialite $specialite): ?object
    {
        $etudiants = $specialite->users;

        if ($etudiants->isEmpty()) {
            return null;
        }

        $admis = $etudiants->filter(fn ($e) => $e->bilanCompetence?->isAdmis())->count();

        $moyS1 = $etudiants->avg(fn ($e) => $e->getMoyenneSemestre(1));
        $moyS2 = $etudiants->avg(fn ($e) => $e->getMoyenneSemestre(2));
        $moyComp = $etudiants->avg(fn ($e) => $e->bilanCompetence?->moy_competences);
        $moyGen = $etudiants->avg(fn ($e) => $e->bilanCompetence?->moyenne_generale);
        
        // CORRECTION : Ajout du calcul du Max et Min pour le tableau comparatif
        $meilleureMoyenne = $etudiants->max(fn ($e) => $e->bilanCompetence?->moyenne_generale);
        $moyennePlusBasse = $etudiants->min(fn ($e) => $e->bilanCompetence?->moyenne_generale);

        $totalEtudiants = $etudiants->count();

        return (object) [
            'specialite' => $specialite,
            'total_etudiants' => $totalEtudiants,
            'moy_semestre1' => round((float) ($moyS1 ?? 0), 2),
            'moy_semestre2' => round((float) ($moyS2 ?? 0), 2),
            'moy_competences' => round((float) ($moyComp ?? 0), 2),
            'moyenne_generale' => round((float) ($moyGen ?? 0), 2),
            'admis' => $admis,
            'non_admis' => $totalEtudiants - $admis,
            'taux_admission' => $totalEtudiants > 0 ? round(($admis / $totalEtudiants) * 100, 2) : 0,
            // Ajout des clés manquantes demandées par la vue
            'meilleure_moyenne' => round((float) ($meilleureMoyenne ?? 0), 2),
            'moyenne_plus_basse' => round((float) ($moyennePlusBasse ?? 0), 2),
        ];
    }

    /**
     * Calcule les statistiques globales
     */
    public function calculateStatsGlobales(Collection $bilanParSpecialite): array
    {
        if ($bilanParSpecialite->isEmpty()) {
            return [
                'total_specialites' => 0,
                'total_etudiants' => 0,
                'total_admis' => 0,
                'total_non_admis' => 0,
                'taux_admission' => 0,
                'moyenne_generale' => 0,
                'moy_semestre1' => 0,
                'moy_semestre2' => 0,
                'moy_competences' => 0,
                'meilleure_specialite' => null,
                'specialite_plus_faible' => null,
            ];
        }

        $totalEtudiants = $bilanParSpecialite->sum('total_etudiants');
        $totalAdmis = $bilanParSpecialite->sum('admis');

        return [
            'total_specialites' => $bilanParSpecialite->count(),
            'total_etudiants' => $totalEtudiants,
            'total_admis' => $totalAdmis,
            'total_non_admis' => $totalEtudiants - $totalAdmis,
            'taux_admission' => $totalEtudiants > 0 ? round(($totalAdmis / $totalEtudiants) * 100, 2) : 0,
            'moyenne_generale' => round((float) ($bilanParSpecialite->avg('moyenne_generale') ?? 0), 2),
            'moy_semestre1' => round((float) ($bilanParSpecialite->avg('moy_semestre1') ?? 0), 2),
            'moy_semestre2' => round((float) ($bilanParSpecialite->avg('moy_semestre2') ?? 0), 2),
            'moy_competences' => round((float) ($bilanParSpecialite->avg('moy_competences') ?? 0), 2),
            'meilleure_specialite' => $bilanParSpecialite->first(),
            'specialite_plus_faible' => $bilanParSpecialite->last(),
        ];
    }

      /**
     * Récupère les étudiants d'une spécialité avec leurs statistiques
     */
    public function getEtudiantsWithStats(Specialite $specialite, int $anneeId): Collection
    {
        // Ajouter ->with('bilanCompetence') ici est crucial
        return User::with(['evaluations.module', 'bilanCompetence', 'anneeAcademique'])
            ->where('specialite_id', $specialite->id)
            ->where('annee_academique_id', $anneeId)
            ->ordered()
            ->get()
            ->map(fn ($etudiant) => $this->mapEtudiantStats($etudiant))
            ->sortByDesc('moyenne_generale');
    }

     /**
     * Mappe les statistiques d'un étudiant
     */
    private function mapEtudiantStats(User $etudiant): object
    {
        $bilan = $etudiant->bilanCompetence;

        return (object) [
            'etudiant' => $etudiant,
            'moy_semestre1' => (float) ($etudiant->getMoyenneSemestre(1) ?? 0),
            'moy_semestre2' => (float) ($etudiant->getMoyenneSemestre(2) ?? 0),
            // Cast en float explicite pour éviter les erreurs d'affichage
            'moy_competences' => (float) ($bilan->moy_competences ?? 0),
            'moyenne_generale' => (float) ($bilan->moyenne_generale ?? 0),
            // Vérification sécurisée : si la moyenne existe et est >= 10, c'est vrai.
            'is_admis' => isset($bilan->moyenne_generale) && $bilan->moyenne_generale >= 10,
            'evaluations_s1' => $etudiant->getEvaluationsBySemestre(1),
            'evaluations_s2' => $etudiant->getEvaluationsBySemestre(2),
        ];
    }

    /**
     * Calcule les statistiques détaillées pour une collection d'étudiants
     */
    public function calculateDetailedStats(Collection $etudiants): array
    {
        $stats = [
            'total' => $etudiants->count(),
            'admis' => $etudiants->filter(fn ($e) => $e->is_admis)->count(),
            'moyenne_generale' => $etudiants->avg('moyenne_generale'),
            'moy_semestre1' => $etudiants->avg('moy_semestre1'),
            'moy_semestre2' => $etudiants->avg('moy_semestre2'),
            'moy_competences' => $etudiants->avg('moy_competences'),
            'meilleure_moyenne' => $etudiants->max('moyenne_generale'),
            'moyenne_plus_basse' => $etudiants->min('moyenne_generale'),
        ];

        $stats['non_admis'] = $stats['total'] - $stats['admis'];
        $stats['taux_admission'] = $stats['total'] > 0 ? ($stats['admis'] / $stats['total']) * 100 : 0;

        return $stats;
    }
}
