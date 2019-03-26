<?php

namespace App\Http\Controllers\Admin\Category;

use App\Services\Admin\CategoryServiceInterface;
use App\Http\Controllers\Controller;

class DestroyController extends Controller
{
    protected $categoryService;

    public function __construct(
        CategoryServiceInterface $categoryService
    ) {
        $this->categoryService = $categoryService;
    }

    public function destroy($id)
    {
        $this->categoryService->destroy($id);
        return back();
    }
}
