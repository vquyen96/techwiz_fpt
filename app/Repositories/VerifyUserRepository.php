<?php

namespace App\Repositories;

use Bosnadev\Repositories\Eloquent\Repository;

class VerifyUserRepository extends Repository
{
    public function model()
    {
        return 'App\Models\VerifyUser';
    }
}
