<?php

namespace App\Http\Middleware;

use App\Exceptions\UnathenticatedException;
use App\Helpers\ErrorsListHelpers;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param \Illuminate\Http\Request $request
     * @return void
     * @throws UnathenticatedException
     */
    protected function redirectTo($request): void
    {
        if (! $request->expectsJson()) {
           throw new UnathenticatedException(
               message: 'Unatheticated',
               code: ErrorsListHelpers::ERROR_GENERIC_WHEN_AUTHENTICATION
           );
        }
    }
}
