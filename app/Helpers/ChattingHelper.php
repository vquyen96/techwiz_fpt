<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Auth;
use App\Repositories\ProductRepository;
use App\Repositories\BuyingRepository;
use App\Enums\Notifications\Status as NotificationStatus;
use App\Enums\Notifications\Type as NotificationType;

class ChattingHelper
{
    private $productRepository;
    private $buyingRepository;

    public function __construct(
        ProductRepository $productRepository,
        BuyingRepository $buyingRepository
    ) {
        $this->productRepository = $productRepository;
        $this->buyingRepository = $buyingRepository;
    }

    /**
     * Build product data
     *
     * @param $productData array product data
     *
     * @return array
     */
    public function checkUserValid($productId)
    {
        $product = $this->productRepository->find($productId);
        if (!is_null($product) && $product['user_id'] == Auth::id()) {
            return true;
        }
        $buying = $this->buyingRepository->findWhere([
            'product_id' => $productId
        ])->first();
        if (!is_null($buying) && $buying['user_id'] == Auth::id()) {
            return true;
        }
        return false;
    }

    public function buildNotificationData($product, $notificationType)
    {
        $imageUrl = count($product->images) > 0 ?
            $product->images[0]->thumbnail_url : null;
        $commonData = [
            'status' => NotificationStatus::CREATE,
            'path' => '/product/' . $product->id . '?type=chat',
            'image_url' => $imageUrl,
            'type' => NotificationType::CHAT,
        ];

        switch ($notificationType) {
            case NotificationType::BUY:
                return array_merge($commonData, [
                    'title' => 'You have new messages',
                    'content' => 'Seller send new messages to you',
                    'user_id' => $product->buyer->user_id,
                ]);
            case NotificationType::SELL:
                return array_merge($commonData, [
                    'title' => 'You have new messages',
                    'content' => 'Buyer send new messages to you',
                    'user_id' => $product->user_id,
                ]);
            default:
                return $commonData;
        }
    }
}
