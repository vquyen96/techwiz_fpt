<?php

namespace App\Enums\Notifications;

use App\Enums\BaseEnum;

abstract class Status extends BaseEnum
{
    const CREATE = 0;
    const READ = 1;

    public static function valueToEnum($value)
    {
        switch ($value) {
            case 0:
                return self::CREATE;
            case 1:
                return self::READ;
            default:
                return null;
        }
    }

    public static function enumToValue($enum)
    {
        switch ($enum) {
            case self::CREATE:
                return 0;
            case self::READ:
                return 1;
            default:
                return null;
        }
    }
}
