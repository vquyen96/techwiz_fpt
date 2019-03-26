<?php
namespace App\Helpers\Notifications\Product;

use App\Enums\Alerts\Product\Transfer as ProductTransfer;
use App\Enums\Notifications\Status as NotificationStatus;
use App\Enums\Notifications\Type as NotificationType;

class Transfer
{
    /**
     * Build Notification data
     *
     * @param $product Object
     * @param $notificationType Object
     *
     * @return array
     */
    public static function buildNotificationData($product, $notificationType)
    {
        $imageUrl = count($product->images) > 0 ?
                    $product->images[0]->thumbnail_url : null;
        $commonData = [
            'status' => NotificationStatus::CREATE,
            'path' => '/product/' . $product->id,
            'image_url' => $imageUrl,
        ];

        switch ($notificationType) {
            case ProductTransfer::TO_BUYER_WITH_SELLER_CANCEL_TRANSFER:
                return array_merge($commonData, [
                    'title' => 'Sending item was canceled',
                    'content' => 'Seller do not send product to you',
                    'type' => NotificationType::BUY,
                    'user_id' => $product->buyer->user_id,
                ]);
            case ProductTransfer::TO_SELLER_WITH_SELLER_CANCEL_TRANSFER:
                return array_merge($commonData, [
                    'title' => 'Sending item was canceled',
                    'content' => 'You do not send product to buyer',
                    'type' => NotificationType::SELL,
                    'user_id' => $product->user_id,
                ]);
            case ProductTransfer::TO_BUYER_WITH_BUYER_CANCEL_TRANSFER:
                return array_merge($commonData, [
                    'title' => 'Winner unreceived this product',
                    'content' => 'You was unreceived item from seller',
                    'type' => NotificationType::BUY,
                    'user_id' => $product->buyer->user_id,
                ]);
            case ProductTransfer::TO_SELLER_WITH_BUYER_CANCEL_TRANSFER:
                return array_merge($commonData, [
                    'title' => 'Buyer do not received item',
                    'content' => 'Buyer do not received your item',
                    'type' => NotificationType::SELL,
                    'user_id' => $product->user_id,
                ]);
            case ProductTransfer::TO_BUYER_WITH_BUYER_RECEIVED_TRANSFER:
                return array_merge($commonData, [
                    'title' => 'Received Item',
                    'content' => 'Great! We are happy to hear that you had received your Item',
                    'type' => NotificationType::BUY,
                    'user_id' => $product->buyer->user_id,
                ]);
            case ProductTransfer::TO_SELLER_WITH_BUYER_RECEIVED_TRANSFER:
                return array_merge($commonData, [
                    'title' => 'Customer received your Item',
                    'content' => 'Your customer received your item. We will sent money to your Paypal account soon.',
                    'type' => NotificationType::SELL,
                    'user_id' => $product->user_id,
                ]);
            default:
                return $commonData;
        }
    }
}
