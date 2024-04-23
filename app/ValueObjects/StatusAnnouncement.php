<?php

namespace App\ValueObjects;

use App\Enums\StatusAnnouncementEnum;
use App\Exceptions\InvalidArgumentException;
use App\Helpers\ErrorsListHelpers;

final class StatusAnnouncement
{
    public function __construct(
        private readonly string $status
    )
    {
        $this->validate();
    }

    private function validate(): void
    {
       if (!in_array($this->status, StatusAnnouncementEnum::validValues())){
           throw new InvalidArgumentException(
               statusCode: 422,
               message: 'Status do anúncio é inválido',
               code: ErrorsListHelpers::ERROR_GENERIC_INVALID_ARGUMENT
           );
       }
    }

    public static function fromString(string $status): StatusAnnouncement
    {
        return new self($status);
    }

    public function toString(): string
    {
        return $this->status;
    }
}
