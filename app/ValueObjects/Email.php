<?php

namespace App\ValueObjects;

use App\Exceptions\InvalidArgumentException;
use App\Helpers\ErrorsListHelpers;
use Exception;
use Illuminate\Support\Stringable;

final class Email
{
    /**
     * @throws Exception
     */
    public function __construct(
        private string $email
    )
    {
        $this->validate();
    }

    private function validate():void
    {
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException(
                statusCode: 422,
                message: 'Email Inválido',
                code: ErrorsListHelpers::ERROR_GENERIC_INVALID_ARGUMENT
            );
        }
    }

    public static function fromString(string $email): Email
    {
        return new self($email);
    }

    public function toString(): string
    {
        return $this->email;
    }
}
