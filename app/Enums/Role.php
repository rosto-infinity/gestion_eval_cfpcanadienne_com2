<?php

declare(strict_types=1);

namespace App\Enums;

use App\Enums\Traits\EnumHelpers;

enum Role: string
{
    use EnumHelpers;

    // enums
    case SUPERADMIN = 'superadmin';
    case ADMIN = 'admin';
    case MANAGER = 'manager';
    case USER = 'user';

    public static function fromString(?string $role): ?self
    {
        return $role ? self::tryFrom(strtolower(trim($role))) : null;
    }

    public static function default(): self
    {
        return self::fromString(config('roles.default')) ?? self::USER;
    }

    public static function superadmin(): self
    {
        return self::fromString(config('roles.superadmin')) ?? self::SUPERADMIN;
    }

    public function level(): int
    {
        return match ($this) {
            self::SUPERADMIN => 100,
            self::ADMIN => 80,
            self::MANAGER => 50,
            self::USER => 10,
        };
    }

    public function isAtLeast(self $role): bool
    {
        return $this->level() >= $role->level();
    }

    public function label(): string
    {
        return match ($this) {
            self::SUPERADMIN => __('Super Administrateur'),
            self::ADMIN => __('Administrateur'),
            self::MANAGER => __('Gestionnaire'),
            self::USER => __('Utilisateur'),
        };
    }

    public function permissions(): array
    {
        return config("roles.permissions.{$this->value}", []);
    }

    public function hasPermission(string $permission): bool
    {
        $permissions = $this->permissions();

        return in_array('*', $permissions) || in_array($permission, $permissions);
    }
}
