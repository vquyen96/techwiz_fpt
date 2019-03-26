<?php
namespace App\Enums\Job;

use App\Enums\BaseEnum;

abstract class Type extends BaseEnum
{
    const NORMAL = 0;
    const HOT = 1;

    public static function valueToEnum($value)
    {
        switch ($value) {
            case 0:
                return self::NORMAL;
            case 1:
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
            case self::HOT:
                return 1;
            default:
                return null;
        }
    }
}
