<?php

namespace Tests\Unit\Services;

use Tests\TestCase;

use App\Services\ReviewServiceInterface;
use App\Services\ReviewService;
use App\Repositories\ReviewRepository;
use App\Repositories\UserRepository;
use App\Repositories\ReviewingRepository;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ReviewServiceTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCreateReviewShouldSuccess()
    {
        $reviewData = [
            'user_id' => 2,
            'rating' => 5,
            'content' => 'Good boy'
        ];

        $sampleReviewable = [
            'id' => 1,
            'user_id' => 2,
            'reviewer_id' => 1,
            'product_id' => 'abcxyz',
        ];

        $expectedResponseData = [
            'user_id' => 2,
            'rating' => 5,
            'content' => 'Good boy',
            'reviewer_id' => 1,
            'id' => 3,
        ];

    
        \Auth::shouldReceive('id')->andReturn(1);
        \DB::shouldReceive('transaction')->andReturn((object) $expectedResponseData);

        $reviewRepository = \Mockery::mock(ReviewRepository::class);
        $reviewRepository->shouldReceive('create')
                        ->andReturn((object) $expectedResponseData);

        $reviewingRepository = \Mockery::mock(ReviewingRepository::class);
        $reviewingRepository->shouldReceive('getFirstReviewable')
                        ->with($sampleReviewable['user_id'], $sampleReviewable['reviewer_id'])
                        ->andReturn((object) $sampleReviewable);
        $reviewingRepository->shouldReceive('delete')
                        ->with(((object) $sampleReviewable)->id);

        $userRepository = \Mockery::mock(UserRepository::class);
        $userRepository->shouldReceive('updateRating')
                        ->with($sampleReviewable['user_id'], $reviewData['rating'])
                        ->andReturn(true);

        $reviewService = new ReviewService(
            $reviewRepository,
            $userRepository,
            $reviewingRepository
        );

        $response = $reviewService->create($reviewData);
        $this->assertEquals($response['review'], $expectedResponseData);
    }

      /**
     * A basic test example.
     *
     * @return void
     */
    public function testGetListReviewsShouldSuccess()
    {
        $userResponseData = (object)[
            "id" => 1,
            "name" => "RMT Admin",
            "avatar_url" => "",
            "description" => null,
            "rating" => 0,
            "created_at"=> "2018-12-07 02:42:07"
        ];

        $reviewsResponseData = [
            [
                'id' => 1,
                'reviewer_id' => 1,
                'name' => 'RMT Admin',
                'avatar_url' => '',
                'rating' => 3,
                'content' => '',
                'created_at' => '2018-12-17 01:52:40',
            ]
        ];

        $sampleReviewable = [
            'id' => 1,
            'user_id' => 2,
            'reviewer_id' => 1,
            'product_id' => 'abcxyz',
        ];

        \Auth::shouldReceive('id')->andReturn(1);

        $reviewRepository = \Mockery::mock(ReviewRepository::class);
        $userRepository = \Mockery::mock(UserRepository::class);
        $reviewingRepository = \Mockery::mock(ReviewingRepository::class);

        $userRepository->shouldReceive('find')
                        ->andReturn($userResponseData);
        $reviewRepository->shouldReceive('getReviews')
                        ->andReturn($reviewsResponseData);
        
        $reviewService = new ReviewService(
            $reviewRepository,
            $userRepository,
            $reviewingRepository
        );
                
        $response = $reviewService->getReviews(1, 1);

        $this->assertEquals($response['reviews'], $reviewsResponseData);
    }

    public function testGetListReviewsShouldFail()
    {
        $reviewRepository = \Mockery::mock(ReviewRepository::class);
        $userRepository = \Mockery::mock(UserRepository::class);
        $reviewingRepository = \Mockery::mock(ReviewingRepository::class);

        $userRepository->shouldReceive('find')
        ->andReturn(null);

        $reviewService = new ReviewService(
            $reviewRepository,
            $userRepository,
            $reviewingRepository
        );

        $this->expectException(HttpException::class);
        $response = $reviewService->getReviews(3, 1);
    }
}
