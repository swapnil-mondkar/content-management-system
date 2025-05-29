<?php

namespace App\Http\Middleware;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Middleware\Authenticate;

/**
 * Class ApiAuthenticate
 *
 * Middleware to handle API authentication.
 * It overrides the unauthenticated method to throw an exception for API requests.
 */
class ApiAuthenticate extends Authenticate
{

    protected function unauthenticated($request, array $guards)
    {
        if ($request->is('api/*')) {
            throw new AuthenticationException(
                'Unauthenticated.',
                $guards,
                $this->redirectTo($request)
            );
        }

        parent::unauthenticated($request, $guards);
    }

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request): ?string
    {
        return $request->expectsJson() ? null : null;
    }
}
