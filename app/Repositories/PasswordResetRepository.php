<?php

namespace App\Repositories;

use App\Enums\Auth\ResetPassword;
use Bosnadev\Repositories\Eloquent\Repository;

class PasswordResetRepository extends Repository
{
    public function model()
    {
        return 'App\Models\PasswordReset';
    }

    public function updateStausUsed($passwordReset)
    {
        $passwordReset->status = ResetPassword::USED;
        $passwordReset->save();
    }
}
