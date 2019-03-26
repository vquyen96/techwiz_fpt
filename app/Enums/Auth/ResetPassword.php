<?php

namespace App\Enums\Auth;

use App\Enums\BaseEnum;

abstract class ResetPassword extends BaseEnum
{
    const UNUSE = 0;
    const USED = 1;

    public static function valueToEnum($value)
    {
        switch ($value) {
            case 0:
                return self::UNUSE;
            case 1:
                return self::USED;
            default:
                return null;
        }
    }

    public static function enumToValue($enum)
    {
        switch ($enum) {
            case self::UNUSE:
                return 0;
            case self::USED:
                return 1;
            default:
                return null;
        }
    }
}
