<?php

namespace App\Enums\Review;

use App\Enums\BaseEnum;
use ReflectionClass;

abstract class EmotionalType extends BaseEnum
{
    const BAD = 0;
    const NORMAL = 1;
    const GOOD = 2;

    public static function valueToEnum($value)
    {
        switch ($value) {
            case 0:
                return self::BAD;
            case 1:
                return self::NORMAL;
            case 2:
                return self::GOOD;
            default:
                return null;
        }
    }

    public static function enumToValue($enum)
    {
        switch ($enum) {
            case self::BAD:
                return 0;
            case self::NORMAL:
                return 1;
            case self::GOOD:
                return 2;
            default:
                return null;
        }
    }

    public static function fromReviewPoint($point)
    {
        switch ($point) {
            case ($point >= 4 && $point <=5):
                return self::GOOD;
            case ($point >=2 && $point < 4):
                return self:: NORMAL;
            case ($point < 2):
                return self::BAD;
            default:
                return null;
        }
    }
}
