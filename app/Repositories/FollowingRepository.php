<?php

namespace App\Repositories;

use Bosnadev\Repositories\Eloquent\Repository;

class FollowingRepository extends Repository
{
    public function model()
    {
        return 'App\Models\Following';
    }
}
