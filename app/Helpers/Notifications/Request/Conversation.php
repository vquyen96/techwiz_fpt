<?php
namespace App\Helpers\Notifications\Request;

use App\Enums\Notifications\Status as NotificationStatus;
use App\Enums\Notifications\Type as NotificationType;

class Conversation
{
    public function buildNotificationCreate($conversation)
    {
        return [
            'status' => NotificationStatus::CREATE,
            'path' => '/conversation/detail?id=' . $conversation->id,
            'image_url' =>  $conversation->fromUser->avatar_url,
            'type' => NotificationType::CHAT,
            'title' => 'New Conversation',
            'content' => $conversation->fromUser->name.' send new messages to you',
            'user_id' => $conversation->toUser->id,
        ];
    }

    public function buildNotificationClose($conversation)
    {
        return [
            'status' => NotificationStatus::CREATE,
            'path' => '/conversation/detail?id=' . $conversation->id,
            'image_url' =>  $conversation->fromUser->avatar_url,
            'type' => NotificationType::CHAT,
            'title' => 'Conversation Closed',
            'content' => $conversation->fromUser->name.' close conversation',
            'user_id' => $conversation->toUser->id,
        ];
    }
}
