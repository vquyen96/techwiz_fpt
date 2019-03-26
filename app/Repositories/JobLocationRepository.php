<?php
namespace App\Repositories;

use Bosnadev\Repositories\Eloquent\Repository;

class JobLocationRepository extends Repository
{
    public function model()
    {
        return 'App\Models\JobLocation';
    }

    public function insertMany($data)
    {
        return $this->model->insert($data);
    }
}
