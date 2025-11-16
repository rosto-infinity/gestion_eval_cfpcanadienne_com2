<?php

declare(strict_types=1);

namespace App\Enums;

enum Niveau: string
{
    case TROISIEME = '3eme';
    case BEPC = 'bepc';
    case PREMIERE = 'premiere';
    case PROBATOIRE = 'probatoire';
    case TERMINALE = 'terminale';
    case BACC = 'bacc';
    case LICENCE = 'licence';
    case CEP = 'cep';

    public function label(): string
    {
        return match ($this) {
            self::TROISIEME => '3ème',
            self::BEPC => 'BEPC',
            self::PREMIERE => 'Première',
            self::PROBATOIRE => 'Probatoire',
            self::TERMINALE => 'Terminale',
            self::BACC => 'Baccalauréat',
            self::LICENCE => 'Licence',
            self::CEP => 'CEP',
        };
    }

    public function description(): string
    {
        return match ($this) {
            self::TROISIEME => 'Classe de 3ème (Cycle d\'observation)',
            self::BEPC => 'Brevet d\'Études du Premier Cycle',
            self::PREMIERE => 'Classe de Première',
            self::PROBATOIRE => 'Probatoire',
            self::TERMINALE => 'Classe de Terminale',
            self::BACC => 'Baccalauréat',
            self::LICENCE => 'Licence (Bac+3)',
            self::CEP => 'Certificat d\'Études Primaires',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function options(): array
    {
        return array_map(
            fn ($case) => [
                'value' => $case->value,
                'label' => $case->label(),
                'description' => $case->description(),
            ],
            self::cases()
        );
    }

    public static function grouped(): array
    {
        return [
            'Primaire' => [
                self::CEP->value => self::CEP->label(),
            ],
            'Secondaire (1er cycle)' => [
                self::TROISIEME->value => self::TROISIEME->label(),
                self::BEPC->value => self::BEPC->label(),
            ],
            'Secondaire (2nd cycle)' => [
                self::PREMIERE->value => self::PREMIERE->label(),
                self::PROBATOIRE->value => self::PROBATOIRE->label(),
                self::TERMINALE->value => self::TERMINALE->label(),
                self::BACC->value => self::BACC->label(),
            ],
            'Supérieur' => [
                self::LICENCE->value => self::LICENCE->label(),
            ],
        ];
    }
}
