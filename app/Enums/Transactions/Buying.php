<?php

namespace App\Enums\Transactions;

use App\Enums\BaseEnum;

abstract class Buying extends BaseEnum
{
    const SELLING_SUCCESS = 0;
    const SELLER_CANCEL_TRANSFER = 1;
    const BUYER_CANCEL_TRANSFER = 2;
    const TRANSACTION_COMPLETED = 3;

    public static function valueToEnum($value)
    {
        switch ($value) {
            case 0:
                return self::SELLING_SUCCESS;
            case 1:
                return self::SELLER_CANCEL_TRANSFER;
            case 2:
                return self::BUYER_CANCEL_TRANSFER;
            case 3:
                return self::TRANSACTION_COMPLETED;
            default:
                return null;
        }
    }

    public static function enumToValue($enum)
    {
        switch ($enum) {
            case self::SELLING_SUCCESS:
                return 0;
            case self::SELLER_CANCEL_TRANSFER:
                return 1;
            case self::BUYER_CANCEL_TRANSFER:
                return 2;
            case self::TRANSACTION_COMPLETED:
                return 3;
            default:
                return null;
        }
    }
}
