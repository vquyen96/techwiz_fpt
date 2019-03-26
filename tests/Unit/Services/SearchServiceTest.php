<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Services\SearchService;
use App\Repositories\ProductRepository;

class SearchServiceTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testGetAllCategoriesShouldSuccess()
    {
        $sampleProducts = [
            [
                'id' => '1',
                'title'  => 'item 1',
                'game_id' => 1,
                'description' => 'Good for your life',
                'delivery_method' => 0,
                'buy_now_price' => 500,
                'status' => 0,
                'user_id' => 1,
                'expiration' => 1,
                'publish_date' => '2018-10-23 09:34:55',
            ]
        ];

        $productRepository = \Mockery::mock(ProductRepository::class);
        $productRepository->shouldReceive('with')
                            ->with(['images'])
                            ->andReturn($productRepository)
                            ->shouldReceive('search')
                            ->andReturn($productRepository);
        $productRepository->shouldReceive('total')
                            ->andReturn(1);
        $productRepository->shouldReceive('all')
                            ->andReturn($sampleProducts);
        
        $searchService = new SearchService($productRepository);
        $response = $searchService->search('item 1', 1, 3, 12);

        $this->assertEquals($response['total_result'], 1);
        $this->assertEquals($response['products'], $sampleProducts);
    }
}
