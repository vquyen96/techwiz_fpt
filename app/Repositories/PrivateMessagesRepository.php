<?php
namespace App\Repositories;

use Bosnadev\Repositories\Eloquent\Repository;

class PrivateMessagesRepository extends Repository
{
    public function model()
    {
        return 'App\Models\PrivateMessage';
    }

    public function getList($conversationId, $perPage)
    {
        return $this->model
            ->where('conversation_id', $conversationId)
            ->orderByDesc('created_at')
            ->paginate($perPage)
            ->toArray();
    }
}
