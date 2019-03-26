<?php

namespace App\Repositories;

use App\Enums\Notifications\Status as NotificationStatus;
use Bosnadev\Repositories\Eloquent\Repository;

class NotificationRepository extends Repository
{
    public function model()
    {
        return 'App\Models\Notification';
    }
    
    public function getNotification($userId, $typeArray, $perPage, $column = array('*'))
    {
        $ordering = 'DESC';
        return $this->model->where('notifications.user_id', $userId)
            ->whereIn('notifications.type', $typeArray)
            ->orderBy('notifications.id', $ordering)
            ->paginate($perPage, $column);
    }

    public function getCountUnread($userId)
    {
        return $this->model
            ->where('user_id', $userId)
            ->where('status', NotificationStatus::CREATE)
            ->count();
    }
}
