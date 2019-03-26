<?php
namespace App\Repositories;

use Bosnadev\Repositories\Eloquent\Repository;

class LocationRepository extends Repository
{
    public function model()
    {
        return 'App\Models\Location';
    }

    public function getAll()
    {
        $colums = [
            'id',
            'title'
        ];
        return $this->model
            ->where('status', 1)
            ->orderBy('title', 'asc')
            ->get($colums);
    }
}
