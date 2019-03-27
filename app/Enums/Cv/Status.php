<?php
namespace App\Enums\Cv;

use App\Enums\BaseEnum;

abstract class Status extends BaseEnum
{
    const DEACTIVE = 0;
    const ACTIVE = 1;
    const CONFIRM = 2;

    public static function valueToEnum($value)
    {
        switch ($value) {
            case 0:
                return self::DEACTIVE;
            case 1:
                return self::ACTIVE;
            case 2:
                return self::CONFIRM;
            default:
                return null;
        }
    }

    public static function enumToValue($enum)
    {
        switch ($enum) {
            case self::DEACTIVE:
                return 0;
            case self::ACTIVE:
                return 1;
            case self::CONFIRM:
                return 2;
            default:
                return null;
        }
    }
}
