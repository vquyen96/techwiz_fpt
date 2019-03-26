<?php
namespace App\Helpers\Notifications\Payment;

use App\Enums\Notifications\Status as NotificationStatus;
use App\Enums\Notifications\Type as NotificationType;

class Refund
{
    public static function buildNotificationData($product)
    {
        $imageUrl = count($product->images) > 0 ?
            $product->images[0]->thumbnail_url : null;
        $commonData = [
            'status' => NotificationStatus::CREATE,
            'path' => '/product/' . $product->id,
            'image_url' => $imageUrl,
        ];

        return array_merge($commonData, [
            'title' => 'Refunded money success',
            'content' => 'System refunded money to you success. Please check your account Paypal!',
            'type' => NotificationType::SYSTEM,
            'user_id' => $product->buyer->user_id,
        ]);
    }

    public static function buildMailData($product)
    {
        return [
            'user' => $product->buyer->user,
            'amount' => $product->buyer->price,
            'product_name' => $product->title,
            'product_url' => asset('product/'.$product->id)
        ];
    }
}
