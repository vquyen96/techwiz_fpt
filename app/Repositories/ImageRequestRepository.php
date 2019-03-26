<?php

namespace App\Repositories;

use Bosnadev\Repositories\Eloquent\Repository;

class ImageRequestRepository extends Repository
{
    public function model()
    {
        return 'App\Models\ImageRequest';
    }
}
