<?php

namespace App\Enums\Products;

use App\Enums\BaseEnum;

abstract class ExpirationTime extends BaseEnum
{
    const ONE_DAY = 1;
    const TWO_DAYS = 2;
    const THREE_DAYS = 3;
    const FOUR_DAYS = 4;
    const FIVE_DAYS = 5;
    const SIX_DAYS = 6;
    const SEVEN_DAYS = 7;

    public static function valueToEnum($value)
    {
        switch ($value) {
            case 1:
                return self::ONE_DAY;
            case 2:
                return self::TWO_DAYS;
            case 3:
                return self::THREE_DAYS;
            case 4:
                return self::FOUR_DAYS;
            case 5:
                return self::FIVE_DAYS;
            case 6:
                return self::SIX_DAYS;
            case 7:
                return self::SEVEN_DAYS;
            default:
                return null;
        }
    }

    public static function enumToValue($enum)
    {
        switch ($enum) {
            case self::ONE_DAY:
                return 1;
            case self::TWO_DAYS:
                return 2;
            case self::THREE_DAYS:
                return 3;
            case self::FOUR_DAYS:
                return 4;
            case self::FIVE_DAYS:
                return 5;
            case self::SIX_DAYS:
                return 6;
            case self::SEVEN_DAYS:
                return 7;
            default:
                return null;
        }
    }
}
