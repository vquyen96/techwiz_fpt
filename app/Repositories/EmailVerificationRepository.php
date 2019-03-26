<?php

namespace App\Repositories;

use Bosnadev\Repositories\Eloquent\Repository;

class EmailVerificationRepository extends Repository
{
    public function model()
    {
        return 'App\Models\EmailVerification';
    }
}
