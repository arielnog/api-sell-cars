<?php

namespace App\Http\Middleware;

use App\Exceptions\ForbiddenException;
use App\Services\UserService;
use Closure;
use Illuminate\Http\Request;

class ValidateXApiKey
{
    public function handle(Request $request, Closure $next)
    {
        $xApiKey = $request->header('x-api-key');

        if (!empty($xApiKey)){
            $userService = app(UserService::class);
            $validateToken = $userService->validateXApiToken($xApiKey);

            if ($validateToken)
                return $next($request);
        }
        //TODO: Criar error code list
        throw new ForbiddenException();
    }
}
