<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Services\ItemService;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Repositories\ProductRepository;
use App\Repositories\ProductTransactionRepository;
use App\Repositories\WalletRepository;
use App\Repositories\ReviewingRepository;
use App\Services\MailServiceInterface;
use App\Services\NotificationServiceInterface;
use App\Services\ProductTransferService;
use App\Enums\Products\Status as ProductStatus;
use Illuminate\Support\Facades\Auth;

class ProductTransferCancelProductServiceTest extends TestCase
{
    /**
     * Test accept product seller accept
     *
     * @return void
     */
    public function testCancelSellerSendShouldSuccess()
    {
        $sampleProduct = (object) [
            'id' => '5c0033b2dfa4d',
            'status' => 5,
            'user_id' => 1,
        ];
        
        $sampleProductTransactionData = [
            'status' => ProductStatus::CANCEL,
        ];
        $sampleWalletData = [
            'balance' => 9500
        ];
                        
        $mailService = \Mockery::mock(MailServiceInterface::class);
        $notificationService = \Mockery::mock(NotificationServiceInterface::class);
        $productRepository = \Mockery::mock(ProductRepository::class);
        $productTransactionRepository = \Mockery::mock(ProductTransactionRepository::class);
        $walletRepository = \Mockery::mock(WalletRepository::class);
        $reviewingRepository = \Mockery::mock(ReviewingRepository::class);

        $productTransferService = new ProductTransferService(
            $mailService,
            $notificationService,
            $productRepository,
            $productTransactionRepository,
            $walletRepository,
            $reviewingRepository
        );

        Auth::shouldReceive('id')->andReturn(1);
        $productRepository->shouldReceive('find')->andReturn($sampleProduct);
        $productRepository->shouldReceive('update')->andReturn(ProductStatus::SELLER_SENT);
        $productTransactionRepository->shouldReceive('create')->andReturn($sampleProductTransactionData);
        $walletRepository->shouldReceive('update')->andReturn($sampleWalletData);
        $mailService->shouldReceive('sendProductTransferEmail')->andReturnNull();
        $notificationService->shouldReceive('createProductTransferNotification')->andReturnNull();
        $reviewingRepository->shouldReceive('create')->andReturn([
            'user_id' => 2,
            'product_id' => '5c0033b2dfa4d',
            'reviewer_id' => 1,
        ]);

        $response = $productTransferService->cancelProduct('5c0033b2dfa4d');
        $this->assertEquals($response['status'], ProductStatus::CANCEL);
    }

    /**
     * Test cancel product Failed
     *
     * @return void
     */
    public function testCancelProductTransferFailed()
    {
        $sampleProduct = (object) [
            'id' => '5c0033b2dfa4d',
            'status' => 6,
            'user_id' => 1,
        ];
                        
        $mailService = \Mockery::mock(MailServiceInterface::class);
        $notificationService = \Mockery::mock(NotificationServiceInterface::class);
        $productRepository = \Mockery::mock(ProductRepository::class);
        $productTransactionRepository = \Mockery::mock(ProductTransactionRepository::class);
        $walletRepository = \Mockery::mock(WalletRepository::class);
        $reviewingRepository = \Mockery::mock(ReviewingRepository::class);

        $productTransferService = new ProductTransferService(
            $mailService,
            $notificationService,
            $productRepository,
            $productTransactionRepository,
            $walletRepository,
            $reviewingRepository
        );

        Auth::shouldReceive('id')->andReturn(1);
        $productRepository->shouldReceive('find')->andReturn($sampleProduct);
        $this->expectException(HttpException::class);
        $response = $productTransferService->cancelProduct('5c0033b2dfa4d');
    }
}
