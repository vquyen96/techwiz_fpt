<?php

namespace App\Enums\Products;

use App\Enums\BaseEnum;

abstract class DeliveryMethod extends BaseEnum
{
    const ONE_DAY = 0;
    const TWO_DAYS = 1;
    const THREE_DAYS = 2;

    public static function valueToEnum($value)
    {
        switch ($value) {
            case 0:
                return self::ONE_DAY;
            case 1:
                return self::TWO_DAYS;
            case 2:
                return self::THREE_DAYS;
            default:
                return null;
        }
    }

    public static function enumToValue($enum)
    {
        switch ($enum) {
            case self::ONE_DAY:
                return 0;
            case self::TWO_DAYS:
                return 1;
            case self::THREE_DAYS:
                return 2;
            default:
                return null;
        }
    }
}
