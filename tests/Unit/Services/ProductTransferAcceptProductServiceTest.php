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

class ProductTransferAcceptProductServiceTest extends TestCase
{
    /**
     * Test accept product seller accept
     *
     * @return void
     */
    public function testAcceptSellerSendShouldSuccess()
    {
        $sampleProduct = (object) [
            'id' => '5c0033b2dfa4d',
            'user_id' => 2,
            'status' => 5,
            'user' => (object) [
                    'wallet' => (object) [
                        'id' => 1,
                        'balance' => 9000
                    ]
                ]
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
        $walletRepository->shouldReceive('update')->andReturn($sampleWalletData);
        $mailService->shouldReceive('sendProductTransferEmail')->andReturnNull();
        $notificationService->shouldReceive('createProductTransferNotification')->andReturnNull();
        $reviewingRepository->shouldReceive('create')->andReturn([
            'user_id' => 1,
            'product_id' => '5c0033b2dfa4d',
            'reviewer_id' => 2,
        ]);
        $reviewingRepository->shouldReceive('create')->andReturn([
            'user_id' => 2,
            'product_id' => '5c0033b2dfa4d',
            'reviewer_id' => 1,
        ]);

        $response = $productTransferService->acceptProduct('5c0033b2dfa4d');
        $this->assertEquals($response['status'], ProductStatus::BUYER_RECEIVED);
    }

    /**
     * Test cancel product Failed
     *
     * @return void
     */
    public function testAcceptProductTransferFailed()
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
        $response = $productTransferService->acceptProduct('5c0033b2dfa4d');
    }
}
