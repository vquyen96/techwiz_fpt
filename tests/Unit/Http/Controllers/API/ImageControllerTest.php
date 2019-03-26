<?php

namespace Tests\Unit\Http\Controllers\API;

use Tests\TestCase;
use App\Http\Requests\Image\UploadImageRequest;
use App\Services\ImageServiceInterface;
use App\Http\Controllers\API\ImageController;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageControllerTest extends TestCase
{
    /**
     * Image upload controller
     *
     * @return void
     */
    public function testStoreShouldSuccess()
    {
        $file = \Mockery::mock(UploadedFile::class);
        $image = [
            'id' => '1',
            'title' => 'wow wow',
            'thumbnail_url' => 'https://hblab.co.jp/upload/thumbnail-test.png',
            'picture_url' => 'https://hblab.co.jp/upload/picture-test.png',
        ];

        $request = \Mockery::mock(UploadImageRequest::class)->makePartial();
        $request->shouldReceive('file')->with('image')->andReturn($file);

        $mockImageService = \Mockery::mock(ImageServiceInterface::class)->makePartial();
        $mockImageService->shouldReceive('store')->andReturn($image);

        $imageController = new ImageController($mockImageService);
        $response = $imageController->store($request);
        $this->assertEquals((array) $response->getData(), $image);
    }
}
