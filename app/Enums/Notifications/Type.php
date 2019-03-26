<?php

namespace App\Enums\Notifications;

use App\Enums\BaseEnum;

abstract class Type extends BaseEnum
{
    const SYSTEM = 0;
    const BUY = 1;
    const SELL = 2;
    const CHAT = 3;

    public static function valueToEnum($value)
    {
        switch ($value) {
            case 0:
                return self::SYSTEM;
            case 1:
                return self::BUY;
            case 2:
                return self::SELL;
            case 3:
                return self::CHAT;
            default:
                return null;
        }
    }

    public static function enumToValue($enum)
    {
        switch ($enum) {
            case self::SYSTEM:
                return 0;
            case self::BUY:
                return 1;
            case self::SELL:
                return 2;
            case self::CHAT:
                return 3;
            default:
                return null;
        }
    }
}
