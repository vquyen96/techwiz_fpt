<?php
namespace App\Enums\Job;

use App\Enums\BaseEnum;

abstract class Degree extends BaseEnum
{
    const GRADUATED = 0;
    const CERTIFICATE = 1;
    const COLLEGES = 2;
    const UNIVERSITY = 3;

    public static function valueToEnum($value)
    {
        switch ($value) {
            case 0:
                return self::GRADUATED;
            case 1:
                return self::CERTIFICATE;
            case 2:
                return self::COLLEGES;
            case 3:
                return self::UNIVERSITY;
            default:
                return null;
        }
    }

    public static function enumToValue($enum)
    {
        switch ($enum) {
            case self::GRADUATED:
                return 0;
            case self::CERTIFICATE:
                return 1;
            case self::COLLEGES:
                return 2;
            case self::UNIVERSITY:
                return 3;
            default:
                return null;
        }
    }
}
