<?php

namespace App\ValueObjects;

use App\Enums\VehicleTransmissionEnum;
use App\Exceptions\InvalidArgumentException;
use App\Helpers\ErrorsListHelpers;

final class VehicleTransmission
{
    public function __construct(
        private readonly string $status
    )
    {
        $this->validate();
    }

    private function validate(): void
    {
       if (!in_array($this->status, VehicleTransmissionEnum::validValues())){
           throw new InvalidArgumentException(
               statusCode: 422,
               message: 'Status do Veiculo é inválido',
               code: ErrorsListHelpers::ERROR_GENERIC_INVALID_ARGUMENT
           );
       }
    }

    public static function fromString(string $status): VehicleTransmission
    {
        return new self($status);
    }

    public function toString(): string
    {
        return $this->status;
    }
}
