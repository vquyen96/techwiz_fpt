<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Services\ItemService;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Repositories\ProductRepository;
use App\Repositories\ProductTransactionRepository;
use App\Services\ProductService;
use App\Helpers\ProductHelper;
use App\Enums\Products\Status as ProductStatus;

class ProductServiceTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testPublishProductShouldSuccess()
    {
        $images = '1|2|3';
        $sampleProduct = [
            'title'  => 'Wow wow',
            'game_id' => 1,
            'description' => 'Good for your life',
            'delivery_method' => 0,
            'buy_now_price' => 500,
            'status' => 0,
            'user_id' => 1,
            'expiration' => 1
        ];
        $sampleProductTransctionData = [
            'user_id' => 1,
            'product_id' => '5c0033b2dfa4d',
            'status' => ProductStatus::PUBLISH,
        ];
        $sampleCheckImageData = [
            'id' => 1,
            'product_url' => 'https://hblab-rmt-test.s3.ap-northeast-1.amazonaws.com/picture-5bfdf46b15d42.jpeg',
            'thumbnail_url' => 'https://hblab-rmt-test.s3.ap-northeast-1.amazonaws.com/picture-5bfdf46b15d42.jpeg',
        ];

        $productHelper = \Mockery::mock(ProductHelper::class);
        $productRepository = \Mockery::mock(ProductRepository::class);
        $productTransactionRepository = \Mockery::mock(ProductTransactionRepository::class);
        $productService = new ProductService($productHelper, $productRepository, $productTransactionRepository);
        
        \DB::shouldReceive('transaction')->andReturn(true);

        $productHelper->shouldReceive('buildingProductData')->andReturn($sampleProduct);
        $productHelper->shouldReceive('buildingProductTransactionData')->andReturn($sampleProductTransctionData);
        $productHelper->shouldReceive('checkImagesInDB')->andReturn($sampleCheckImageData);
        $productRepository->shouldReceive('create')->andReturn(true);
        $productTransactionRepository->shouldReceive('create')->andReturn(true);

        $response = $productService->publish($sampleProduct, $images);
        
        $this->assertEquals($response['product'], $sampleProduct);
        $this->assertEquals($response['product_transaction'], $sampleProductTransctionData);
    }

    public function testGetLatestProductListShouldSuccess()
    {
        $sampleProduct = [
            [
                'id' => '1',
                'title'  => 'Wow 1',
                'game_id' => 1,
                'description' => 'Good for your life',
                'delivery_method' => 0,
                'buy_now_price' => 500,
                'status' => 0,
                'user_id' => 1,
                'expiration' => 1,
                'publish_date' => '2018-10-23 09:34:55',
            ],
            [
                'id' => '1',
                'title'  => 'Wow 2',
                'game_id' => 1,
                'description' => 'Good for your life',
                'delivery_method' => 0,
                'buy_now_price' => 500,
                'status' => 0,
                'user_id' => 1,
                'expiration' => 1,
                'publish_date' => '2018-10-23 08:58:30',
            ]
        ];

        $selectedFields = [
            'id',
            'title',
            'game_id',
            'description',
            'delivery_method',
            'view_count',
            'user_id',
            'published_date',
            'buy_now_price',
            'expired_date',
            'status'
        ];

        $productHelper = \Mockery::mock(ProductHelper::class);
        $productRepository = \Mockery::mock(ProductRepository::class);
        $productTransactionRepository = \Mockery::mock(ProductTransactionRepository::class);
        $productService = new ProductService($productHelper, $productRepository, $productTransactionRepository);
        
        $productRepository->shouldReceive('with')
                            ->with(['images'])
                            ->andReturn($productRepository)
                            ->shouldReceive('getNew')
                            ->with(10, 'published_date', $selectedFields)
                            ->andReturn(collect($sampleProduct))
                            ->shouldReceive('all')
                            ->andReturn($sampleProduct);

        $response = $productService->getNew(10);
        
        $this->assertEquals($response['products'], $sampleProduct);
    }

    public function testGetProductDetailShouldSuccess()
    {
        $productRepository = \Mockery::mock(ProductRepository::class);
        $productRepository->shouldReceive('find')->andReturnNull();
    }

    public function testGetListingProductsShouldSuccess()
    {
        $sampleProduct = [
            [
                'id' => '1',
                'title'  => 'Wow 1',
                'game_id' => 1,
                'description' => 'Good for your life',
                'delivery_method' => 0,
                'view_count' => 0,
                'buy_now_price' => 500,
                'expiration' => 1,
                'publish_date' => '2018-10-23 09:34:55',
                'created_at' => '2018-10-23 09:34:55',
                'expired_date' => '2018-11-19 03:11:17',
            ],
            [
                'id' => '2',
                'title'  => 'Wow 2',
                'game_id' => 1,
                'description' => 'Good for your life 2',
                'delivery_method' => 0,
                'view_count' => 0,
                'buy_now_price' => 1500,
                'expiration' => 1,
                'publish_date' => '2018-10-23 09:34:55',
                'created_at' => '2018-10-23 09:34:55',
                'expired_date' => '2018-11-19 03:11:17',
            ],
        ];

        $selectedFields = [
            'id',
            'title',
            'game_id',
            'description',
            'delivery_method',
            'view_count',
            'buy_now_price',
            'published_date',
            'created_at',
            'expired_date',
        ];

        $productHelper = \Mockery::mock(ProductHelper::class);
        $productRepository = \Mockery::mock(ProductRepository::class);
        $productTransactionRepository = \Mockery::mock(ProductTransactionRepository::class);
        $productService = new ProductService($productHelper, $productRepository, $productTransactionRepository);
        
        \Auth::shouldReceive('id')->andReturn(1);

        $productHelper->shouldReceive('handleProductStatus')->andReturn([ProductStatus::PUBLISH]);
        $productRepository->shouldReceive('with')
                            ->with(['images'])
                            ->andReturn($productRepository)
                            ->shouldReceive('getListing')
                            ->with(1, [1], 10)
                            ->andReturn(collect($sampleProduct))
                            ->shouldReceive('all')
                            ->andReturn($sampleProduct);

        $response = $productService->getListing(0, 10);
        
        $this->assertEquals($response['products'], $sampleProduct);
    }

    public function testGetPurchaseProductsShouldSuccess()
    {
        $sampleProduct = [
            [
                'id' => '1',
                'title'  => 'Wow 1',
                'game_id' => 1,
                'description' => 'Good for your life',
                'delivery_method' => 0,
                'view_count' => 0,
                'buy_now_price' => 500,
                'expiration' => 1,
                'publish_date' => '2018-10-23 09:34:55',
                'created_at' => '2018-10-23 09:34:55',
                'expired_date' => '2018-11-19 03:11:17',
            ],
            [
                'id' => '2',
                'title'  => 'Wow 2',
                'game_id' => 1,
                'description' => 'Good for your life 2',
                'delivery_method' => 0,
                'view_count' => 0,
                'buy_now_price' => 1500,
                'expiration' => 1,
                'publish_date' => '2018-10-23 09:34:55',
                'created_at' => '2018-10-23 09:34:55',
                'expired_date' => '2018-11-19 03:11:17',
            ],
        ];

        $productHelper = \Mockery::mock(ProductHelper::class);
        $productRepository = \Mockery::mock(ProductRepository::class);
        $productTransactionRepository = \Mockery::mock(ProductTransactionRepository::class);
        $productService = new ProductService($productHelper, $productRepository, $productTransactionRepository);
        
        \Auth::shouldReceive('id')->andReturn(1);

        $productHelper->shouldReceive('handleProductStatus')->andReturn([ProductStatus::PUBLISH]);
        $productRepository->shouldReceive('with')
                            ->with(['images'])
                            ->andReturn($productRepository)
                            ->shouldReceive('getPurchase')
                            ->with(1, [1], 10)
                            ->andReturn(collect($sampleProduct))
                            ->shouldReceive('all')
                            ->andReturn($sampleProduct);

        $response = $productService->getPurchase(0, 10);
        
        $this->assertEquals($response['products'], $sampleProduct);
    }
}
