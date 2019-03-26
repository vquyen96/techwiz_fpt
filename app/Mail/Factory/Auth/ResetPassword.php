<?php

namespace App\Mail\Factory\Auth;

abstract class ResetPassword
{
    const DEFAULT_SENDER_ADDRESS = 'no-reply@hblab.vn';
    const DEFAULT_SENDER_NAME = 'RMT';
    const DEFAULT_SUBJECT = 'Reset your password';
    const DEFAULT_VIEW = 'emails.auth.password.reset';

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
