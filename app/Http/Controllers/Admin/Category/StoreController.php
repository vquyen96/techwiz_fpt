<?php

namespace App\Http\Controllers\Admin\Category;

use App\Services\Admin\CategoryServiceInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StoreController extends Controller
{
    protected $categoryService;
    protected $categoryLangService;

    public function __construct(
        CategoryServiceInterface $categoryService
    ) {
        $this->categoryService = $categoryService;
    }

    public function store(Request $request)
    {
        $this->validator($request);
        $this->categoryService->store($request);
        return redirect()->route('admin.category.list');
    }

    protected function validator($request)
    {
        return $request->validate([
            'slug' => 'string|required|max:255',
            'title_en' => 'string|required|max:255',
            'title_ja' => 'string|required|max:255',
            'description_en' => 'string|required|max:255',
            'description_ja' => 'string|required|max:255',
        ]);
    }
}
