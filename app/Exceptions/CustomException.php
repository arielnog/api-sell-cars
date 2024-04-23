<?php

namespace App\Exceptions;

use App\Helpers\ErrorsListHelpers;
use Exception;
use Throwable;

class CustomException extends Exception
{

    public function __construct(
        private readonly int    $statusCode = 500,
        private readonly string $publicMessage = 'System Error',
        string                  $privateMessage = 'System Error',
        int                     $code = 0,
        ?Throwable              $previous = null,
    )
    {
        parent::__construct(
            message: $privateMessage,
            code: $code,
            previous: $previous
        );
    }

    /**
     * @return string
     */
    public function getPublicMessage(): string
    {
        return $this->publicMessage;
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}
