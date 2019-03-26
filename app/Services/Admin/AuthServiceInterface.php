<?php

namespace App\Services\Admin;

interface AuthServiceInterface
{
    public function forgotPassword($email);
    public function resetPassword($data);
    public function changePassword($data);
}
