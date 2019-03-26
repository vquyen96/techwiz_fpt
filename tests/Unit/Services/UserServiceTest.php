<?php

namespace Tests\Unit\Services;

use Tests\TestCase;

use App\Services\UserServiceInterface;
use App\Services\UserService;
use App\Repositories\UserRepository;
use App\Repositories\BuyingRepository;
use App\Repositories\ReviewingRepository;
use Symfony\Component\HttpKernel\Exception\HttpException;

class UserServiceTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testGetUserInfoShouldSuccess()
    {
        $userResponseData = (object)[
            "id" => 1,
            "name" => "RMT Admin",
            "avatar_url" => "",
            "description" => null,
            "rating" => 0,
            "created_at"=> "2018-12-07 02:42:07"
        ];

        $buyingResponseData = [
            [
                'id' => 1,
                'product_id' => "5c0dc6e8269bc",
                'user_id' => 1,
                'price' => '1000.00',
                'created_at' => '2018-12-17 01:52:40',
                'updated_at' => '2018-12-17 01:52:40',
            ]
        ];

        $buyingCount = 1;
        $reviewable = false;

        \Auth::shouldReceive('id')->andReturn(1);

        $userRepository = \Mockery::mock(UserRepository::class);
        $buyingRepository = \Mockery::mock(BuyingRepository::class);
        $reviewingRepository = \Mockery::mock(ReviewingRepository::class);

        $userRepository->shouldReceive('find')
                        ->andReturn($userResponseData);
        $buyingRepository->shouldReceive('findWhere')
                        ->andReturn(collect($buyingResponseData))
                        -> shouldReceive('count')
                        ->andReturn($buyingCount);
        $reviewingRepository->shouldReceive('numberRemainingReview')
                        ->andReturn($reviewable);
                        
        $userService = new UserService(
            $userRepository,
            $buyingRepository,
            $reviewingRepository
        );

        $response = $userService->getUserInfo(1);

        $this->assertEquals($response['user'], $userResponseData);
        $this->assertEquals($response['buying_count'], $buyingCount);
        $this->assertEquals($response['reviewable'], $reviewable);
    }

    public function testGetUserInfoShouldFail()
    {
        $userRepository = \Mockery::mock(UserRepository::class);
        $buyingRepository = \Mockery::mock(BuyingRepository::class);
        $reviewingRepository = \Mockery::mock(ReviewingRepository::class);

        $userRepository->shouldReceive('find')
        ->andReturn(null);

        $userService = new UserService(
            $userRepository,
            $buyingRepository,
            $reviewingRepository
        );

        $this->expectException(HttpException::class);
        $response = $userService->getUserInfo(3);
    }
}
