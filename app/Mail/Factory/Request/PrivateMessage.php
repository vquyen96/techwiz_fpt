<?php
namespace App\Mail\Factory\Request;

use App\Enums\Notifications\Type as NotificationType;

class PrivateMessage
{
    const DEFAULT_SENDER_ADDRESS = 'no-reply@hblab.vn';
    const DEFAULT_SENDER_NAME = 'RMT';

    public static function buildMailInfo()
    {
        return [
            'address' => self::DEFAULT_SENDER_ADDRESS,
            'name' => self::DEFAULT_SENDER_NAME,
            'subject' => 'New Private message',
            'view' => 'emails.request.message.reply'
        ];
    }

    public static function buildMailData($message)
    {
        return [
            'private_message' => $message
        ];
    }
}
