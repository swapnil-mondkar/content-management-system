<?php

namespace App\Http\Controllers\V1\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use App\Services\AuthService;
use App\Traits\ResponseTrait;

/**
 * Class AuthController
 * Handles user authentication actions such as login and logout.
 *
 * @package App\Http\Controllers\V1\Api
 */
class AuthController extends Controller
{
    /**
     * Trait for standardized API responses.
     */
    use ResponseTrait;

    /**
     * The AuthService instance.
     *
     * @var AuthService
     */
    protected $authService;

    /**
     * AuthController constructor.
     *
     * @param AuthService $authService
     */
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Handle user login.
     *
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $validated = $request->validated();

        $result = $this->authService->login($validated['email'], $validated['password']);

        if (!$result) {
            return $this->errorResponse('Invalid credentials', 401);
        }

        return $this->successResponse('Login successful', $result);
    }

    /**
     * Handle user logout.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $this->authService->logout($request->user());

        return $this->successResponse('Logged out successfully');
    }
}
