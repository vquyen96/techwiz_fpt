<?php

namespace App\Repositories;

use Bosnadev\Repositories\Eloquent\Repository;

class ImageProductRepository extends Repository
{
    public function model()
    {
        return 'App\Models\ImageProduct';
    }
}
