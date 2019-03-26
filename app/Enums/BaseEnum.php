<?php

namespace App\Enums;

abstract class BaseEnum
{
    abstract public static function valueToEnum($value);
    abstract public static function enumToValue($enum);
    abstract public static function getValues();
    abstract public static function getKey($value);
}
