<?php
namespace App\Helpers\Notifications\Ticket;

use App\Enums\Notifications\Type as NotiType;
use App\Enums\Notifications\Status as NotiStatus;
use App\Enums\NotificationAdmin\Type as NotiAdminType;

class CommentHelper
{
    public function buildDataNotificationUser($authUser, $ticketDetail)
    {
        return [
            'title' => 'New message',
            'content' => 'Admin has reply your ticket',
            'type' => NotiType::SYSTEM,
            'image_url' => $authUser->avatar_url,
            'path' => 'ticket?id='.$ticketDetail->id,
            'status' => NotiStatus::CREATE,
            'user_id' => $ticketDetail->user_id,
        ];
    }

    public function buildDataNotificationAdmin($authUser, $ticketDetail)
    {
        return [
            'target_id' => $authUser->id,
            'title' => 'New message',
            'type' => NotiAdminType::TICKET_COMMENT,
            'image_url' => $authUser->avatar_url,
            'path' => 'ticket_comment/'.$ticketDetail->id,
            'status' => NotiStatus::CREATE,
        ];
    }

    public function buildDataMailUser($ticketDetail)
    {
        return [
            'user' => $ticketDetail->user,
            'ticket' => $ticketDetail
        ];
    }
}
