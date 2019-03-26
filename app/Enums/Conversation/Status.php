<?php
namespace App\Enums\Conversation;

use App\Enums\BaseEnum;
use ReflectionClass;

abstract class Status extends BaseEnum
{
    const CLOSED = 0;
    const ACTIVE = 1;
    const UNREAD = 2;

    public static function valueToEnum($value)
    {
        switch ($value) {
            case 0:
                return self::CLOSED;
            case 1:
                return self::ACTIVE;
            case 2:
                return self::UNREAD;
            default:
                return null;
        }
    }

    public static function enumToValue($enum)
    {
        switch ($enum) {
            case self::CLOSED:
                return 0;
            case self::ACTIVE:
                return 1;
            case self::UNREAD:
                return 2;
            default:
                return null;
        }
    }

    public static function getValues()
    {
        return [self::CLOSED,
            self::ACTIVE];
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
