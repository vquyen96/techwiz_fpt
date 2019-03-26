<?php

namespace Tests\Unit\Http\Controllers\API;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\CategoryServiceInterface;
use App\Http\Controllers\API\CategoryController;
use App\Models\Category;

class CategoryControllerTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testGetAllCategoriesShouldSuccess()
    {
        $sampleCategories = [
            "categories" => [
                [
                    "id" => 1,
                    "title" => "In-game items",
                    "description" => "In-game items",
                    "slug" => "in-game-items",
                    "parent_id" => null
                ],
                [
                    "id" => 2,
                    "title" => "Gift cards",
                    "description" => "Gift cards",
                    "slug"=> "gift-cards",
                    "parent_id" => null
                ]
            ]
        ];
        $categoryService = \Mockery::mock(CategoryServiceInterface::class);
        $categoryService->shouldReceive('getAll')
                        ->andReturn($sampleCategories);

        $categoryController = new CategoryController($categoryService);
        $response = $categoryController->index();
        
        $this->assertEquals($sampleCategories, json_decode($response->content(), true));
    }
}
