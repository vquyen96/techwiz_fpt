<?php

namespace App\Repositories;

use Bosnadev\Repositories\Eloquent\Repository;

class ChattingRepository extends Repository
{
    public function model()
    {
        return 'App\Models\Chatting';
    }

    public function getAllMessage($productId, $perPage, $page)
    {
        $columns = [
            'chattings.user_id',
            'users.name',
            'users.avatar_url',
            'chattings.message',
            'chattings.created_at'
        ];
        return $this->model->join('users', 'users.id', '=', 'chattings.user_id')
                    ->where('product_id', $productId)->orderByDesc('created_at')->limit($perPage*$page)->get($columns);
    }

    public function countMessages($productId, $userId)
    {
        return $this->model->where('product_id', $productId)->where('user_id', $userId)->count();
    }
}
