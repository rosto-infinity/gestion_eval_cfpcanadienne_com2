<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\AnneeAcademique;
use App\Models\Specialite;
use App\Services\SpecialiteStatsService;
use App\Services\PdfService;
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

        $etudiants = $this->statsService->getEtudiantsWithStats($specialite, $anneeId);
        $stats = $this->statsService->calculateDetailedStats($etudiants);

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

        $etudiants = $this->statsService->getEtudiantsWithStats($specialite, $anneeId);
        $stats = $this->statsService->calculateDetailedStats($etudiants);

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

        return $this->pdfService->generateDetailSpecialitePdf([
            'specialite' => $specialite,
            'etudiants' => $etudiants,
            'stats' => $stats,
            'statsGlobales' => $statsGlobales,
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