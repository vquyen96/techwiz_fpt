<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Services\Admin\AuthServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use App\Http\Controllers\Controller;

class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;
    protected $authService;

    public function __construct(AuthServiceInterface $authService)
    {
        $this->middleware('guest');
        $this->authService = $authService;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showLinkRequestForm()
    {
        return view('admin.auth.passwords.email');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendResetLinkEmail(Request $request)
    {
        $this->validateEmail($request);
        $success = $this->authService->forgotPassword($request->email);
        $data['email'] = $request->email;
        return redirect()
            ->route('password.request', $data)
            ->with($success['status'] ? 'success' : 'error', $success['message']);
    }
}
