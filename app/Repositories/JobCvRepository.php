<?php
namespace App\Repositories;

use Bosnadev\Repositories\Eloquent\Repository;

class JobCvRepository extends Repository
{
    public function model()
    {
        return 'App\Models\JobCv';
    }
}