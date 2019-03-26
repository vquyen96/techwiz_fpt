<?php

namespace Tests\Unit\Http\Requests\Product;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Requests\Product\PublishProductRequest;

class PublishProductRequestTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testPublishProductRequestShouldSuccess()
    {
        $publishProductRequest = new PublishProductRequest();
        $currentRules = $publishProductRequest->rules();

        $expectedRules = [
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:65535',
            'game_id' => 'required|integer',
            'delivery_method' => 'required|integer',
            'buy_now_price' => 'numeric|between:1,9999999999999,99',
            'expiration' => 'required|integer',
            'images' => [
                'required',
                'string',
                'regex:/[0-9\|]*$/',
            ],
        ];

        $this->assertEquals($currentRules, $expectedRules);
    }
}
