<?php

namespace App\Exceptions;

use Exception;

class ResourceNotFoundException extends CustomException
{
    public function __construct(
        string $message = 'Error Not Found Data',
        int    $statusCode = 404,
        int    $code = 0
    )
    {
        parent::__construct(
            statusCode: $statusCode,
            publicMessage: $message,
            code: $code
        );
    }
}
