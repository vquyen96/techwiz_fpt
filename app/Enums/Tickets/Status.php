<?php

namespace App\Enums\Tickets;

use App\Enums\BaseEnum;
use ReflectionClass;

abstract class Status extends BaseEnum
{
    const CREATED = 0;
    const IN_PROGRESS = 1;
    const SOLVED = 2;
    const CLOSED = 3;

    public static function valueToEnum($value)
    {
        switch ($value) {
            case 0:
                return self::CREATED;
            case 1:
                return self::IN_PROGRESS;
            case 2:
                return self::SOLVED;
            case 3:
                return self::CLOSED;
            default:
                return null;
        }
    }

    public static function enumToValue($enum)
    {
        switch ($enum) {
            case self::CREATED:
                return 0;
            case self::IN_PROGRESS:
                return 1;
            case self::SOLVED:
                return 2;
            case self::CLOSED:
                return 3;
            default:
                return null;
        }
    }

    public static function getValues()
    {
        return [self::CREATED,
            self::IN_PROGRESS,
            self::SOLVED,
            self::CLOSED];
    }

    public static function getKey($value)
    {
        foreach (static::constants() as $index => $val) {
            if ($val == $value) {
                return $index;
            }
        }
    }

    protected static function constants()
    {
        $oClass = new ReflectionClass(__CLASS__);
        return $oClass->getConstants();
    }
}
