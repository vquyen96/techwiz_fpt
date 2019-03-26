<?php

namespace App\Services;

use App\Enums\User\Role;
use App\Repositories\CompanyCategoryRepository;
use App\Repositories\CompanyLocationRepository;
use App\Repositories\CompanyRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\VerifyUser;
use App\Repositories\UserRepository;
use App\Repositories\VerifyUserRepository;
use App\Repositories\PasswordResetRepository;
use App\Services\MailServiceInterface;
use App\Enums\Auth\ResetPassword;
use Carbon\Carbon;

class AuthService implements AuthServiceInterface
{
    private $userRepository;
    private $verifyUserRepository;
    private $passwordResetRepository;
    private $mailService;
    private $companyRepository;
    private $companyCategoryRepository;
    private $companyLocationRepository;

    public function __construct(
        UserRepository $userRepository,
        VerifyUserRepository $verifyUserRepository,
        PasswordResetRepository $passwordResetRepository,
        MailServiceInterface $mailService,
        CompanyRepository $companyRepository,
        CompanyCategoryRepository $companyCategoryRepository,
        CompanyLocationRepository $companyLocationRepository
    ) {
        $this->userRepository = $userRepository;
        $this->verifyUserRepository = $verifyUserRepository;
        $this->passwordResetRepository = $passwordResetRepository;
        $this->mailService = $mailService;
        $this->companyRepository = $companyRepository;
        $this->companyCategoryRepository = $companyCategoryRepository;
        $this->companyLocationRepository = $companyLocationRepository;
    }

    /**
     * Sign-in with credentials data
     *
     * @param $credentials
     * @return array with access_token
     */
    public function signIn($credentials)
    {
        if (!$token = Auth::attempt($credentials)) {
            return abort(401, __('auth.failed'));
        }
        $currentUser = Auth::user();
        if (!$currentUser->verified) {
            return abort(403, __('You need to confirm your account. Please check your email.'));
        }
        $basicInfo = $currentUser->getBasicInfo();
//        $countUnreadNotification = $this->userRepository->numberUnreadNotification($currentUser->id);
        return [
            'user' => $basicInfo,
            'access_token' => $token
        ];
    }

     /**
     * Get My Info
     *
     * @return array user personal info
     */
    public function getMyInfo()
    {
        $currentUser = Auth::user();
        $basicInfo = $currentUser->getBasicInfo();
//        $countUnreadNotification = $this->userRepository->numberUnreadNotification($currentUser->id);
        return [
            'user' => array_merge($basicInfo, [
                'paypal_email' => $currentUser->paypal_email,
//                'count_unread' => $countUnreadNotification,
            ]),
        ];
    }

    public function signOut()
    {
        Auth::logout();
    }

    /**
     * Register an account
     *
     * @param $data
     * @return string message success
     */
    public function register($data)
    {
        DB::transaction(function () use ($data, &$user, &$verifyUser) {
            $user = $this->userRepository->create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'description' => '',
                'avatar_url' => '',
                'role' => 0,
                'tel' => '',
                'verified' => 1,
                'status' => 1,
                'id' => uniqid(),
            ]);

            $verifyUser = $this->verifyUserRepository->create([
                'user_id' => $user->id,
                'token' => str_random(63)
            ]);
        });

//        $this->mailService->sendVerifyEmail([
//            'name' => $user->name,
//            'email' => $user->email,
//            'token' => $verifyUser->token
//        ]);

        return [
            "message" => $verifyUser->token
        ];
    }

    public function registerCompany($data)
    {
        DB::transaction(function () use ($data, &$user, &$verifyUser) {
            $user = $this->userRepository->create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'description' => '',
                'avatar_url' => '',
                'role' => Role::EMPLOYER,
                'tel' => '',
                'verified' => 1,
                'status' => 1,
                'id' => uniqid(),
            ]);

            $verifyUser = $this->verifyUserRepository->create([
                'user_id' => $user->id,
                'token' => str_random(63)
            ]);
            $companyId = uniqid();

            $company = $this->companyRepository->create([
                'id' => $companyId,
                'name' => $data['company_name'],
                'user_id' => $user->id,
                'tel' => $data['company_tel'],
            ]);

            $categories = explode(",", $data['company_categories']);
            $categoriesInsert = [];
            foreach ($categories as $category) {
                $insertItem = [
                    'company_id' => $companyId,
                    'category_id' => $category
                ];
                $categoriesInsert[] = $insertItem;
            }
            $this->companyCategoryRepository->insertMany($categoriesInsert);

            $locationIds = explode(",", $data['company_locations']);
            $locations = [];
            foreach ($locationIds as $locationId) {
                $insertItem = [
                    'company_id' => $companyId,
                    'location_id' => $locationId
                ];
                $locations[] = $insertItem;
            }
            $this->companyLocationRepository->insertMany($locations);
        });

        return $user;
    }

    /**
     * Send mail again to verify user
     *
     * @param $email
     * @return array
     */
    public function sendMailVerify($data)
    {
        $user = $this->userRepository->getUserByEmail($data['email']);
        if (!isset($user)) {
            return abort(400, 'Email not match');
        }
        if (isset($user) && !Hash::check($data['password'], $user->password)) {
            return abort(400, 'Password not match');
        }
        $verifyUser = $this->verifyUserRepository->findWhere(['user_id'=>$user->id])->first();
        $this->mailService->sendVerifyEmail([
            'name' => $user->name,
            'email' => $user->email,
            'token' => $verifyUser->token
        ]);
        return ['message' => 'OK'];
    }

    /**
     * Verify an account
     *
     * @param $token
     * @return string message success
     */
    public function verifyUser($token)
    {
        $verifyUser = $this->verifyUserRepository->findWhere(['token' => $token])->first();
        if (isset($verifyUser)) {
            if (!$verifyUser->user->verified) {
                $verifyUser->user->verified = 1;
                $verifyUser->user->save();
                $message = "Your e-mail is verified. You can now login.";
            } else {
                $message = "Your e-mail is already verified. You can now login.";
            }
        } else {
            return abort(401, __('auth.failed'));
        }

        return ['message' => $message];
    }

    /**
     * Send mail reset password
     *
     * @param $email
     * @return string message success
     */
    public function forgotPassword($email)
    {
        $user = $this->userRepository->findWhere(['email' => $email])->first();
        if (empty($user)) {
            abort(404);
        }
        $passwordReset = $this->passwordResetRepository->create([
            'user_id' => $user->id,
            'token' => str_random(63),
            'expired_date' => Carbon::now()->addDays(1),
            'status' => ResetPassword::UNUSE
        ]);
        $this->mailService->sendResetPassword([
            'name' => $user->name,
            'email' => $user->email,
            'token' => $passwordReset->token
        ]);
        return ['message' => 'OK'];
    }

    /**
     * Reset password
     *
     * @param $token
     * @param $password
     * @return string message success
     */
    public function resetPassword($token, $password)
    {
        $userResetPassword = $this->passwordResetRepository->findWhere([
            'token' => $token,
            ['expired_date', '>=', Carbon::now()],
            'status' => ResetPassword::UNUSE
        ])->first();
        if (empty($userResetPassword)) {
            abort(404);
        }
        DB::transaction(function () use ($userResetPassword, $password) {
            $userResetPassword->user->password = Hash::make($password);
            $userResetPassword->user->save();
            $userResetPassword->status = ResetPassword::USED;
            $userResetPassword->save();
        });
        return ['message' => 'OK'];
    }
}
