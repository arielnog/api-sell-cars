<?php

namespace App\Traits;

use App\Helpers\ErrorsListHelpers;
use App\Helpers\Paginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Collection;
use Exception;
use Illuminate\Support\Facades\Log;
use Throwable;

trait Response
{
    protected function apiResponse(
        array $data = [],
        int   $statusCode = 200
    ): JsonResponse
    {
        return response()->json(
            $data, $statusCode
        );
    }

    private function responseWithArray(
        array  $resource,
        string $message = null,
        int    $statusCode = 200
    ): JsonResponse
    {
        return $this->apiResponse(
            [
                'message' => $message,
                'data' => $resource,
            ],
            $statusCode
        );
    }

    private function responseWithResource(
        Collection|ResourceCollection|JsonResource $resourceCollection,
        string                                     $message = null,
        int                                        $statusCode = 200
    ): JsonResponse
    {
        return $this->apiResponse(
            [
                'message' => $message,
                'data' => $resourceCollection
            ],
            $statusCode
        );
    }

    private function responseWithPaginate(
        Paginator $resource,
        string    $message = null,
        int       $statusCode = 200
    ): JsonResponse
    {
        $response = $resource->toArray();

        $response['message'] = $message;

        return $this->apiResponse(
            $response,
            $statusCode
        );
    }

    /**
     * @param int $statusCode
     * @param string|null $message
     * @param mixed $resource
     * @return JsonResponse
     */
    protected function responseSuccess(
        int    $statusCode = 200,
        string $message = null,
        mixed  $resource = null,
    ): JsonResponse
    {
        if (is_array($resource)) {
            return $this->responseWithArray(
                $resource,
                $message,
                $statusCode
            );
        } else if ($resource instanceof Collection || $resource instanceof ResourceCollection || $resource instanceof JsonResource) {
            return $this->responseWithResource(
                $resource,
                $message,
                $statusCode
            );
        } else if (is_array($resource) && array_key_exists('data', $resource)) {
            $data = $resource;

            return $this->apiResponse(
                [
                    'message' => $message,
                    'data' => $data
                ],
                $statusCode
            );
        } else if ($resource instanceof Paginator) {
            return $this->responseWithPaginate(
                $resource,
                $message,
                $statusCode
            );
        } else {
            return $this->apiResponse(
                [
                    'message' => $message
                ],
                $statusCode
            );
        }
    }


    /**
     * Respond with error.
     *
     * @param string $message
     * @param Exception|null $exception
     * @param int $applicationCode
     * @param mixed|null $resource
     * @param int $statusCode
     *
     * @return JsonResponse
     */
    protected
    function responseError(
        string    $message = "Generic Error",
        Throwable $exception = null,
        int       $applicationCode = ErrorsListHelpers::ERROR_GENERIC,
        mixed     $resource = [],
        int       $statusCode = 400,
    ): JsonResponse
    {
        $response = [
            'message' => $message,
            'data' => $resource,
            'application_code' => $applicationCode
        ];

        if ($applicationCode == ErrorsListHelpers::ERROR_GENERIC_WHEN_VALIDATION) {
            Log::warning('The given data was invalid',
                [
                    'exception' => $exception
                ]
            );
        }

        if (!empty($exception) && env('APP_ENV') == 'local') {
            $response['exception'] = [
                'private_message' => $exception->getMessage() ?? "",
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
                'trace' => $exception->getTrace()
            ];
        }

        return $this->apiResponse(
            $response,
            $statusCode
        );
    }
}
