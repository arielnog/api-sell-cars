<?php

namespace App\Enums;

enum StatusVehicleEnum: string
{
    case NEW = "new";
    case OLD = "used";

    public static function validValues(): array
    {
        return [
            self::NEW->value,
            self::OLD->value,
        ];
    }
}
