<?php
namespace App\Helpers;

use App\Repositories\ConversationRepository;
use App\Repositories\PrivateMessagesRepository;
use Illuminate\Support\Facades\Auth;

class MessageHelper
{
    private $messageRepository;
    private $conversationRepository;

    public function __construct(
        PrivateMessagesRepository $messageRepository,
        ConversationRepository $conversationRepository
    ) {
        $this->conversationRepository = $conversationRepository;
        $this->messageRepository = $messageRepository;
    }

    public function checkUserValid($conversationId)
    {
        $convesation = $this->conversationRepository->find($conversationId);
        $authId = Auth::id();
        if (is_null($convesation)) {
            return false;
        }

        if ($convesation['to_user_id'] == $authId || $convesation['from_user_id'] == $authId) {
            return true;
        }
        return false;
    }
}
