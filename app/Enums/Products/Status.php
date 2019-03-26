<?php

namespace App\Enums\Products;

use App\Enums\BaseEnum;
use ReflectionClass;

abstract class Status extends BaseEnum
{
    const DRAFT = 0;
    const PUBLISH = 1;
    const WAITING_SYSTEM_RECEIVE_MONEY = 2;
    const SELLING_SUCCESS = 3;
    const BUYER_RECEIVED = 4;
    const STOP_SELLING = 5;
    const CANCEL = 6;

    public static function valueToEnum($value)
    {
        switch ($value) {
            case 0:
                return self::DRAFT;
            case 1:
                return self::PUBLISH;
            case 2:
                return self::WAITING_SYSTEM_RECEIVE_MONEY;
            case 3:
                return self::SELLING_SUCCESS;
            case 4:
                return self::BUYER_RECEIVED;
            case 5:
                return self::STOP_SELLING;
            case 6:
                return self::CANCEL;
            default:
                return null;
        }
    }

    public static function enumToValue($enum)
    {
        switch ($enum) {
            case self::DRAFT:
                return 0;
            case self::PUBLISH:
                return 1;
            case self::WAITING_SYSTEM_RECEIVE_MONEY:
                return 2;
            case self::SELLING_SUCCESS:
                return 3;
            case self::BUYER_RECEIVED:
                return 4;
            case self::STOP_SELLING:
                return 5;
            case self::CANCEL:
                return 6;
            default:
                return null;
        }
    }

    public static function getValues()
    {
        return [self::DRAFT,
            self::PUBLISH,
            self::WAITING_SYSTEM_RECEIVE_MONEY,
            self::SELLING_SUCCESS,
            self::BUYER_RECEIVED,
            self::STOP_SELLING,
            self::CANCEL];
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
