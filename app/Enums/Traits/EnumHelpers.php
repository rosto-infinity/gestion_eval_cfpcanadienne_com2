<?php

declare(strict_types=1);

namespace App\Enums\Traits;

trait EnumHelpers
{
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function exists(?string $value): bool
    {
        return $value !== null && self::tryFrom(strtolower(trim($value))) !== null;
    }
}
