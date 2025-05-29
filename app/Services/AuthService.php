<?php

namespace App\Services;

use App\Repositories\AuthRepository;
use Illuminate\Support\Facades\Hash;

/**
 * Class AuthService
 *
 * This class handles authentication logic, including user login and logout.
 */
class AuthService
{

    /**
     * The AuthRepository instance.
     *
     * @var AuthRepository
     */
    protected $authRepository;

    /**
     * AuthService constructor.
     *
     * @param AuthRepository $authRepository
     */
    public function __construct(AuthRepository $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    /**
     * Handle user login.
     *
     * @param string $email
     * @param string $password
     * @return array|null
     */
    public function login(string $email, string $password)
    {
        $user = $this->authRepository->findByEmail($email);

        if (!$user || !Hash::check($password, $user->password)) {
            return null;
        }

        $token = $user->createToken('api-token')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token,
        ];
    }

    /**
     * Handle user logout.
     *
     * @param mixed $user
     * @return void
     */
    public function logout($user): void
    {
        $user->currentAccessToken()->delete();
    }
}
