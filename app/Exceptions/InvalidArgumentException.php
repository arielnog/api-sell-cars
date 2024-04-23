<?php

namespace App\Exceptions;

use Exception;

class InvalidArgumentException extends CustomException
{
    public function __construct(
        int    $statusCode = 500,
        string $message = 'Invalid Argument Data',
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


