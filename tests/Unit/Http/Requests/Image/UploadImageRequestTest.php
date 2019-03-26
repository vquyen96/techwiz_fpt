<?php

namespace Tests\Unit\Http\Requests\Image;

use Tests\TestCase;
use App\Http\Requests\Image\UploadImageRequest;

class UploadImageRequestTest extends TestCase
{
    /**
     * Test upload image request.
     *
     * @return void
     */
    public function testUploadImageRequestShouldSuccess()
    {
        $uploadImageRequest = new UploadImageRequest();
        $currentRules = $uploadImageRequest->rules();

        $expectedRules = [
            'image' => 'required|mimes:jpeg,png,jpg|max:5120|dimensions:min_width=640,min_height=640'
        ];

        $this->assertEquals($currentRules, $expectedRules);
    }
}
