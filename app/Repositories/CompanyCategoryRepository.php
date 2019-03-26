<?php
namespace App\Repositories;

use Bosnadev\Repositories\Eloquent\Repository;

class CompanyCategoryRepository extends Repository
{
    public function model()
    {
        return 'App\Models\CompanyCategory';
    }

    public function insertMany($date)
    {
        return $this->model->insert($date);
    }
}
