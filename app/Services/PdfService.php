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
     * Génère un PDF en portrait
     */
    public function generatePortraitPdf(string $view, array $data, string $filename): Response
    {
        return $this->generatePdf($view, $data, $filename, 'portrait');
    }

    /**
     * Génère un PDF en paysage
     */
    public function generateLandscapePdf(string $view, array $data, string $filename): Response
    {
        return $this->generatePdf($view, $data, $filename, 'landscape');
    }

    /**
     * Génère un PDF avec configuration personnalisée
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
     */
    public function generateTimestampedFilename(string $prefix, string $identifier = ''): string
    {
        $parts = [$prefix];
        
        if (!empty($identifier)) {
            $parts[] = $identifier;
        }
        
        $parts[] = now()->format('Ymd_His');
        
        return implode('_', $parts) . '.pdf';
    }

    /**
     * Génère un PDF de relevé de notes
     */
    public function generateReleveNotesPdf(array $data): Response
    {
        $filename = $this->generateTimestampedFilename(
            'releve_notes',
            $data['user']->matricule
        );

        return $this->generatePortraitPdf(
            'evaluations.releve-notes-pdf',
            $data,
            $filename
        );
    }

    /**
     * Génère un PDF de bilan de compétences
     */
    public function generateBilanPdf(array $data): Response
    {
        $filename = $this->generateTimestampedFilename(
            'bilan_competences',
            $data['bilan']->user->matricule
        );

        return $this->generatePortraitPdf(
            'bilans.bilan-pdf',
            $data,
            $filename
        );
    }

    /**
     * Génère un PDF de tableau récapitulatif
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
     * Génère un PDF de bilan par spécialité
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
     * Génère un PDF de détail de spécialité
     */
    public function generateDetailSpecialitePdf(array $data): Response
    {
        $anneeLabel = $data['annee'] ? $data['annee']->libelle : 'all';
        $filename = $this->generateTimestampedFilename(
            'detail_' . $data['specialite']->code,
            $anneeLabel
        );

        return $this->generateLandscapePdf(
            'bilanspecialite.detail-specialite-pdf',
            $data,
            $filename
        );
    }
}