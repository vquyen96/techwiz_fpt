<?php
namespace App\Repositories;

use Bosnadev\Repositories\Eloquent\Repository;
use Illuminate\Support\Facades\Auth;
use App\Enums\Conversation\Status as ConversationStatus;

class ConversationRepository extends Repository
{
    public function model()
    {
        return 'App\Models\Conversation';
    }

    public function getListFromUser($perPage)
    {

        $userId = Auth::id();
        $columns = [
            'conversations.id',
            'conversations.title',
            'conversations.status',
            'conversations.from_user_id',
            'users.name',
            'users.avatar_url',
            'conversations.created_at'
        ];
        return $this->model->join('users', 'users.id', '=', 'conversations.to_user_id')
            ->where('conversations.from_user_id', $userId)
            ->orderByDesc('conversations.created_at')
            ->paginate($perPage, $columns);
    }

    public function getListToUser($perPage)
    {
        $userId = Auth::id();
        $columns = [
            'conversations.id',
            'conversations.title',
            'conversations.status',
            'conversations.from_user_id',
            'users.name',
            'users.avatar_url',
            'conversations.created_at'
        ];
        return $this->model->join('users', 'users.id', '=', 'conversations.from_user_id')
            ->where('conversations.to_user_id', $userId)
            ->orderByDesc('conversations.created_at')
            ->paginate($perPage, $columns);
    }

    public function readConversation($id)
    {
        $conversation = $this->model->find($id);
        if ($conversation->status == ConversationStatus::UNREAD) {
            $conversation->update(['status' => ConversationStatus::ACTIVE]);
        }
        return true;
    }
}
