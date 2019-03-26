<?php

namespace App\Enums\Products;

use App\Enums\BaseEnum;

abstract class UserType extends BaseEnum
{
    const USER = 0;
    const SELLER = 1;
    const BUYER = 2;

    public static function valueToEnum($value)
    {
        switch ($value) {
            case 0:
                return self::USER;
            case 1:
                return self::SELLER;
            case 2:
                return self::BUYER;
            default:
                return null;
        }
    }

    public static function enumToValue($enum)
    {
        switch ($enum) {
            case self::USER:
                return 0;
            case self::SELLER:
                return 1;
            case self::BUYER:
                return 2;
            default:
                return null;
        }
    }
}
