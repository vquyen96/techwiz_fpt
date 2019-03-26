<?php

namespace App\Repositories;

use Bosnadev\Repositories\Eloquent\Repository;

class BuyingRepository extends Repository
{
    public function model()
    {
        return 'App\Models\Buying';
    }

    public function updateStatus($buying, $status)
    {
        return $buying->update(['status' => $status]);
    }
}
