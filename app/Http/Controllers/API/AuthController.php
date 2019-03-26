<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\AuthServiceInterface;
use App\Http\Requests\Auth\SignInRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;

/**
 * @group auth
 */
class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthServiceInterface $authService)
    {
        $this->authService = $authService;
    }
 
    /**
     * Sign-In
     * Sign In with given Credentials
     *
     * @param SignInRequest $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @bodyParam email string required Email to login
     * @bodyParam password string required Password to login
     *
     * @response {
     * "user": {
     *   "name": "saovv",
     *   "email": "saovv@hblab.vn",
     *   "avatar_url": "",
     *   "role": 0,
     *   "tel": ""
     *   },
     *   "access_token": "xxxx"
     *   }
     */
    public function signIn(SignInRequest $request)
    {
        $credentials = $request->only([
            'email',
            'password',
        ]);
        $responseData = $this->authService->signIn($credentials);
        return response()->json($responseData, 200);
    }
    
    /**
     * Me
     * Get My Info from Token
     *
     * @return \Illuminate\Http\JsonResponse
     *
     *
     * @response {
     * "user": {
     *   "name": "Admin",
     *   "email": "admin@hblab.co.jp",
     *   "avatar_url": "",
     *   "role": 0,
     *   "tel": "",
     *   "count_unread": 1
     *   }
     * }
     */
    public function me()
    {
        $responseData = $this->authService->getMyInfo();
        return response()->json($responseData, 200);
    }

    /**
     * Sign-Out
     * Sign Out and invalidate Token
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @authenticated
     * @response {
     * }
     *
     */
    public function signOut()
    {
        $this->authService->signOut();
        return response('', 204);
    }

    /**
     * Register
     * Create an account
     *
     * @param RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @bodyParam name string required Name to create
     * @bodyParam email string required Email to create
     * @bodyParam password string required Password to create
     * @bodyParam password_confirmation string required Password Confirm to create
     *
     * @response {
     *   "message": "OK"
     * }
     */
    public function register(RegisterRequest $request)
    {
        $data = $request->only([
            'name',
            'email',
            'password',
        ]);
        $responseData = $this->authService->register($data);
        return response()->json($responseData, 201);
    }

    /**
     * Register Company
     * Create an account
     *
     * @param RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @bodyParam name string required Name to create
     * @bodyParam email string required Email to create
     * @bodyParam password string required Password to create
     * @bodyParam password_confirmation string required Password Confirm to create
     *
     * @response {
     *   "message": "OK"
     * }
     */
    public function registerCompany(RegisterRequest $request)
    {
        $dataUser = $request->only([
            'name',
            'email',
            'password',
            'company_name',
            'company_tel',
            'company_categories',
            'company_locations'
        ]);
        $responseData = $this->authService->registerCompany($dataUser);
        return response()->json($responseData, 201);
    }

    /**
     * Verify User
     * Active an account
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @queryParam token string required token for verify account
     *
     * @response {
     *   "message": "Your e-mail is verified. You can now login."
     * }
     */
    public function verifyUser($token)
    {
        $responseData = $this->authService->verifyUser($token);
        return response()->json($responseData, 200);
    }

    /**
     * Forgot Password
     * Request new password
     *
     * @param ForgotPasswordRequest $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @queryParam email string required email to send reset passwork link
     *
     * @response {
     *   "message": "OK"
     * }
     */
    public function forgotPassword(ForgotPasswordRequest $request)
    {
        $responseData = $this->authService->forgotPassword($request->email);
        return response()->json($responseData, 200);
    }

    /**
     * Reset
     * Reset Password
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @queryParam token string required token for reset password
     * @bodyParam password string required Password to reset
     * @bodyParam password_confirmation string required Password Confirm to reset
     *
     * @response {
     *   "message": "Your e-mail is verified. You can now login."
     * }
     */
    public function reset(ResetPasswordRequest $request, $token)
    {
        $responseData = $this->authService->resetPassword($token, $request->password);
        return response()->json($responseData, 200);
    }

    /**
     * Send mail verify user
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @bodyParam email string required Email to get user
     * @bodyParam password string required Password to check user
     *
     * @response {
     *   "message": "OK"
     * }
     *
     */
    public function sendMailVerify(SignInRequest $request)
    {
        $data = $request->only([
            'email',
            'password'
        ]);
        $responseData = $this->authService->sendMailVerify($data);
        return response()->json($responseData, 200);
    }
}
