<?php

namespace App\Enums;

enum StatusAnnouncementEnum: string
{
    case ACTIVE = "active";
    case INACTIVE = "inactive";

    public static function validValues(): array
    {
        return [
            self::ACTIVE->value,
            self::INACTIVE->value,
        ];
    }
}
