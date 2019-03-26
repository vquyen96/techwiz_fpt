<?php
namespace App\Mail\Factory\Request;

use App\Enums\Alerts\Request\Conversation as AlertConversation;

class Conversation
{
    const DEFAULT_SENDER_ADDRESS = 'no-reply@hblab.vn';
    const DEFAULT_SENDER_NAME = 'RMT';

    public static function buildMailInfo($mailingType)
    {
        $commonInfo = [
            'address' => self::DEFAULT_SENDER_ADDRESS,
            'name' => self::DEFAULT_SENDER_NAME,
        ];

        switch ($mailingType) {
            case AlertConversation::CREATE:
                return array_merge($commonInfo, [
                    'subject' => 'New Conversation',
                    'view' => 'emails.request.conversation.create'
                ]);
            case AlertConversation::CLOSE:
                return array_merge($commonInfo, [
                    'subject' => 'Conversation Closed',
                    'view' => 'emails.request.conversation.close'
                ]);
            default:
                return $commonInfo;
        }
    }

    public static function buildMailData($conversation)
    {
        return [
            'conversation' => $conversation
        ];
    }
}
