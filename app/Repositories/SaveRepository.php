<?php
namespace App\Repositories;

use Bosnadev\Repositories\Eloquent\Repository;

class SaveRepository extends Repository
{
    public function model()
    {
        return 'App\Models\Save';
    }
}
