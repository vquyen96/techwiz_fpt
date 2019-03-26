<?php
namespace App\Mail\Factory\Request;

class ExpiredRequest
{
    const DEFAULT_SENDER_ADDRESS = 'no-reply@hblab.vn';
    const DEFAULT_SENDER_NAME = 'RMT';

    public static function buildMailInfo()
    {
        return [
            'address' => self::DEFAULT_SENDER_ADDRESS,
            'name' => self::DEFAULT_SENDER_NAME,
            'subject' => 'Your request expired',
            'view' => 'emails.request.expired'
        ];
    }

    public static function buildMailData($request)
    {
        return [
            'request' => $request
        ];
    }
}
