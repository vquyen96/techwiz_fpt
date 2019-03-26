<?php

namespace App\Enums\Request;

use App\Enums\BaseEnum;

abstract class Status extends BaseEnum
{
    const OPEN = 0;
    const CLOSED = 1;

    public static function valueToEnum($value)
    {
        switch ($value) {
            case 0:
                return self::OPEN;
            case 1:
                return self::CLOSED;
            default:
                return null;
        }
    }

    public static function enumToValue($enum)
    {
        switch ($enum) {
            case self::OPEN:
                return 0;
            case self::CLOSED:
                return 1;
            default:
                return null;
        }
    }

    public static function getValues()
    {
        return [self::OPEN,
            self::CLOSED];
    }
}
