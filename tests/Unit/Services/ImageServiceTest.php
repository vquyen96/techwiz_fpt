<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\ImageService;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Repositories\ImageRepository;

class ImageServiceTest extends TestCase
{
    /**
     * Test store image
     *
     * @return void
     */
    public function testStoreImageShouldSuccess()
    {
        $file = \Mockery::mock(UploadedFile::class, [
            'getClientOriginalName' => 'test.png',
        ]);

        $expectData = [
            'id' => '1',
            'title' => 'abc',
            'thumbnail_url' => 'https://hblab.co.jp/upload/thumbnail-test.png',
            'picture_url' => 'https://hblab.co.jp/upload/picture-test.png',
        ];

        $mockImageRepository = \Mockery::mock(ImageRepository::class);
        $mockImageRepository->id = $expectData['id'];
        $mockImageRepository->title = $expectData['title'];
        $mockImageRepository->thumbnail_url = $expectData['thumbnail_url'];
        $mockImageRepository->picture_url = $expectData['picture_url'];

        $mockImageService = \Mockery::mock(ImageService::class)
            ->shouldAllowMockingProtectedMethods()
            ->makePartial();
        $mockImageService->shouldReceive('resize')->andReturnNull();
        $mockImageService->shouldReceive('uploadToS3')->andReturnNull();
        $mockImageService->shouldReceive('slug')->andReturn('');
        $mockImageService->shouldReceive('insertIntoDB')->andReturn($mockImageRepository);

        $result = $mockImageService->store($file);
        $this->assertEquals($result, $expectData);
    }
}
