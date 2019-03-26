<?php

namespace App\Enums\Alerts\Product;

use App\Enums\BaseEnum;

abstract class Transfer extends BaseEnum
{
    const TO_BUYER_WITH_BUYER_RECEIVED_TRANSFER = 0;
    const TO_SELLER_WITH_BUYER_RECEIVED_TRANSFER = 1;

    const TO_BUYER_WITH_BUYER_CANCEL_TRANSFER = 2;
    const TO_SELLER_WITH_BUYER_CANCEL_TRANSFER = 3;

    const TO_BUYER_WITH_SELLER_CANCEL_TRANSFER = 4;
    const TO_SELLER_WITH_SELLER_CANCEL_TRANSFER = 5;

    public static function valueToEnum($value)
    {
        switch ($value) {
            case 0:
                return self::TO_BUYER_WITH_BUYER_RECEIVED_TRANSFER;
            case 1:
                return self::TO_SELLER_WITH_BUYER_RECEIVED_TRANSFER;
            case 2:
                return self::TO_BUYER_WITH_BUYER_CANCEL_TRANSFER;
            case 3:
                return self::TO_SELLER_WITH_BUYER_CANCEL_TRANSFER;
            case 4:
                return self::TO_BUYER_WITH_SELLER_CANCEL_TRANSFER;
            case 5:
                return self::TO_SELLER_WITH_SELLER_CANCEL_TRANSFER;
            default:
                return null;
        }
    }

    public static function enumToValue($enum)
    {
        switch ($enum) {
            case self::TO_BUYER_WITH_BUYER_RECEIVED_TRANSFER:
                return 0;
            case self::TO_SELLER_WITH_BUYER_RECEIVED_TRANSFER:
                return 1;
            case self::TO_BUYER_WITH_BUYER_CANCEL_TRANSFER:
                return 2;
            case self::TO_SELLER_WITH_BUYER_CANCEL_TRANSFER:
                return 3;
            case self::TO_BUYER_WITH_SELLER_CANCEL_TRANSFER:
                return 4;
            case self::TO_SELLER_WITH_SELLER_CANCEL_TRANSFER:
                return 5;
            default:
                return null;
        }
    }
}
