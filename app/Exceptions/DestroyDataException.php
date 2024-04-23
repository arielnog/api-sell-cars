<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class DestroyDataException extends CustomException
{
    public function __construct(
        int    $statusCode = 400,
        string $message = 'Error Delete Data',
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
