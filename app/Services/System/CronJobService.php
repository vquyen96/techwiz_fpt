<?php
namespace App\Services\System;

use App\Repositories\NotificationRepository;
use App\Repositories\ProductRepository;
use App\Services\Admin\MailService;
use App\Enums\Notifications\Type as NotiType;
use App\Enums\Notifications\Status as NotiStatus;
use App\Enums\Products\Status as ProductStatus;

class CronJobService implements CronJobServiceInterface
{
    private $productRepository;
    private $notiRepository;
    private $mailService;


    public function __construct(
        ProductRepository $productRepository,
        NotificationRepository $notiRepository,
        MailService $mailService
    ) {
        $this->productRepository = $productRepository;
        $this->notiRepository = $notiRepository;
        $this->mailService = $mailService;
    }

    public function stopSellingProduct()
    {
        $products = $this->productRepository->getExpired();
        foreach ($products as $product) {
            $this->updateProductExpired($product);
            $this->sendEmailToInvolvedUser($product);
            $this->sendNotificationProductExpired($product);
        }
    }

    protected function updateProductExpired($product)
    {
        $this->productRepository->update([
            'status' => ProductStatus::STOP_SELLING
        ], $product->id);
    }

    protected function sendEmailToInvolvedUser($product)
    {

        $mailData = [
            'product' => $product,
            'user' => $product->user
        ];
        $this->mailService->sendProductExpired($mailData);
    }

    protected function sendNotificationProductExpired($product)
    {
        $notiData = [
            'title' => 'Product expired',
            'content' => 'Your product is expired',
            'type' => NotiType::SELL,
            'image_url' => array_first($product->images)->thumbnail_url,
            'path' => '/product/'.$product->id,
            'status' => NotiStatus::CREATE,
            'user_id' => $product->user_id,
        ];
        $this->notiRepository->create($notiData);
    }
}
