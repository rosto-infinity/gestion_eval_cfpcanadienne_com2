<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\AnneeAcademique;
use App\Models\Attestation;
use App\Models\InstitutionArrete;
use App\Models\Specialite;
use App\Models\User;
use App\Services\AttestationService;
use App\Services\PdfService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class AttestationController extends Controller
{
    public function __construct(
        protected AttestationService $attestationService,
        protected PdfService $pdfService
    ) {}

    /**
     * Interface de sélection et d'impression par spécialité
     */
    public function index(Request $request): View
    {
        $annees = AnneeAcademique::orderBy('date_debut', 'desc')->get();
        $selectedAnneeId = $request->integer('annee_id') ?: ($annees->firstWhere('is_active', true)?->id ?? $annees->first()?->id);
        $selectedAnnee = $annees->firstWhere('id', $selectedAnneeId);

        $specialites = Specialite::orderBy('intitule', 'asc')->get();
        $selectedSpecialiteId = $request->integer('specialite_id');
        $selectedSpecialite = $selectedSpecialiteId ? $specialites->firstWhere('id', $selectedSpecialiteId) : null;

        $students = collect();
        $existingAttestations = collect();

        if ($selectedSpecialite) {
            $query = User::studentsOnly()
                ->where('specialite_id', $selectedSpecialite->id);

            if ($selectedAnneeId) {
                $query->where('annee_academique_id', $selectedAnneeId);
            }

            $students = $query->orderBy('name', 'asc')->get();

            // Charger les éventuelles attestations déjà générées
            $existingAttestations = Attestation::whereIn('user_id', $students->pluck('id'))
                ->where('annee_academique_id', $selectedAnneeId)
                ->get()
                ->keyBy('user_id');
        }

        // Arrêtés par défaut
        $defaultArretes = $this->attestationService->getDefaultArretes();
        $allVisas = InstitutionArrete::visas()->ordered()->get();

        // Tranche de dates par défaut : basée sur l'année académique ou date du jour
        $defaultDateDebut = $selectedAnnee?->date_debut ? Carbon::parse($selectedAnnee->date_debut)->format('Y-m-d') : '2025-10-13';
        $defaultDateFin = $selectedAnnee?->date_fin ? Carbon::parse($selectedAnnee->date_fin)->format('Y-m-d') : '2026-09-21';
        $defaultDateDelivrance = now()->format('Y-m-d');

        return view('attestations.index', compact(
            'annees',
            'selectedAnnee',
            'specialites',
            'selectedSpecialite',
            'students',
            'existingAttestations',
            'defaultArretes',
            'allVisas',
            'defaultDateDebut',
            'defaultDateFin',
            'defaultDateDelivrance'
        ));
    }

    /**
     * Génération du PDF par lot (groupé pour les apprenants sélectionnés)
     */
    public function genererLotPdf(Request $request): Response
    {
        $request->validate([
            'selected_users' => 'required|array|min:1',
            'selected_users.*' => 'exists:users,id',
            'annee_academique_id' => 'required|exists:annees_academiques,id',
            'specialite_id' => 'nullable|exists:specialites,id',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            'date_delivrance' => 'required|date',
            'arrete_principal' => 'required|string',
            'visas_arretes' => 'nullable|array',
        ]);

        $selectedUserIds = $request->input('selected_users', []);
        $studentsInput = $request->input('students', []);

        $users = User::whereIn('id', $selectedUserIds)
            ->orderBy('name', 'asc')
            ->get();

        $items = [];
        $specialiteCode = 'MIX';

        if ($request->filled('specialite_id')) {
            $spec = Specialite::find($request->input('specialite_id'));
            $specialiteCode = $spec ? $spec->code : 'SPEC';
        }

        foreach ($users as $user) {
            $userCustom = $studentsInput[$user->id] ?? [];

            // Paramètres individuels ou hérités du global
            $userParams = [
                'annee_academique_id' => $request->input('annee_academique_id'),
                'specialite_id' => $request->input('specialite_id') ?: $user->specialite_id,
                'specialite_personnalisee' => ! empty($userCustom['specialite_personnalisee'])
                    ? trim($userCustom['specialite_personnalisee'])
                    : null,
                'date_debut' => ! empty($userCustom['date_debut']) ? $userCustom['date_debut'] : $request->input('date_debut'),
                'date_fin' => ! empty($userCustom['date_fin']) ? $userCustom['date_fin'] : $request->input('date_fin'),
                'date_delivrance' => $request->input('date_delivrance'),
                'lieu_delivrance' => $request->input('lieu_delivrance', 'Bafoussam'),
                'arrete_principal' => $request->input('arrete_principal'),
                'visas_arretes' => $request->input('visas_arretes', []),
            ];

            $attestation = $this->attestationService->recordAttestation($user, $userParams);
            $items[] = $this->attestationService->formatItemForPdf($attestation);
        }

        $assets = $this->attestationService->getAssetsBase64();
        $filename = sprintf('attestations_%s_%s_%s.pdf', $specialiteCode, count($items).'apprenants', now()->format('Ymd_His'));

        $isStream = $request->boolean('preview');

        return $this->pdfService->generateAttestationLandscapePdf(
            'attestations.pdf-template',
            array_merge(['items' => $items], $assets),
            $filename,
            $isStream
        );
    }

    /**
     * Aperçu HTML à l'écran avant impression
     */
    public function apercu(Request $request, User $user): View
    {
        $attestation = Attestation::where('user_id', $user->id)->latest()->first();

        if (! $attestation) {
            // Création à la volée pour prévisualisation
            $attestation = $this->attestationService->recordAttestation($user, [
                'annee_academique_id' => $user->annee_academique_id,
                'specialite_id' => $user->specialite_id,
                'date_debut' => now()->subMonths(9),
                'date_fin' => now(),
                'date_delivrance' => now(),
            ]);
        }

        $item = $this->attestationService->formatItemForPdf($attestation);
        $assets = $this->attestationService->getAssetsBase64();

        return view('attestations.preview', array_merge(compact('item', 'attestation'), $assets));
    }

    /**
     * Télécharger une attestation individuelle
     */
    public function telechargerPdf(Attestation $attestation): Response
    {
        $item = $this->attestationService->formatItemForPdf($attestation);
        $assets = $this->attestationService->getAssetsBase64();
        $filename = sprintf('attestation_%s_%s.pdf', Str::slug($attestation->user->name), now()->format('Ymd'));

        return $this->pdfService->generateAttestationLandscapePdf(
            'attestations.pdf-template',
            array_merge(['items' => [$item]], $assets),
            $filename,
            false
        );
    }

    /**
     * Page de vérification publique accessible sans authentification
     */
    public function verifierPublique(string $token): View
    {
        $attestation = Attestation::with(['user', 'specialite', 'anneeAcademique'])
            ->where('token', $token)
            ->firstOrFail();

        return view('attestations.verification', compact('attestation'));
    }
}
