<?php

namespace App\Http\Controllers\Admin\User;

use App\Services\Admin\AuthServiceInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChangePasswordController extends Controller
{
    protected $authService;

    public function __construct(AuthServiceInterface $authService)
    {
        $this->authService = $authService;
    }

    public function main(Request $request)
    {
        $this->validation($request);
        $data = $this->getData($request);
        $response = $this->authService->changePassword($data);
        return back()->with($response['status'] ? 'success' : 'error', $response['messages']);
    }

    protected function validation($request)
    {
        return $request->validate([
            'old_password' => 'required|string',
            'password' => 'required|string|confirmed|min:6'
        ]);
    }

    protected function getData($request)
    {
        return $request->only(['old_password', 'password']);
    }
}
