<?php

namespace App\Enums;

enum VehicleTransmissionEnum: string
{
    case AUTO = "automatic";
    case MANUAL = "manual";

    public static function validValues(): array
    {
        return [
            self::AUTO->value,
            self::MANUAL->value,
        ];
    }
}
