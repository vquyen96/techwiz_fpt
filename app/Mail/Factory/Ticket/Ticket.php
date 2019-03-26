<?php

namespace App\Mail\Factory\Ticket;

abstract class Ticket
{
    const DEFAULT_SENDER_ADDRESS = 'no-reply@hblab.vn';
    const DEFAULT_SENDER_NAME = 'RMT';

    public static function buildMailInfo()
    {
        return [
            'address' => self::DEFAULT_SENDER_ADDRESS,
            'name' => self::DEFAULT_SENDER_NAME,
            'subject' => '[RMT] Inquiries accepted',
            'view' => 'emails.ticket.confirm_received',
        ];
    }

    public static function buildMailData()
    {
        return [
            'url' => env('APP_URL'),
        ];
    }
}
