<?php
namespace App\Enums\Job;

use App\Enums\BaseEnum;

abstract class Rank extends BaseEnum
{
    const EMPLOYEES = 0;
    const LEADER = 1;
    const MANAGER = 2;

    public static function valueToEnum($value)
    {
        switch ($value) {
            case 0:
                return self::EMPLOYEES;
            case 1:
                return self::LEADER;
            case 2:
                return self::MANAGER;
            default:
                return null;
        }
    }

    public static function enumToValue($enum)
    {
        switch ($enum) {
            case self::EMPLOYEES:
                return 0;
            case self::LEADER:
                return 1;
            case self::MANAGER:
                return 2;
            default:
                return null;
        }
    }
}
