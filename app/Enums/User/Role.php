<?php

namespace App\Enums\User;

use App\Enums\BaseEnum;

abstract class Role extends BaseEnum
{
    const USER = 0;
    const ADMIN = 1;
    const EMPLOYER = 2;

    public static function valueToEnum($value)
    {
        switch ($value) {
            case 0:
                return self::USER;
            case 1:
                return self::ADMIN;
            case 2:
                return self::EMPLOYER;
            default:
                return null;
        }
    }

    public static function enumToValue($enum)
    {
        switch ($enum) {
            case self::USER:
                return 0;
            case self::ADMIN:
                return 1;
            case self::EMPLOYER:
                return 2;
            default:
                return null;
        }
    }
}
