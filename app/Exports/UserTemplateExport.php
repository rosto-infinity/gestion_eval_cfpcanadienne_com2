<?php

declare(strict_types=1);

namespace App\Exports;

use App\Models\AnneeAcademique;
use App\Models\Specialite;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Protection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UserTemplateExport implements FromArray, ShouldAutoSize, WithEvents, WithHeadings, WithStyles
{
    public function array(): array
    {
        return []; // Template vide avec juste les en-têtes
    }

    public function headings(): array
    {
        return [
            'Nom et Prénom',
            'Email',
            'Matricule (optionnel - sera généré automatiquement)',
            'Sexe (M/F/Autre)',
            'Niveau',
            'Spécialité',
            'Année Académique',
            'Date de naissance (DD/MM/YYYY)',
            'Lieu de naissance',
            'Nationalité',
            'Téléphone',
            'Téléphone d\'urgence',
            'Adresse',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => [
                    'bold' => true,
                    'size' => 12,
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FFE1E5E9'],
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['argb' => 'FF000000'],
                    ],
                ],
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event): void {
                $sheet = $event->sheet->getDelegate();
                $rowCount = 1000; // Appliquer la validation sur 1000 lignes

                // --- 1. Protection de la feuille ---
                $sheet->getParent()->getSecurity()->setLockWindows(true);
                $sheet->getParent()->getSecurity()->setLockStructure(true);
                $sheet->getProtection()->setSheet(true);

                // Déverrouiller les cellules de données (A2:P1000)
                $sheet->getStyle('A2:P'.$rowCount)->getProtection()->setLocked(Protection::PROTECTION_UNPROTECTED);

                // --- 2. Validations de Données (Dropdowns) ---

                // Colonne D (Sexe) : M, F, Autre
                $this->addDropdown($sheet, 'D2:D'.$rowCount, ['M', 'F', 'Autre']);

                // Colonne E (Niveau)
                $niveaux = array_map(fn ($case) => $case->label(), \App\Enums\Niveau::cases());
                $this->addDropdown($sheet, 'E2:E'.$rowCount, $niveaux);

                // Colonne F (Spécialité)
                $specialites = Specialite::pluck('intitule')->toArray();
                if (! empty($specialites)) {
                    $this->addDropdownFromHiddenSheet($sheet, 'F2:F'.$rowCount, $specialites, 'SpecialitesList');
                }

                // Colonne G (Année Académique)
                $annees = AnneeAcademique::pluck('libelle')->toArray();
                if (! empty($annees)) {
                    $this->addDropdown($sheet, 'G2:G'.$rowCount, $annees);
                }
            },
        ];
    }

    /**
     * Helper pour ajouter une validation simple (liste directe)
     */
    private function addDropdown(Worksheet $sheet, string $range, array $options): void
    {
        $validation = $sheet->getCell(explode(':', $range)[0])->getDataValidation();
        $validation->setType(DataValidation::TYPE_LIST);
        $validation->setErrorStyle(DataValidation::STYLE_INFORMATION);
        $validation->setAllowBlank(true);
        $validation->setShowInputMessage(true);
        $validation->setShowErrorMessage(true);
        $validation->setShowDropDown(true);
        $validation->setErrorTitle('Erreur de saisie');
        $validation->setError('Veuillez sélectionner une valeur dans la liste.');
        $validation->setFormula1('"'.implode(',', $options).'"');

        $sheet->setDataValidation($range, $validation);
    }

    /**
     * Helper pour ajouter une validation via une feuille cachée (pour les longues listes)
     */
    private function addDropdownFromHiddenSheet(Worksheet $mainSheet, string $range, array $options, string $namedRange): void
    {
        // Créer la feuille de données si elle n'existe pas
        $spreadsheet = $mainSheet->getParent();
        if (! $spreadsheet->sheetNameExists('DataValidation')) {
            $dataSheet = $spreadsheet->createSheet();
            $dataSheet->setTitle('DataValidation');
            $dataSheet->setSheetState(Worksheet::SHEETSTATE_HIDDEN);
        } else {
            $dataSheet = $spreadsheet->getSheetByName('DataValidation');
        }

        // Écrire les options dans une colonne libre
        // Pour simplifier, on utilise une colonne par liste nommée.
        // Gestion basique des colonnes : A=1, B=2...
        static $colIndex = 1;
        $colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex);

        foreach ($options as $k => $option) {
            $dataSheet->setCellValue($colLetter.($k + 1), $option);
        }

        // Définir la plage nommée
        $lastRow = count($options);
        $formula = "DataValidation!\${$colLetter}\$1:\${$colLetter}\${$lastRow}";

        // Incrémenter pour la prochaine liste
        $colIndex++;

        // Appliquer la validation sur la feuille principale
        $validation = $mainSheet->getCell(explode(':', $range)[0])->getDataValidation();
        $validation->setType(DataValidation::TYPE_LIST);
        $validation->setErrorStyle(DataValidation::STYLE_INFORMATION);
        $validation->setAllowBlank(true);
        $validation->setShowInputMessage(true);
        $validation->setShowErrorMessage(true);
        $validation->setShowDropDown(true);
        $validation->setErrorTitle('Erreur de saisie');
        $validation->setError('Veuillez sélectionner une valeur dans la liste.');
        $validation->setFormula1($formula);

        $mainSheet->setDataValidation($range, $validation);
    }
}
