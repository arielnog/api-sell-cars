<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Validation\ValidationException;
use Throwable;

class CustomValidateException extends ValidationException
{

    public function __construct(
        public               $validator,
        public               $errorBag = 'default',
        private readonly int $statusCode = 422,
    )
    {
        parent::__construct($validator, $errorBag);
    }


    public function getOnlyMessages(): array
    {
        $messageBag = [];

        foreach ($this->errors() as $messagesArray) {
            foreach ($messagesArray as $message) {
                $messageBag[] = $message;
            }
        }

        return $messageBag;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}
