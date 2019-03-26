<?php

namespace App\Mail\Factory\Auth;

abstract class VerifyUser
{
    const DEFAULT_SENDER_ADDRESS = 'no-reply@hblab.vn';
    const DEFAULT_SENDER_NAME = 'RMT';
    const DEFAULT_SUBJECT = 'Complete register';
    const DEFAULT_VIEW = 'emails.auth.register.verify-user';

    public static function buildMailInfo()
    {
        return [
            'address' => self::DEFAULT_SENDER_ADDRESS,
            'name' => self::DEFAULT_SENDER_NAME,
            'subject' => self::DEFAULT_SUBJECT,
            'view' => self::DEFAULT_VIEW
        ];
    }

    public static function buildMailData($user)
    {
        return $user;
    }
}
