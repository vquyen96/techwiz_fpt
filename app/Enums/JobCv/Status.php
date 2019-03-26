<?php
namespace App\Enums\JobCv;

use App\Enums\BaseEnum;

abstract class Status extends BaseEnum
{
    const DEACTIVE = 0;
    const ACTIVE = 1;

    public static function valueToEnum($value)
    {
        switch ($value) {
            case 0:
                return self::DEACTIVE;
            case 1:
                return self::ACTIVE;
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
            default:
                return null;
        }
    }
}
