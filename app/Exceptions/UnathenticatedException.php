<?php

namespace App\Exceptions;

use Exception;

class UnathenticatedException extends CustomException
{
    public function __construct(
        int        $statusCode = 422,
        string     $message = 'Error Credentials Data',
        int        $code = 0
    )
    {
        parent::__construct(
            statusCode: $statusCode,
            publicMessage: $message,
            privateMessage: $message,
            code: $code
        );
    }
}
