<?php

namespace App\Exceptions;

use App\Exceptions\CustomException;

class CreatedDataException extends CustomException
{
    public function __construct(
        int    $statusCode = 500,
        string $message = 'Error Create Data',
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
