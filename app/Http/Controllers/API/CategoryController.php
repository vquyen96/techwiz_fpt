<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\CategoryServiceInterface;

/**
 * @group Category
 */
class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryServiceInterface $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        $responseData = $this->categoryService->getAll();
        return response()->json($responseData, 200);
    }
}
