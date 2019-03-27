<?php
namespace App\Enums\CV;

use App\Enums\BaseEnum;

abstract class Type extends BaseEnum
{
    const NORMAL = 0;
    const LOOKING = 1;
    const HOT = 2;

    public static function valueToEnum($value)
    {
        switch ($value) {
            case 0:
                return self::NORMAL;
            case 1:
                return self::LOOKING;
            case 2:
                return self::HOT;
            default:
                return null;
        }
    }

    public static function enumToValue($enum)
    {
        switch ($enum) {
            case self::NORMAL:
                return 0;
            case self::LOOKING:
                return 1;
            case self::HOT:
                return 2;
            default:
                return null;
        }
    }
}
