<?php
namespace App\Helpers\Notifications\Request;

use App\Enums\Notifications\Status as NotificationStatus;
use App\Enums\Notifications\Type as NotificationType;

class CloseRequest
{
    public function buildNotificationClose($request)
    {
        $imageUrl = count($request->images) > 0 ?
            $request->images[0]->thumbnail_url : null;

        return [
            'status' => NotificationStatus::CREATE,
            'path' => '/order-product/' . $request->id ,
            'image_url' =>  $imageUrl,
            'type' => NotificationType::CHAT,
            'title' => 'Your Request closed',
            'content' => 'Admin have close your request',
            'user_id' => $request->user->id,
        ];
    }
}
