<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Services\Admin\UserServiceInterface;
use Illuminate\Http\Request;

class ShowController extends Controller
{
    private $userService;

    public function __construct(
        UserServiceInterface $userService
    ) {
        $this->userService = $userService;
    }

    public function show(Request $request, $id)
    {
        $user = $this->userService->getDetail($id);
        return view('admin.user.show', [
            'user' => $user,
            'isEdit' => $request->get('target') === 'edit'
        ]);
    }
}
