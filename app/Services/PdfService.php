<?php

declare(strict_types=1);

namespace App\Services;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;

class PdfService
{
    /**
     * Configuration par défaut pour les PDFs
     */
    private array $defaultOptions = [
        'defaultFont' => 'DejaVu Sans',
        'isHtml5ParserEnabled' => true,
        'isRemoteEnabled' => true,
        'margin_top' => 10,
        'margin_right' => 10,
        'margin_bottom' => 10,
        'margin_left' => 10,
    ];

    /**
     * Génère un PDF en portrait (A4 standard)
     */
    public function generatePortraitPdf(string $view, array $data, string $filename): Response
    {
        return $this->generatePdf($view, $data, $filename, 'portrait');
    }

    /**
     * Génère un PDF en paysage (A4 -> utilisé pour le tableau)
     */
    public function generateLandscapePdf(string $view, array $data, string $filename): Response
    {
        return $this->generatePdf($view, $data, $filename, 'landscape');
    }

    /**
     * Méthode générique de génération
     */
    public function generatePdf(
        string $view,
        array $data,
        string $filename,
        string $orientation = 'portrait',
        array $customOptions = []
    ): Response {
        $options = array_merge($this->defaultOptions, $customOptions);

        $pdf = Pdf::loadView($view, $data)
            ->setPaper('a4', $orientation)
            ->setOptions($options);

        return $pdf->download($filename);
    }

    /**
     * Génère un nom de fichier horodaté
     * ✅ Accepte maintenant les valeurs null
     */
    public function generateTimestampedFilename(string $prefix, ?string $identifier = ''): string
    {
        $parts = [$prefix];

        // ✅ Gère les valeurs null et vides
        if (!empty($identifier)) {
            $parts[] = $identifier;
        }

        $parts[] = now()->format('Ymd_His');

        return implode('_', $parts).'.pdf';
    }

    /**
     * PDF Relevé de Notes
     * ✅ Gère le cas où matricule est null
     */
    public function generateReleveNotesPdf(array $data): Response
    {
        $matricule = $data['user']->matricule ?? 'user_'.$data['user']->id;
        
        $filename = $this->generateTimestampedFilename(
            'releve_notes',
            $matricule
        );

        return $this->generatePortraitPdf(
            'evaluations.releve-notes-pdf',
            $data,
            $filename
        );
    }

    /**
     * PDF Bilan individuel
     * ✅ Gère le cas où matricule est null
     */
    public function generateBilanPdf(array $data): Response
    {
        $matricule = $data['bilan']->user->matricule ?? 'user_'.$data['bilan']->user->id;
        
        $filename = $this->generateTimestampedFilename(
            'bilan_competences',
            $matricule
        );

        return $this->generatePortraitPdf(
            'bilans.bilan-pdf',
            $data,
            $filename
        );
    }

    /**
     * PDF Tableau Récapitulatif
     */
    public function generateTableauRecapitulatifPdf(array $data): Response
    {
        $anneeLabel = $data['annee'] ? $data['annee']->libelle : 'all';
        
        $filename = $this->generateTimestampedFilename(
            'tableau_recapitulatif',
            $anneeLabel
        );

        return $this->generateLandscapePdf(
            'bilans.tableau-recapitulatif-pdf',
            $data,
            $filename
        );
    }

    /**
     * PDF Bilan par spécialité
     */
    public function generateBilanSpecialitePdf(array $data): Response
    {
        $anneeLabel = $data['annee'] ? $data['annee']->libelle : 'all';
        
        $filename = $this->generateTimestampedFilename(
            'bilan_specialite',
            $anneeLabel
        );

        return $this->generateLandscapePdf(
            'bilanspecialite.bilan-specialite-pdf',
            $data,
            $filename
        );
    }

    /**
     * PDF Détail de spécialité
     */
    public function generateDetailSpecialitePdf(array $data): Response
    {
        $anneeLabel = $data['annee'] ? $data['annee']->libelle : 'all';
        
        $filename = $this->generateTimestampedFilename(
            'detail_'.$data['specialite']->code,
            $anneeLabel
        );

        return $this->generateLandscapePdf(
            'bilanspecialite.detail-specialite-pdf',
            $data,
            $filename
        );
    }
}
