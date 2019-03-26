<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Services\Admin\UserServiceInterface;
use Illuminate\Http\Request;

class ListController extends Controller
{
    private $userService;

    public function __construct(
        UserServiceInterface $userService
    ) {
        $this->userService = $userService;
    }

    public function index(Request $request)
    {
        $count = $request->query('count') ?? 20;
        $search = $request->query('search') ?? null;
        return view('admin.user.index', [
            'userList' => $this->userService->getList($count, $search)
        ]);
    }
}
