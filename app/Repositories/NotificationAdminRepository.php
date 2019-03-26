<?php
namespace App\Repositories;

use App\Enums\Notifications\Status as NotificationStatus;
use Bosnadev\Repositories\Eloquent\Repository;

class NotificationAdminRepository extends Repository
{
    public function model()
    {
        return 'App\Models\NotificationAdmin';
    }

    public function getNotification($column = array('*'))
    {
        $perPage = 10;
        return $this->model
            ->orderByDesc('id')
            ->limit($perPage)
            ->get();
    }

    public function getCountUnread()
    {
        return $this->model
            ->where('status', NotificationStatus::CREATE)
            ->count();
    }

    public function getTicketUnread($path)
    {
        return $this->model->where(['path' => $path, 'status' => NotificationStatus::CREATE]);
    }

    public function getAll()
    {
        return $this->model
            ->orderByDesc('created_at');
    }

    public function readAll()
    {
        return $this->model
            ->where('status', NotificationStatus::CREATE)
            ->update(['status' => NotificationStatus::READ]);
    }
}
