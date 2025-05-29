<?php

namespace App\Repositories;

use App\Models\User;

/**
 * Class AuthRepository
 *
 * This class handles authentication-related database operations.
 */
class AuthRepository
{
    /**
     * Find a user by their email address.
     *
     * @param string $email
     * @return User|null
     */
    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }
}
