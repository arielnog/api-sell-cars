<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class RestoreDataException extends CustomException
{
    public function __construct(
        int    $statusCode = 500,
        string $message = 'Error Restore Data',
        int $code = 0
    )
    {
        parent::__construct(
            statusCode: $statusCode,
            publicMessage: $message,
            code: $code
        );
    }
}
