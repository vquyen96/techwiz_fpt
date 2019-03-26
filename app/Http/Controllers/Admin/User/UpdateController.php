<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Services\Admin\UserServiceInterface;
use Illuminate\Http\Request;

class UpdateController extends Controller
{
    private $userService;

    public function __construct(
        UserServiceInterface $userService
    ) {
        $this->userService = $userService;
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:127',
            'tel' => 'string|max:65535',
            'description' => 'string|max:65535',
        ]);

        $this->userService->updateUser($validatedData, $id);
        session()->flash('success', 'Update User successfully!');
        return redirect()->route('admin.user.detail', $id);
    }
}
