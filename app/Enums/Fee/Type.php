<?php

namespace App\Enums\Fee;

use App\Enums\BaseEnum;
use ReflectionClass;

class Type extends BaseEnum
{
    const SYSTEM = 0;
    const TRANSACTION = 1;

    public static function valueToEnum($value)
    {
        switch ($value) {
            case 0:
                return self::SYSTEM;
            case 1:
                return self::TRANSACTION;
            default:
                return null;
        }
    }

    public static function enumToValue($enum)
    {
        switch ($enum) {
            case self::SYSTEM:
                return 0;
            case self::TRANSACTION:
                return 1;
            default:
                return null;
        }
    }

    public static function getValues()
    {
        return [self::SYSTEM,
            self::TRANSACTION];
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
