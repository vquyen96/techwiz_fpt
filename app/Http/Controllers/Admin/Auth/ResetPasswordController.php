<?php
namespace App\Http\Controllers\Admin\Auth;

use App\Services\Admin\AuthServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\ResetsPasswords;
use App\Http\Controllers\Controller;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    protected $redirectTo = '/admin';
    private $authService;

    public function __construct(AuthServiceInterface $authService)
    {
        $this->middleware('guest');
        $this->authService = $authService;
    }

    /**
     * @param Request $request
     * @param null $token
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showResetForm(Request $request, $token = null)
    {
        return view('admin.auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function reset(Request $request)
    {
        $this->validate($request, $this->rules(), []);
        $responseData = $this->authService->resetPassword($request);
        if ($responseData['status']) {
            return redirect($this->redirectTo)->with('success', $responseData['message']);
        }
        return back()->with('error', $responseData['message']);
    }
}
