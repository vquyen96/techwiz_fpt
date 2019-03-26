<?php

namespace App\Repositories;

use Bosnadev\Repositories\Eloquent\Repository;

class MaintenanceRepository extends Repository
{
    public function model()
    {
        return 'App\Models\Maintenance';
    }

    public function getCurrentMaintenance($now)
    {
        return $this->model->where('start_time', '<=', $now)
            ->where(function ($query) use ($now) {
                $query->where('end_time', '>', $now)
                    ->orWhereNull('end_time');
            })
            ->orderBy('start_time', 'asc');
    }

    public function getListMaintenance()
    {
        return $this->model->orderByDesc('start_time');
    }
}
