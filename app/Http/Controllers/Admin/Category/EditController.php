<?php

namespace App\Http\Controllers\Admin\Category;

use App\Services\Admin\CategoryServiceInterface;
use App\Http\Controllers\Controller;

class EditController extends Controller
{
    protected $categoryService;

    public function __construct(
        CategoryServiceInterface $categoryService
    ) {
        $this->categoryService = $categoryService;
    }

    public function edit($id)
    {
        $data = [
            'category' => $this->categoryService->show($id)
        ];
        return view('admin.category.edit', $data);
    }
}
