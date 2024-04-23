<?php

namespace App\Exceptions;

use Exception;
class DataExistException extends CustomException
{
    public function __construct(
        int    $statusCode = 422,
        string $message = 'Duplicate Data',
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
