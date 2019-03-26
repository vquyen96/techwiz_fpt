<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\CategoryService;
use App\Models\Category;
use App\Repositories\CategoryRepository;

class CategoryServiceTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testGetAllCategoriesShouldSuccess()
    {
        $sampleCategories = [
            new Category(),
            new Category()
        ];
        $selectedFields = [
            'id',
            'title',
            'description',
            'slug',
            'parent_id'
        ];

        $categoryRepository = \Mockery::mock(CategoryRepository::class);
        $categoryRepository->shouldReceive('all')
                            ->with($selectedFields)
                            ->andReturn($sampleCategories);
        
        $categoryService = new CategoryService($categoryRepository);
        $response = $categoryService->getAll();

        $this->assertEquals($response['categories'], $sampleCategories);
    }
}
