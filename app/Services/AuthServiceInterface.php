<?php

namespace App\Services;

interface AuthServiceInterface
{
    public function signIn($credentials);
    public function getMyInfo();
    public function signOut();
    public function register($data);
    public function sendMailVerify($data);
    public function verifyUser($token);
    public function forgotPassword($email);
    public function resetPassword($token, $password);
}
