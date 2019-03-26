<?php

namespace App\Repositories;

use Bosnadev\Repositories\Eloquent\Repository;

class FavoriteRepository extends Repository
{
    public function model()
    {
        return 'App\Models\Favorite';
    }
}
