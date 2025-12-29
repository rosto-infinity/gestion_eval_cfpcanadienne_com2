<?php

declare(strict_types=1);

namespace App\Policies;

use App\Enums\Role;
use App\Models\User;

class UserPolicy
{
    /**
     * Déterminer si l'utilisateur peut voir le relevé de notes d'un autre.
     */
    public function viewReleve(User $authUser, User $targetUser): bool
    {
        // Règle : On peut voir le relevé si :
        // 1. On est le propriétaire du relevé ($authUser->id === $targetUser->id)
        // 2. OU on a un rôle de niveau MANAGER ou plus
        return $authUser->id === $targetUser->id
            || $authUser->role->isAtLeast(Role::MANAGER);
    }
}
