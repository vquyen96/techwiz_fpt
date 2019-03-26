<?php
namespace App\Services\System;

use App\Repositories\BuyingRepository;
use App\Repositories\NotificationRepository;
use App\Repositories\ProductRepository;
use App\Services\Admin\MailServiceInterface;
use App\Enums\Notifications\Status as NotiStatus;
use App\Enums\Notifications\Type as NotiType;
use App\Enums\Products\Status as ProductStatus;

class ConfirmReceivedService implements ConfirmReceivedServiceInterface
{
    private $productRepository;
    private $mailService;
    private $notiRepository;
    private $buyingRepository;

    public function __construct(
        ProductRepository $productRepository,
        MailServiceInterface $mailService,
        NotificationRepository $notiRepository,
        BuyingRepository $buyingRepository
    ) {
        $this->productRepository = $productRepository;
        $this->mailService = $mailService;
        $this->notiRepository = $notiRepository;
        $this->buyingRepository = $buyingRepository;
    }

    public function confirmReceived()
    {
        $prodcuts = $this->productRepository->getBuyingSuccess();
        foreach ($prodcuts as $product) {
            if ($product->noti) {
                $this->sendNotificationRemind($product);
                $this->sendEmailRemindUser($product);
                $buying = $this->buyingRepository->find($product->buyer->id);
                $buying->update(['remind_receive' => $buying->remind_receive++]);
            }
            if ($product->received) {
                $this->sendNotificationReceivedProduct($product);
                $this->sendEmailReceivedProduct($product);
                $this->updateProductReceived($product);
            }
        }
    }

    private function sendEmailRemindUser($product)
    {
        $mailData = [
            'product' => $product,
            'user' => $product->buyer->user
        ];
        $this->mailService->sendRemindReceivedProduct($mailData);
    }

    private function sendEmailReceivedProduct($product)
    {
        $mailData = [
            'product' => $product,
            'user' => $product->buyer->user
        ];
        $this->mailService->sendReceivedProduct($mailData);
    }

    private function sendNotificationRemind($product)
    {
        $notiData = [
            'title' => 'Confirm received product',
            'content' => 'Are you received product',
            'type' => NotiType::SELL,
            'image_url' => array_first($product->images)->thumbnail_url,
            'path' => '/product/'.$product->id,
            'status' => NotiStatus::CREATE,
            'user_id' => $product->buyer->user_id,
        ];
        $this->notiRepository->create($notiData);
    }

    private function sendNotificationReceivedProduct($product)
    {
        $notiData = [
            'title' => 'You received product',
            'content' => 'Are you received product',
            'type' => NotiType::SELL,
            'image_url' => array_first($product->images)->thumbnail_url,
            'path' => '/product/'.$product->id,
            'status' => NotiStatus::CREATE,
            'user_id' => $product->buyer->user_id,
        ];
        $this->notiRepository->create($notiData);
    }



    private function updateProductReceived($product)
    {
        $this->productRepository->update([
            'status' => ProductStatus::BUYER_RECEIVED
        ], $product->id);
    }
}
