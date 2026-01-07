<?php

declare(strict_types=1);

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class UsersBySpecialiteExport implements FromCollection, WithHeadings, WithMapping, WithColumnWidths, WithStyles, WithTitle
{
    protected $users;

    public function __construct($users)
    {
        $this->users = $users;
    }

    public function collection()
    {
        return $this->users;
    }

    public function title(): string
    {
        return 'Utilisateurs par Spécialité';
    }

    public function headings(): array
    {
        return [
            'ID',
            'Matricule',
            'Nom et Prénom',
            'Email',
            'Téléphone',
            'Téléphone d\'urgence',
            'Sexe',
            'Date de naissance',
            'Lieu de naissance',
            'Nationalité',
            'Niveau',
            'Spécialité',
            'Année académique',
            'Statut',
            'Adresse',
            'Pièce d\'identité',
            'Date de création'
        ];
    }

    public function map($user): array
    {
        return [
            $user->id,
            $user->matricule ?? '-',
            $user->name,
            $user->email,
            $user->telephone ?? '-',
            $user->telephone_urgence ?? '-',
            $user->sexe ?? '-',
            $user->date_naissance ? $user->date_naissance : '-',
            $user->lieu_naissance ?? '-',
            $user->nationalite ?? '-',
            $user->niveau?->name ?? '-',
            $user->specialite?->intitule ?? '-',
            $user->anneeAcademique?->libelle ?? '-',
            $user->statut ?? '-',
            $user->adresse ?? '-',
            $user->piece_identite ?? '-',
            $user->created_at->format('d/m/Y H:i'),
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 8,    // ID
            'B' => 12,   // Matricule
            'C' => 25,   // Nom et Prénom
            'D' => 30,   // Email
            'E' => 15,   // Téléphone
            'F' => 18,   // Téléphone d'urgence
            'G' => 8,    // Sexe
            'H' => 12,   // Date de naissance
            'I' => 15,   // Lieu de naissance
            'J' => 12,   // Nationalité
            'K' => 10,   // Niveau
            'L' => 20,   // Spécialité
            'M' => 18,   // Année académique
            'N' => 10,   // Statut
            'O' => 30,   // Adresse
            'P' => 18,   // Pièce d'identité
            'Q' => 18,   // Date de création
        ];
    }

    public function styles($sheet)
    {
        return [
            // Style pour l'en-tête
            1 => [
                'font' => [
                    'bold' => true,
                    'size' => 12,
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FFDC3545']
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_LEFT,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['argb' => 'FF000000']
                    ],
                ],
            ],
            // Style pour les données
            'A2:Q1000' => [
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_LEFT,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => 'DDDDDD'],
                    ],
                ],
            ],
        ];
    }
}
