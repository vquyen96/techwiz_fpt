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
use App\Services\ProductConfirmService;
use App\Enums\Products\Status as ProductStatus;
use Illuminate\Support\Facades\Auth;

class ProductConfirmAcceptProductServiceTest extends TestCase
{
    /**
     * Test cancel product Failed
     *
     * @return void
     */
    public function testAcceptProductFailed()
    {
        $sampleProduct = (object) [
            'id' => '5c0033b2dfa4d',
            'status' => 4,
            'user_id' => 1,
        ];
                        
        $mailService = \Mockery::mock(MailServiceInterface::class);
        $notificationService = \Mockery::mock(NotificationServiceInterface::class);
        $productRepository = \Mockery::mock(ProductRepository::class);
        $productTransactionRepository = \Mockery::mock(ProductTransactionRepository::class);
        $walletRepository = \Mockery::mock(WalletRepository::class);
        $reviewingRepository = \Mockery::mock(ReviewingRepository::class);

        $productConfirmService = new ProductConfirmService(
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
        $response = $productConfirmService->acceptProduct('5c0033b2dfa4d');
    }
}
