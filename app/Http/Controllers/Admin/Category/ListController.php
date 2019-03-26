<?php

namespace App\Http\Controllers\Admin\Category;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Admin\CategoryServiceInterface;

class ListController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryServiceInterface $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index(Request $request)
    {
        $count = $request->query('count') ?? 20;
        $search = $request->query('search') ?? null;

        $data = [
            'categories' => $this->categoryService->index($search, $count)
        ];
        return view('admin.category.index', $data);
    }
}
