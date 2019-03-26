<?php
namespace App\Helpers\Notifications\Product;

use App\Enums\Notifications\Status as NotificationStatus;
use App\Enums\Notifications\Type as NotificationType;

class Product
{
    public function buildNotificationClose($product)
    {
        $imageUrl = count($product->images) > 0 ?
            $product->images[0]->thumbnail_url : null;

        $commonData = [
            'status' => NotificationStatus::CREATE,
            'path' => '/product/' . $product->id,
            'image_url' => $imageUrl,
        ];
        return array_merge($commonData, [
            'title' => 'Product was canceled',
            'content' => 'Your product has been canceled',
            'type' => NotificationType::SYSTEM,
            'user_id' => $product->user_id,
        ]);
    }
}
