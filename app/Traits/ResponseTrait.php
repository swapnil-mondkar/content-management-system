<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

/**
 * Trait ResponseTrait
 *
 * Provides methods for standardized API responses.
 *
 * @package App\Traits
 */
trait ResponseTrait
{
    /**
     * Generate a successful response.
     *
     * @param string $message
     * @param mixed $data
     * @param int $code
     * @return JsonResponse
     */
    public function successResponse(string $message = 'Success', $data = null, int $code = 200): JsonResponse
    {
        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    /**
     * Generate an error response.
     *
     * @param string $message
     * @param int $code
     * @param mixed $errors
     * @return JsonResponse
     */
    public function errorResponse(string $message = 'Error', int $code = 400, $errors = null): JsonResponse
    {
        return response()->json([
            'status' => false,
            'message' => $message,
            'errors' => $errors,
        ], $code);
    }
}
