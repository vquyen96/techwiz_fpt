<?php
namespace App\Helpers\Notifications\Request;

use App\Enums\Notifications\Status as NotificationStatus;
use App\Enums\Notifications\Type as NotificationType;

class PrivateMessage
{
    public function buildNotificationReply($message, $notificationType)
    {
        $user = $message->user;
        $conversation = $message->conversation;

        $commonData = [
            'status' => NotificationStatus::CREATE,
            'path' => '/conversation/detail?id='.$conversation->id,
            'image_url' =>  $user->avatar_url,
            'type' => NotificationType::CHAT,
        ];

        switch ($notificationType) {
            case NotificationType::BUY:
                return array_merge($commonData, [
                    'title' => 'New Private message',
                    'content' => $user->name.' send new messages to you',
                    'user_id' => $conversation->to_user_id,
                ]);
            case NotificationType::SELL:
                return array_merge($commonData, [
                    'title' => 'New Private message',
                    'content' => $user->name.'Buyer send new messages to you',
                    'user_id' => $conversation->from_user_id,
                ]);
            default:
                return $commonData;
        }
    }
}
