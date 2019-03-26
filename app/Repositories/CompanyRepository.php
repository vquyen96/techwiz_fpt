<?php
namespace App\Repositories;

use Bosnadev\Repositories\Eloquent\Repository;

class CompanyRepository extends Repository
{
    public function model()
    {
        return 'App\Models\Company';
    }
}