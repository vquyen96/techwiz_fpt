<?php
namespace App\Helpers\Notifications\Payment;

use App\Enums\Alerts\Payment\Payment as AlertPayment;
use App\Enums\Notifications\Status as NotificationStatus;
use App\Enums\Notifications\Type as NotificationType;

class Payment
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

        if ($notificationType === AlertPayment::TO_SELLER_WITH_BUYER_TRANSFER_MONEY) {
            return array_merge($commonData, [
                'title' => 'Buyer payment success',
                'content' => 'The buyer has paid for the purchase. Please ship the item to buyer',
                'type' => NotificationType::SELL,
                'user_id' => $product->user_id,
            ]);
        }

        return null;
    }
}
