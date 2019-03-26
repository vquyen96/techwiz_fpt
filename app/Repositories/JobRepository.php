<?php
namespace App\Repositories;

use App\Enums\Job\Status;
use Bosnadev\Repositories\Eloquent\Repository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class JobRepository extends Repository
{
    public function model()
    {
        return 'App\Models\Job';
    }

    public function getActive()
    {
        $now = Carbon::now();
        $now = Carbon::createFromFormat('Y-m-d H:i:s', $now)
            ->timezone('Asia/Bangkok')
            ->format('Y-m-d H:i:s');
        return $this->model
            ->where('status', Status::ACTIVE)
            ->where('start_date', '<=', $now)
            ->where('expired_date', '>=', $now);
    }

    public function getDetail($id)
    {
        $userId = Auth::id();
        return $this->model->join('job_cvs', 'jobs.id', '=', 'job_cvs.job_id')
            ->where('job.id', $id)
            ->where('job_cvs.user_id', $userId);


    }
}
