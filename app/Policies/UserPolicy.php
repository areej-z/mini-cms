<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Determine whether the user can update the target user's role.
     */
    public function updateRole(User $user, User $target): bool
    {
        return $user->isAdmin() && $user->id !== $target->id;
    }
}
