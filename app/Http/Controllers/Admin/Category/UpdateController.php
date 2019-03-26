<?php

namespace App\Http\Controllers\Admin\Category;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Admin\CategoryServiceInterface;

class UpdateController extends Controller
{
    protected $categoryService;
    protected $categoryLangService;

    public function __construct(
        CategoryServiceInterface $categoryService
    ) {
        $this->categoryService = $categoryService;
    }

    public function update(Request $request, $id)
    {
        $this->validator($request);
        $this->categoryService->update($request, $id);
        return redirect()->route('admin.category.list')->with('success', 'Update category successfully');
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
