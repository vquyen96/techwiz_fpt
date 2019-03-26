<?php
namespace App\Enums\Alerts\Request;

use App\Enums\BaseEnum;
use ReflectionClass;

class Conversation extends BaseEnum
{
    const CREATE = 0;
    const CLOSE = 1;

    public static function valueToEnum($value)
    {
        switch ($value) {
            case 0:
                return self::CREATE;
            case 1:
                return self::CLOSE;
            default:
                return null;
        }
    }

    public static function enumToValue($enum)
    {
        switch ($enum) {
            case self::CREATE:
                return 0;
            case self::CLOSE:
                return 1;
            default:
                return null;
        }
    }

    public static function getValues()
    {
        return [self::CREATE,
            self::CLOSE];
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
