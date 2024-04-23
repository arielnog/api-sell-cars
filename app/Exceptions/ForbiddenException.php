<?php

namespace App\Exceptions;

use Exception;

class ForbiddenException extends CustomException
{
    public function __construct(
        int        $statusCode = 403,
        string     $message = 'Unauthorized Request',
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
