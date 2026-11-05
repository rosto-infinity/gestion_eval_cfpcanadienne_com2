<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\InstitutionArrete;
use Illuminate\Database\Seeder;

class InstitutionArreteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Arrêté ministériel principal en vigueur (bandeau supérieur)
        InstitutionArrete::firstOrCreate(
            ['type' => 'principal'],
            [
                'numero' => '000355/ MINEFOP/SG/DFOP/SDGSF/SBACD/CBAC',
                'texte' => 'Créé et agréé, renouvelé par Arrêté ministériel N° 000355/ MINEFOP/SG/DFOP/SDGSF/SBACD/CBAC',
                'ordre' => 1,
                'is_active' => true,
            ]
        );

        // 2. Visas administratifs historiques ordonnés ("Vu l'Arrêté...")
        $visas = [
            [
                'type' => 'visa',
                'numero' => '159/MINEFOP/SG/DFOP/SDGSF/SACD',
                'date_arrete' => '2020-04-03',
                'texte' => "Vu l'Arrêté n° 159/MINEFOP/SG/DFOP/SDGSF/SACD du 03 avril 2020 portant agrément du Centre de Formation Professionnelle La Canadienne ;",
                'ordre' => 1,
                'is_active' => true,
            ],
            [
                'type' => 'visa',
                'numero' => '00000226/MINEFOP/SG/DFOP/SDGSF/CSACD/CBAC',
                'date_arrete' => '2022-05-06',
                'texte' => "Vu l'Arrêté n° 00000226/MINEFOP/SG/DFOP/SDGSF/CSACD/CBAC du 06 mai 2022 portant renouvellement d'agrément dudit Centre ;",
                'ordre' => 2,
                'is_active' => true,
            ],
            [
                'type' => 'visa',
                'numero' => '000355/MINEFOP/SG/DFOP/SDGSF/CSACD/CBAC',
                'date_arrete' => '2025-06-10',
                'texte' => "Vu l'Arrêté n° 000355/MINEFOP/SG/DFOP/SDGSF/CSACD/CBAC du 10 juin 2025 portant renouvellement d'agrément dudit Centre",
                'ordre' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($visas as $visa) {
            InstitutionArrete::firstOrCreate(
                [
                    'type' => 'visa',
                    'numero' => $visa['numero'],
                ],
                $visa
            );
        }
    }
}
