<?php

namespace App\Services;

use App\Repositories\CategoryRepository;

class CategoryService implements CategoryServiceInterface
{
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Get all categories
     *
     * @return array categories
     */
    public function getAll()
    {
        return $this->categoryRepository->getAllCategory();
    }
}
