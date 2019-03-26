<?php
namespace App\Repositories;

use Bosnadev\Repositories\Eloquent\Repository;

class CompanyLocationRepository extends Repository
{
    public function model()
    {
        return 'App\Models\CompanyLocation';
    }

    public function insertMany($date)
    {
        return $this->model->insert($date);
    }
}
