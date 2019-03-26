<?php

namespace App\Services\Admin;

use App\Enums\Auth\ResetPassword;
use App\Repositories\PasswordResetRepository;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthService implements AuthServiceInterface
{
    private $passwordResetRepository;
    private $userRepository;
    private $mailService;

    public function __construct(
        UserRepository $userRepository,
        PasswordResetRepository $passwordResetRepository,
        MailServiceInterface $mailService
    ) {
        $this->userRepository = $userRepository;
        $this->passwordResetRepository = $passwordResetRepository;
        $this->mailService = $mailService;
    }


    public function forgotPassword($email)
    {
        $user = $this->userRepository->findWhere(['email' => $email])->first();

        if (empty($user)) {
            return ['status' => 0, 'message' => 'Invalid email'];
        }
        $passwordReset = $this->passwordResetRepository->create([
            'user_id' => $user->id,
            'token' => str_random(63),
            'expired_date' => Carbon::now()->addDays(1),
            'status' => ResetPassword::UNUSE
        ]);

        $dataMail = [
            'name' => $user->name,
            'email' => $user->email,
            'token' => $passwordReset->token
        ];
        $this->mailService->sendResetPassword($dataMail);
        return ['status' => 1, 'message' => 'Please! Check your mail'];
    }

    public function resetPassword($data)
    {
        $userResetPassword = $this->getResetPassword($data['token']);
        $user = $this->userRepository->findWhere(['email' => $data['email']])->first();
        if (empty($userResetPassword)) {
            return ['status' => 0, 'message' => 'Invalid token'];
        }
        if ($user->id != $userResetPassword->user_id) {
            return ['status' => 0, 'message' => 'Invalid email'];
        }

        DB::transaction(function () use ($userResetPassword, $data) {
            $this->userRepository->updatePassword($userResetPassword->user, $data['password']);
            $this->passwordResetRepository->updateStausUsed($userResetPassword);
        });
        return ['status' => 1, 'message' => 'Your password has change'];
    }

    protected function getResetPassword($token)
    {
        $data = [
            'token' => $token,
            ['expired_date', '>=', Carbon::now()],
            'status' => ResetPassword::UNUSE
        ];
        return $this->passwordResetRepository->findWhere($data)->first();
    }

    public function changePassword($data)
    {
        if (!$this->checkOldPassword($data['old_password'])) {
            return ['status' => 0, 'messages' => 'Old password incorrect'];
        }
        $this->userRepository->updatePassword(Auth::user(), $data['password']);
        return ['status' => 1, 'messages' => 'Your password has been change'];
    }

    protected function checkOldPassword($oldPassword)
    {
        return Hash::check($oldPassword, Auth::user()->password);
    }
}
