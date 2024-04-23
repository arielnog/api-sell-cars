<?php

namespace App\Exceptions;

use App\Helpers\ErrorsListHelpers;
use App\Traits\Response;
use Error;
use ErrorException;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use RuntimeException;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Throwable;

class Handler extends ExceptionHandler
{
    use Response;

    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * @param $request
     * @param Throwable $e
     * @return JsonResponse|\Illuminate\Http\Response
     * @throws Throwable
     */
    public function render($request, Throwable $e): JsonResponse|\Illuminate\Http\Response
    {
        if ($e instanceof AuthenticationException || $e instanceof AuthorizationException) {
            return $this->responseError(
                exception: $e,
                applicationCode: ErrorsListHelpers::ERROR_GENERIC_WHEN_AUTHENTICATION,
                statusCode: 401
            );
        }

        if ($e instanceof ModelNotFoundException || $e instanceof NotFoundHttpException || $e instanceof RouteNotFoundException) {
            return $this->responseError(
                exception: $e,
                applicationCode: ErrorsListHelpers::ERROR_GENERIC_WHEN_RESOURCE_NOT_FOUND,
                statusCode: 404
            );
        }

        if ($e instanceof MethodNotAllowedHttpException) {
            return $this->responseError(
                exception: $e,
                applicationCode: ErrorsListHelpers::ERROR_GENERIC_WHEN_METHOD_ALLOWED,
                statusCode: 405
            );
        }

        if ($e instanceof CustomValidateException) {
            return $this->responseError(
                message: 'The given data was invalid',
                exception: $e,
                applicationCode: ErrorsListHelpers::ERROR_GENERIC_WHEN_VALIDATION,
                resource: $e->getOnlyMessages(),
                statusCode: 422
            );
        }

        if ($e instanceof QueryException) {
            return $this->responseError(
                exception: $e,
                applicationCode: ErrorsListHelpers::ERROR_GENERIC_WHEN_QUERY_EXCEPTION,
                statusCode: 500
            );
        }

        if ($e instanceof RuntimeException) {
            return $this->responseError(
                exception: $e,
                applicationCode: ErrorsListHelpers::ERROR_GENERIC_WHEN_RUNTIME_EXCEPTION,
                statusCode: 500
            );
        }

        if ($e instanceof CustomException) {
            return $this->responseError(
                message: $e->getPublicMessage(),
                exception: $e,
                applicationCode: $e->getCode(),
                statusCode: $e->getStatusCode()
            );
        }

        if ($e instanceof Error ||
            $e instanceof Exception ||
            $e instanceof Throwable ||
            $e instanceof ErrorException
        ) {
            return $this->responseError(
                exception: $e,
                statusCode: 500
            );
        }

        return parent::render($request, $e);
    }
}
