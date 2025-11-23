<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Specialite;
use App\Models\AnneeAcademique;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Barryvdh\DomPDF\Facade\Pdf;

class BilanSpecialiteController extends Controller
{
    /**
     * Affiche le tableau de bilan par spécialité
     */
    public function index(Request $request): View
    {
      $anneeId = (int) ($request->input('annee_id') ?? AnneeAcademique::active()->first()?->id);
        $anneeActive = AnneeAcademique::active()->first();

        $bilanParSpecialite = $this->getBilanParSpecialite($anneeId);
        $statsGlobales = $this->calculateStatsGlobales($bilanParSpecialite);
        $annees = AnneeAcademique::ordered()->get();

        return view('bilanspecialite.bilan-specialite', compact(
            'bilanParSpecialite',
            'statsGlobales',
            'annees',
            'anneeActive'
        ));
    }

    /**
     * Affiche le détail d'une spécialité avec tous les étudiants
     */
    public function show(Request $request, Specialite $specialite): View
    {
        $anneeId = $request->input('annee_id') ?? AnneeAcademique::active()->first()?->id;

        $etudiants = User::with(['evaluations.module', 'bilanCompetence', 'anneeAcademique'])
            ->where('specialite_id', $specialite->id)
            ->where('annee_academique_id', $anneeId)
            ->ordered()
            ->get()
            ->map(function($etudiant) {
                return (object)[
                    'etudiant' => $etudiant,
                    'moy_semestre1' => $etudiant->getMoyenneSemestre(1) ?? 0,
                    'moy_semestre2' => $etudiant->getMoyenneSemestre(2) ?? 0,
                    'moy_competences' => $etudiant->bilanCompetence?->moy_competences ?? 0,
                    'moyenne_generale' => $etudiant->bilanCompetence?->moyenne_generale ?? 0,
                    'is_admis' => $etudiant->bilanCompetence?->isAdmis() ?? false,
                    'evaluations_s1' => $etudiant->getEvaluationsBySemestre(1),
                    'evaluations_s2' => $etudiant->getEvaluationsBySemestre(2),
                ];
            })
            ->sortByDesc('moyenne_generale');

        $stats = [
            'total' => $etudiants->count(),
            'admis' => $etudiants->filter(fn($e) => $e->is_admis)->count(),
            'moy_generale' => $etudiants->avg('moyenne_generale'),
            'moy_semestre1' => $etudiants->avg('moy_semestre1'),
            'moy_semestre2' => $etudiants->avg('moy_semestre2'),
            'moy_competences' => $etudiants->avg('moy_competences'),
            'meilleure_moyenne' => $etudiants->max('moyenne_generale'),
            'moyenne_plus_basse' => $etudiants->min('moyenne_generale'),
        ];

        $stats['non_admis'] = $stats['total'] - $stats['admis'];
        $stats['taux_admission'] = $stats['total'] > 0 ? ($stats['admis'] / $stats['total']) * 100 : 0;

        $annees = AnneeAcademique::ordered()->get();
        $anneeActive = AnneeAcademique::active()->first();

        return view('bilanspecialite.detail-specialite', compact(
            'specialite',
            'etudiants',
            'stats',
            'annees',
            'anneeActive'
        ));
    }

    /**
     * Export PDF du bilan par spécialité
     */
    public function exportPdf(Request $request)
    {
        $anneeId = $request->input('annee_id') ?? AnneeAcademique::active()->first()?->id;
        
        $bilanParSpecialite = $this->getBilanParSpecialite($anneeId);
        $statsGlobales = $this->calculateStatsGlobales($bilanParSpecialite);
        $annee = AnneeAcademique::find($anneeId);

        $pdf = Pdf::loadView('bilanspecialite.bilan-specialite-pdf', compact(
            'bilanParSpecialite',
            'statsGlobales',
            'annee'
        ))
            ->setPaper('a4', 'landscape')
            ->setOptions([
                'defaultFont' => 'sans-serif',
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
            ]);

        $filename = 'bilan_specialite_' . ($annee ? $annee->libelle : 'all') . '_' . now()->format('Ymd') . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Export PDF du détail d'une spécialité
     * ✅ CORRIGÉ : Ajouter $statsGlobales
     */
    public function exportDetailPdf(Request $request, Specialite $specialite)
    {
        $anneeId = $request->input('annee_id') ?? AnneeAcademique::active()->first()?->id;

        $etudiants = User::with(['evaluations.module', 'bilanCompetence', 'anneeAcademique'])
            ->where('specialite_id', $specialite->id)
            ->where('annee_academique_id', $anneeId)
            ->ordered()
            ->get()
            ->map(function($etudiant) {
                return (object)[
                    'etudiant' => $etudiant,
                    'moy_semestre1' => $etudiant->getMoyenneSemestre(1) ?? 0,
                    'moy_semestre2' => $etudiant->getMoyenneSemestre(2) ?? 0,
                    'moy_competences' => $etudiant->bilanCompetence?->moy_competences ?? 0,
                    'moyenne_generale' => $etudiant->bilanCompetence?->moyenne_generale ?? 0,
                    'is_admis' => $etudiant->bilanCompetence?->isAdmis() ?? false,
                    'evaluations_s1' => $etudiant->getEvaluationsBySemestre(1),
                    'evaluations_s2' => $etudiant->getEvaluationsBySemestre(2),
                ];
            })
            ->sortByDesc('moyenne_generale');

        $stats = [
            'total' => $etudiants->count(),
            'admis' => $etudiants->filter(fn($e) => $e->is_admis)->count(),
            'moy_generale' => $etudiants->avg('moyenne_generale'),
            'moy_semestre1' => $etudiants->avg('moy_semestre1'),
            'moy_semestre2' => $etudiants->avg('moy_semestre2'),
            'moy_competences' => $etudiants->avg('moy_competences'),
            'meilleure_moyenne' => $etudiants->max('moyenne_generale'),
            'moyenne_plus_basse' => $etudiants->min('moyenne_generale'),
        ];

        $stats['non_admis'] = $stats['total'] - $stats['admis'];
        $stats['taux_admission'] = $stats['total'] > 0 ? ($stats['admis'] / $stats['total']) * 100 : 0;

        // ✅ NOUVEAU : Calculer les stats globales pour la spécialité
        $statsGlobales = [
            'total_specialites' => 1,
            'total_etudiants' => $stats['total'],
            'total_admis' => $stats['admis'],
            'total_non_admis' => $stats['non_admis'],
            'taux_admission' => $stats['taux_admission'],
            'moyenne_generale' => round($stats['moy_generale'], 2),
            'moy_semestre1' => round($stats['moy_semestre1'], 2),
            'moy_semestre2' => round($stats['moy_semestre2'], 2),
            'moy_competences' => round($stats['moy_competences'], 2),
            'meilleure_moyenne' => round($stats['meilleure_moyenne'], 2),
            'moyenne_plus_basse' => round($stats['moyenne_plus_basse'], 2),
        ];

        $annee = AnneeAcademique::find($anneeId);

        $pdf = Pdf::loadView('bilanspecialite.detail-specialite-pdf', compact(
            'specialite',
            'etudiants',
            'stats',
            'statsGlobales', // ✅ AJOUTÉ
            'annee'
        ))
            ->setPaper('a4', 'landscape')
            ->setOptions([
                'defaultFont' => 'sans-serif',
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
            ]);

        $filename = 'detail_' . $specialite->code . '_' . ($annee ? $annee->libelle : 'all') . '_' . now()->format('Ymd') . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Comparaison entre spécialités
     */
    public function comparaison(Request $request): View
    {
        $anneeId = $request->input('annee_id') ?? AnneeAcademique::active()->first()?->id;
        $specialiteIds = $request->input('specialites', []);

        if (empty($specialiteIds)) {
            $specialiteIds = Specialite::pluck('id')->toArray();
        }

        $bilanParSpecialite = $this->getBilanParSpecialite($anneeId, $specialiteIds);

        $annees = AnneeAcademique::ordered()->get();
        $specialites = Specialite::ordered()->get();

        return view('bilanspecialite.comparaison-specialites', compact(
            'bilanParSpecialite',
            'annees',
            'specialites',
            'specialiteIds'
        ));
    }

    /**
     * Récupère les données de bilan par spécialité
     */
    private function getBilanParSpecialite(int $anneeId, ?array $specialiteIds = null): \Illuminate\Support\Collection
    {
        $query = Specialite::query();

        if ($specialiteIds) {
            $query->whereIn('id', $specialiteIds);
        }

        return $query->withCount(['users' => function($q) use ($anneeId) {
                $q->where('annee_academique_id', $anneeId);
            }])
            ->with(['users' => function($q) use ($anneeId) {
                $q->where('annee_academique_id', $anneeId)
                  ->with(['evaluations.module', 'bilanCompetence']);
            }])
            ->get()
            ->map(function($specialite) {
                $etudiants = $specialite->users;
                
                if ($etudiants->isEmpty()) {
                    return null;
                }

                $moyS1Collection = $etudiants->map(fn($e) => $e->getMoyenneSemestre(1))->filter();
                $moyS2Collection = $etudiants->map(fn($e) => $e->getMoyenneSemestre(2))->filter();
                $moyCompCollection = $etudiants->map(fn($e) => $e->bilanCompetence?->moy_competences)->filter();
                $moyGenCollection = $etudiants->map(fn($e) => $e->bilanCompetence?->moyenne_generale)->filter();

                $moyS1 = $moyS1Collection->avg() ?? 0;
                $moyS2 = $moyS2Collection->avg() ?? 0;
                $moyComp = $moyCompCollection->avg() ?? 0;
                $moyGen = $moyGenCollection->avg() ?? 0;
                
                $admis = $etudiants->filter(fn($e) => $e->bilanCompetence?->isAdmis())->count();
                $nonAdmis = $etudiants->count() - $admis;
                $tauxAdmission = $etudiants->count() > 0 ? ($admis / $etudiants->count()) * 100 : 0;

                $meilleureMoyenne = $moyGenCollection->max() ?? 0;
                $moyennePlusBasse = $moyGenCollection->min() ?? 0;

                return (object)[
                    'specialite' => $specialite,
                    'total_etudiants' => $etudiants->count(),
                    'moy_semestre1' => round($moyS1, 2),
                    'moy_semestre2' => round($moyS2, 2),
                    'moy_competences' => round($moyComp, 2),
                    'moyenne_generale' => round($moyGen, 2),
                    'admis' => $admis,
                    'non_admis' => $nonAdmis,
                    'taux_admission' => round($tauxAdmission, 2),
                    'meilleure_moyenne' => round($meilleureMoyenne, 2),
                    'moyenne_plus_basse' => round($moyennePlusBasse, 2),
                ];
            })
            ->filter()
            ->sortByDesc('moyenne_generale')
            ->values();
    }

    /**
     * Calcule les statistiques globales
     */
    private function calculateStatsGlobales(\Illuminate\Support\Collection $bilanParSpecialite): array
    {
        $totalEtudiants = $bilanParSpecialite->sum('total_etudiants');
        $totalAdmis = $bilanParSpecialite->sum('admis');

        return [
            'total_specialites' => $bilanParSpecialite->count(),
            'total_etudiants' => $totalEtudiants,
            'total_admis' => $totalAdmis,
            'total_non_admis' => $totalEtudiants - $totalAdmis,
            'taux_admission' => $totalEtudiants > 0 
                ? round(($totalAdmis / $totalEtudiants) * 100, 2) 
                : 0,
            'moyenne_generale' => round($bilanParSpecialite->avg('moyenne_generale'), 2),
            'moy_semestre1' => round($bilanParSpecialite->avg('moy_semestre1'), 2),
            'moy_semestre2' => round($bilanParSpecialite->avg('moy_semestre2'), 2),
            'moy_competences' => round($bilanParSpecialite->avg('moy_competences'), 2),
            'meilleure_specialite' => $bilanParSpecialite->first(),
            'specialite_plus_faible' => $bilanParSpecialite->last(),
        ];
    }
}
