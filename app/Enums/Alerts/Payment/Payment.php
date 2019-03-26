<?php

namespace App\Enums\Alerts\Payment;

use App\Enums\BaseEnum;

abstract class Payment extends BaseEnum
{
    const TO_BUYER_WITH_BUYER_TRANSFER_MONEY = 0;
    const TO_SELLER_WITH_BUYER_TRANSFER_MONEY = 1;

    const TO_SELLER_WITH_RMT_TRANSFER_MONEY = 2;

    const TO_BUYER_WITH_RMT_REFUND_MONEY = 3;
    const TO_SELLER_WITH_RMT_REFUND_MONEY = 4;
    

    public static function valueToEnum($value)
    {
        switch ($value) {
            case 0:
                return self::TO_BUYER_WITH_BUYER_TRANSFER_MONEY;
            case 1:
                return self::TO_SELLER_WITH_BUYER_TRANSFER_MONEY;
            case 2:
                return self::TO_SELLER_WITH_RMT_TRANSFER_MONEY;
            case 3:
                return self::TO_BUYER_WITH_RMT_REFUND_MONEY;
            case 4:
                return self::TO_SELLER_WITH_RMT_REFUND_MONEY;
            default:
                return null;
        }
    }

    public static function enumToValue($enum)
    {
        switch ($enum) {
            case self::TO_BUYER_WITH_BUYER_TRANSFER_MONEY:
                return 0;
            case self::TO_SELLER_WITH_BUYER_TRANSFER_MONEY:
                return 1;
            case self::TO_SELLER_WITH_RMT_TRANSFER_MONEY:
                return 2;
            case self::TO_BUYER_WITH_RMT_REFUND_MONEY:
                return 3;
            case self::TO_SELLER_WITH_RMT_REFUND_MONEY:
                return 4;
            default:
                return null;
        }
    }
}
