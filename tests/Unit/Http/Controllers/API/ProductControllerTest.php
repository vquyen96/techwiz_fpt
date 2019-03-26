<?php

namespace Tests\Unit\Http\Controllers\API;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\ProductServiceInterface;
use App\Http\Controllers\API\ProductController;
use App\Models\Product;
use App\Http\Requests\Product\PublishProductRequest;

class ProductControllerTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testPublishProductShouldSuccess()
    {
        $sampleImages = '1|2|3';
        $sampleProduct = [
            'title'  => 'Wow wow',
            'game_id' => 1,
            'description' => 'Good for your life',
            'delivery_method' => 0,
            'buy_now_price' => 500,
            'expiration' => 1,
            'images' => '1|2|3',
        ];

        \Auth::shouldReceive('id')->andReturn(1);
        $request = \Mockery::mock(PublishProductRequest::class)->makePartial();
        $request->shouldReceive('only')
                ->andReturn($sampleProduct);
        $request->shouldReceive('input')
            ->with('images')
            ->andReturn($sampleImages);
        
        $mockProductService = \Mockery::mock(ProductServiceInterface::class);
        $mockProductService->shouldReceive('publish')
                            ->andReturn($sampleProduct);

        $productController = new ProductController($mockProductService);
        $response = $productController->publish($request);

        $this->assertEquals(201, $response->status());
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testGetProductDetailShouldSuccess()
    {
        $mockProductService = \Mockery::mock(ProductServiceInterface::class);
        $mockProductService->shouldReceive('getDetail')->andReturnNull();
        $productController = new ProductController($mockProductService);
        $response = $productController->show(null);

        $this->assertEquals(200, $response->status());
    }
}
