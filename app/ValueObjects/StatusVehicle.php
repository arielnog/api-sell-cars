<?php

namespace App\ValueObjects;

use App\Enums\StatusAnnouncementEnum;
use App\Enums\StatusVehicleEnum;
use App\Exceptions\InvalidArgumentException;
use App\Helpers\ErrorsListHelpers;

final class StatusVehicle
{
    public function __construct(
        private readonly string $status
    )
    {
        $this->validate();
    }

    private function validate(): void
    {
       if (!in_array($this->status, StatusVehicleEnum::validValues())){
           throw new InvalidArgumentException(
               statusCode: 422,
               message: 'Status do Veiculo é inválido',
               code: ErrorsListHelpers::ERROR_GENERIC_INVALID_ARGUMENT
           );
       }
    }

    public static function fromString(string $status): StatusVehicle
    {
        return new self($status);
    }

    public function toString(): string
    {
        return $this->status;
    }
}
