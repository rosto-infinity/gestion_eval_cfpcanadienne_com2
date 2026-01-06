<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\AnneeAcademique;
use App\Models\BilanCompetence;
use App\Models\Specialite;
use App\Services\PdfService;
use App\Services\SpecialiteStatsService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BilanSpecialiteController extends Controller
{
    public function __construct(
        private SpecialiteStatsService $statsService,
        private PdfService $pdfService
    ) {}

    public function index(Request $request): View
    {
        $anneeActive = AnneeAcademique::active()->first();
        $anneeId = (int) $request->input('annee_id', $anneeActive?->id ?? AnneeAcademique::latest()->first()?->id);

        $bilanParSpecialite = $this->statsService->getBilanParSpecialite($anneeId);
        $statsGlobales = $this->statsService->calculateStatsGlobales($bilanParSpecialite);
        $annees = AnneeAcademique::ordered()->get();

        return view('bilanspecialite.bilan-specialite', compact(
            'bilanParSpecialite',
            'statsGlobales',
            'annees',
            'anneeActive'
        ));
    }

    public function show(Request $request, Specialite $specialite): View
    {
        $anneeId = $request->input('annee_id') ?? AnneeAcademique::active()->first()?->id;

        if (! $anneeId) {
            $anneeId = AnneeAcademique::ordered()->first()?->id;
        }

        // 1. Récupérer les bilans avec les relations
        // 2. CORRECTION : On fait un JOIN explicite sur 'modules' pour le trier par code (M1...M10)
        //    et on fait un SELECT('evaluations.*') pour ne récupérer que les colonnes d'évaluations.
        $bilans = BilanCompetence::with(['user.specialite', 'anneeAcademique', 'user.evaluations' => function ($q) use ($anneeId): void {
            $q->where('annee_academique_id', $anneeId)
                ->select('evaluations.*')
                ->join('modules', 'evaluations.module_id', '=', 'modules.id')
                ->orderBy('modules.code')
                ->with('module'); // S'assurer que la relation module est chargée
        }])
            ->whereHas('user', function ($q) use ($specialite, $anneeId): void {
                $q->where('specialite_id', $specialite->id);
                if ($anneeId) {
                    $q->where('annee_academique_id', $anneeId);
                }
            })
            ->orderByDesc('moyenne_generale')
            ->get();

        // 2. Calcul des stats (optimisé)
        $stats = [
            'total' => $bilans->count(),
            'admis' => $bilans->filter(fn ($b) => $b->moyenne_generale >= 10)->count(),
            'moyenne_generale' => $bilans->avg('moyenne_generale'),
            'moy_competences' => $bilans->avg('moy_competences'),
            'moy_semestre1' => $bilans->avg('moy_eval_semestre1'),
            'moy_semestre2' => $bilans->avg('moy_eval_semestre2'),
            'meilleure_moyenne' => $bilans->max('moyenne_generale'),
            'moyenne_plus_basse' => $bilans->min('moyenne_generale'),
        ];

        $stats['non_admis'] = $stats['total'] - $stats['admis'];
        $stats['taux_admission'] = $stats['total'] > 0 ? ($stats['admis'] / $stats['total']) * 100 : 0;

        $annees = AnneeAcademique::ordered()->get();
        $anneeActive = AnneeAcademique::active()->first();

        return view('bilanspecialite.detail-specialite', compact(
            'specialite',
            'bilans', // On envoie la variable $bilans
            'stats',
            'annees',
            'anneeActive'
        ));
    }

    public function exportPdf(Request $request)
    {
        $anneeId = $request->input('annee_id') ?? AnneeAcademique::active()->first()?->id;

        $bilanParSpecialite = $this->statsService->getBilanParSpecialite($anneeId);
        $statsGlobales = $this->statsService->calculateStatsGlobales($bilanParSpecialite);
        $annee = AnneeAcademique::find($anneeId);

        return $this->pdfService->generateBilanSpecialitePdf([
            'bilanParSpecialite' => $bilanParSpecialite,
            'statsGlobales' => $statsGlobales,
            'annee' => $annee,
        ]);
    }

    public function exportDetailPdf(Request $request, Specialite $specialite)
    {
        $anneeId = $request->input('annee_id') ?? AnneeAcademique::active()->first()?->id;

        if (! $anneeId) {
            $anneeId = AnneeAcademique::ordered()->first()?->id;
        }

        // Utiliser la MÊME logique que la méthode show() pour la cohérence
        $bilans = BilanCompetence::with(['user.specialite', 'anneeAcademique', 'user.evaluations' => function ($q) use ($anneeId): void {
            $q->where('annee_academique_id', $anneeId)
                ->select('evaluations.*')
                ->join('modules', 'evaluations.module_id', '=', 'modules.id')
                ->orderBy('modules.code')
                ->with('module'); // S'assurer que la relation module est chargée
        }])
            ->whereHas('user', function ($q) use ($specialite, $anneeId): void {
                $q->where('specialite_id', $specialite->id);
                if ($anneeId) {
                    $q->where('annee_academique_id', $anneeId);
                }
            })
            ->orderByDesc('moyenne_generale')
            ->get();

        // Calcul des stats (optimisé)
        $stats = [
            'total' => $bilans->count(),
            'admis' => $bilans->filter(fn ($b) => $b->moyenne_generale >= 10)->count(),
            'moyenne_generale' => $bilans->avg('moyenne_generale'),
            'moy_competences' => $bilans->avg('moy_competences'),
            'moy_semestre1' => $bilans->avg('moy_eval_semestre1'),
            'moy_semestre2' => $bilans->avg('moy_eval_semestre2'),
            'meilleure_moyenne' => $bilans->max('moyenne_generale'),
            'moyenne_plus_basse' => $bilans->min('moyenne_generale'),
        ];

        $stats['non_admis'] = $stats['total'] - $stats['admis'];
        $stats['taux_admission'] = $stats['total'] > 0 ? ($stats['admis'] / $stats['total']) * 100 : 0;

        $annee = AnneeAcademique::find($anneeId);

        return $this->pdfService->generateDetailSpecialitePdf([
            'specialite' => $specialite,
            'bilans' => $bilans, // Utiliser $bilans comme la version web
            'stats' => $stats,
            'annee' => $annee,
        ]);
    }

    public function comparaison(Request $request): View
    {
        $anneeId = (int) ($request->input('annee_id') ?? AnneeAcademique::active()->first()?->id ?? 0);

        if ($anneeId === 0) {
            $anneeId = (int) AnneeAcademique::ordered()->first()?->id ?? 0;
        }

        $specialiteIds = array_map('intval', (array) $request->input('specialites', []));

        if (empty($specialiteIds)) {
            $specialiteIds = Specialite::pluck('id')->map(fn ($id) => (int) $id)->toArray();
        }

        $bilanParSpecialite = $this->statsService->getBilanParSpecialite($anneeId, $specialiteIds);

        $annees = AnneeAcademique::ordered()->get();
        $specialites = Specialite::ordered()->get();

        return view('bilanspecialite.comparaison-specialites', compact(
            'bilanParSpecialite',
            'annees',
            'specialites',
            'specialiteIds',
            'anneeId'
        ));
    }
}
