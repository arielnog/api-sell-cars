<?php

namespace App\Http\Controllers;

use App\Exceptions\UnathenticatedException;
use App\Http\Requests\LoginFormRequest;
use DateTime;
use Illuminate\Http\JsonResponse;
use App\Services\AuthService;
use Illuminate\Http\Request;
use App\Traits\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class HealthController extends Controller
{
    use Response;

    public function index(): JsonResponse
    {
        return $this->responseSuccess(
            message: "Alive and Kicking!",
            resource: [
                'timestamp' => (new DateTime())->format('Y-m-d H:i:s'),
            ]
        );
    }
}
