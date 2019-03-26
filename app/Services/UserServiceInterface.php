<?php

namespace App\Services;

interface UserServiceInterface
{
    public function getUserInfo($id);
    public function updatePaypalEmail($paypalEmail);
    public function update($userData);
    public function changePassword($currentPassword, $newPassword);
    public function publicProducts($userId, $perPage);
}
