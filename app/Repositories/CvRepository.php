<?php
namespace App\Repositories;

use App\Enums\Cv\Status;
use Bosnadev\Repositories\Eloquent\Repository;

class CvRepository extends Repository
{
    public function model()
    {
        return 'App\Models\Cv';
    }

    public function getActive()
    {
        return $this->model->where('status', '!=', Status::DEACTIVE);
    }
}
