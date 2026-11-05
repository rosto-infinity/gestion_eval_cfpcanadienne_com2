<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\AnneeAcademique;
use App\Models\Attestation;
use App\Models\InstitutionArrete;
use App\Models\Specialite;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AttestationService
{
    public function __construct(
        protected QrCodeService $qrCodeService,
        protected PdfService $pdfService
    ) {}

    /**
     * Obtenir l'image de fond encodée en base64 pour DomPDF
     */
    public function getBackgroundImageBase64(): ?string
    {
        return $this->fileToBase64(public_path('attestation/fond-attestation-cfpc.png'))
            ?? $this->fileToBase64(base_path('attestation/fond-attestation-cfpc.png'));
    }

    /**
     * Obtenir le logo MINEFOP en base64
     */
    public function getMinefopLogoBase64(): ?string
    {
        return $this->fileToBase64(public_path('attestation/logo-minefop.png'))
            ?? $this->fileToBase64(base_path('attestation/logo-minefop.png'));
    }

    /**
     * Obtenir le sceau/macaron d'authenticité (auth.png) en base64
     */
    public function getAuthSealBase64(): ?string
    {
        return $this->fileToBase64(public_path('attestation/auth.png'))
            ?? $this->fileToBase64(base_path('attestation/auth.png'));
    }

    /**
     * Obtenir le logo CFP Canadienne en base64
     */
    public function getCfpLogoBase64(): ?string
    {
        return $this->fileToBase64(public_path('CFPCanadienne.png'));
    }

    /**
     * Obtenir l'ensemble des assets graphiques en base64
     */
    public function getAssetsBase64(): array
    {
        return [
            'backgroundImageBase64' => $this->getBackgroundImageBase64(),
            'minefopLogoBase64' => $this->getMinefopLogoBase64(),
            'authSealBase64' => $this->getAuthSealBase64(),
            'cfpLogoBase64' => $this->getCfpLogoBase64(),
        ];
    }

    /**
     * Helper conversion fichier vers base64 Data URI
     */
    private function fileToBase64(string $path): ?string
    {
        if (! file_exists($path)) {
            return null;
        }

        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);

        return 'data:image/'.$type.';base64,'.base64_encode($data);
    }

    /**
     * Récupérer les arrêtés par défaut
     */
    public function getDefaultArretes(): array
    {
        $principal = InstitutionArrete::getPrincipal();
        $visas = InstitutionArrete::getActiveVisas();

        return [
            'principal' => $principal?->texte ?? 'Créé et agréé, renouvelé par Arrêté ministériel N° 000355/ MINEFOP/SG/DFOP/SDGSF/SBACD/CBAC',
            'visas' => $visas->pluck('texte')->toArray(),
        ];
    }

    /**
     * Crée ou met à jour l'enregistrement Attestation en base
     */
    public function recordAttestation(User $user, array $params): Attestation
    {
        $anneeId = ! empty($params['annee_academique_id'])
            ? (int) $params['annee_academique_id']
            : ($user->annee_academique_id ?? AnneeAcademique::where('is_active', true)->first()?->id);

        $specialiteId = ! empty($params['specialite_id'])
            ? (int) $params['specialite_id']
            : $user->specialite_id;

        $specialitePersonnalisee = ! empty($params['specialite_personnalisee'])
            ? trim((string) $params['specialite_personnalisee'])
            : null;

        // Détermination de l'intitulé final à imprimer
        if (! empty($specialitePersonnalisee)) {
            $specialiteLibelle = $specialitePersonnalisee;
        } elseif ($specialiteId) {
            $specialiteLibelle = Specialite::find($specialiteId)?->intitule ?? ($user->specialite?->intitule ?? 'Formation Professionnelle');
        } else {
            $specialiteLibelle = $user->specialite?->intitule ?? 'Formation Professionnelle';
        }

        $dateDebut = ! empty($params['date_debut'])
            ? Carbon::parse($params['date_debut'])
            : Carbon::now()->subMonths(9);

        $dateFin = ! empty($params['date_fin'])
            ? Carbon::parse($params['date_fin'])
            : Carbon::now();

        $dateDelivrance = ! empty($params['date_delivrance'])
            ? Carbon::parse($params['date_delivrance'])
            : Carbon::now();

        $lieuDelivrance = ! empty($params['lieu_delivrance'])
            ? (string) $params['lieu_delivrance']
            : 'Bafoussam';

        // Arrêté principal et visas
        $arretePrincipal = ! empty($params['arrete_principal'])
            ? (string) $params['arrete_principal']
            : $this->getDefaultArretes()['principal'];

        $visasArretes = ! empty($params['visas_arretes']) && is_array($params['visas_arretes'])
            ? array_values(array_filter($params['visas_arretes']))
            : $this->getDefaultArretes()['visas'];

        // Recherche d'une attestation existante pour cet étudiant et cette année
        $attestation = Attestation::where('user_id', $user->id)
            ->where('annee_academique_id', $anneeId)
            ->first();

        if (! $attestation) {
            $specialiteModel = $specialiteId ? Specialite::find($specialiteId) : $user->specialite;
            $anneeModel = AnneeAcademique::find($anneeId);

            $attestation = new Attestation([
                'user_id' => $user->id,
                'annee_academique_id' => $anneeId,
                'numero_attestation' => Attestation::generateNumero($specialiteModel ?? $specialiteLibelle, $anneeModel),
                'token' => Attestation::generateToken(),
                'created_by' => Auth::id(),
            ]);
        }

        $attestation->fill([
            'specialite_id' => $specialiteId,
            'specialite_personnalisee' => $specialitePersonnalisee,
            'specialite_libelle' => $specialiteLibelle,
            'date_debut' => $dateDebut,
            'date_fin' => $dateFin,
            'lieu_delivrance' => $lieuDelivrance,
            'date_delivrance' => $dateDelivrance,
            'arrete_principal' => $arretePrincipal,
            'visas_arretes' => $visasArretes,
        ]);

        $attestation->save();

        return $attestation;
    }

    /**
     * Génère l'URL publique et le QR code pour une attestation
     */
    public function generateQrCode(Attestation $attestation): string
    {
        $verificationUrl = route('attestations.verifier.public', ['token' => $attestation->token]);

        return $this->qrCodeService->generateTranscriptQrCode($verificationUrl);
    }

    /**
     * Prépare le paquet de données complet pour le rendu PDF
     */
    public function formatItemForPdf(Attestation $attestation): array
    {
        $user = $attestation->user;
        $sexe = strtoupper((string) ($user->sexe ?? ''));
        $prefixeNaissance = ($sexe === 'F') ? 'Née le' : 'Né le';

        $dateNaissance = $user->date_naissance
            ? Carbon::parse($user->date_naissance)->format('d/m/Y')
            : '..........';
        $lieuNaissance = strtoupper((string) ($user->lieu_naissance ?? '..........'));

        $qrCodeBase64 = $this->generateQrCode($attestation);

        return [
            'attestation' => $attestation,
            'user' => $user,
            'nom_apprenant' => strtoupper((string) $user->name),
            'prefixe_naissance' => $prefixeNaissance,
            'date_naissance' => $dateNaissance,
            'lieu_naissance' => $lieuNaissance,
            'date_debut_formatee' => $attestation->date_debut ? $attestation->date_debut->format('d/m/Y') : '',
            'date_fin_formatee' => $attestation->date_fin ? $attestation->date_fin->format('d/m/Y') : '',
            'date_delivrance_formatee' => $attestation->date_delivrance ? $attestation->date_delivrance->format('d/m/Y') : Carbon::now()->format('d/m/Y'),
            'specialite_libelle' => $attestation->specialite_libelle,
            'arrete_principal' => $attestation->arrete_principal,
            'visas_arretes' => $attestation->visas_arretes ?? [],
            'lieu_delivrance' => $attestation->lieu_delivrance,
            'numero_attestation' => $attestation->numero_attestation,
            'qr_code' => $qrCodeBase64,
        ];
    }
}
