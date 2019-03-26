<?php
namespace App\Enums\NotificationAdmin;

use App\Enums\BaseEnum;

abstract class Type extends BaseEnum
{
    const TICKET = 0;
    const TICKET_COMMENT = 1;

    public static function valueToEnum($value)
    {
        switch ($value) {
            case 0:
                return self::TICKET;
            case 1:
                return self::TICKET_COMMENT;
            default:
                return null;
        }
    }

    public static function enumToValue($enum)
    {
        switch ($enum) {
            case self::TICKET:
                return 0;
            case self::TICKET_COMMENT:
                return 1;
            default:
                return null;
        }
    }
}
