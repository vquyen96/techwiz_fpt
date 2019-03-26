<?php
namespace App\Services;

use App\Helpers\MessageHelper;
use App\Helpers\Notifications\Request\PrivateMessage;
use App\Helpers\ProductHelper;
use App\Repositories\ConversationRepository;
use App\Repositories\NotificationRepository;
use App\Repositories\PrivateMessagesRepository;
use App\Enums\Conversation\Status as ConversationStatus;
use App\Enums\Notifications\Type as NotificationType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PrivateMessageService implements PrivateMessageServiceInterface
{
    private $messageHelper;
    private $conversationRepository;
    private $privateMessageRepository;
    private $productHelper;
    private $notiService;
    private $mailService;

    public function __construct(
        MessageHelper $messageHelper,
        ConversationRepository $conversationRepository,
        PrivateMessagesRepository $privateMessagesRepository,
        ProductHelper $productHelper,
        NotificationServiceInterface $notiService,
        MailServiceInterface $mailService
    ) {
        $this->messageHelper = $messageHelper;
        $this->conversationRepository = $conversationRepository;
        $this->privateMessageRepository = $privateMessagesRepository;
        $this->productHelper = $productHelper;
        $this->notiService = $notiService;
        $this->mailService = $mailService;
    }

    public function list($conversationId, $perPage, $page)
    {
        if (!$this->messageHelper->checkUserValid($conversationId)) {
            abort(403, 'Your request was rejected');
        }

        $this->conversationRepository->readConversation($conversationId);
        $conversation = $this->conversationRepository->find($conversationId);

        $messages =  $this->privateMessageRepository
            ->with(['user:id,name,email,description,avatar_url', 'images'])
            ->getList($conversationId, $perPage);

        return [
            'conversation' => $conversation,
            'messages' => $messages['data'],
            'total' => $messages['total']
        ];
    }

    public function send($conversationId, $dataMes, $imagesData)
    {
        if (!$this->messageHelper->checkUserValid($conversationId)) {
            abort(403, 'Your request was rejected');
        }

        $imagesInDB = $this->productHelper->checkImagesInDB($imagesData);
        $conversation = $this->conversationRepository->find($conversationId);

        if ($conversation->to_user_id == Auth::id()) {
            $notificationType = NotificationType::SELL;
        } else {
            $notificationType = NotificationType::BUY;
        }

        DB::transaction(function () use ($dataMes, $imagesInDB, $notificationType) {
            $messages = $this->privateMessageRepository->create($dataMes);
            $messages->images()->attach($imagesInDB);
            $this->notiService->sendPrivateMessageNotification($messages, $notificationType);
            $this->mailService->sendPrivateMessageReply($messages, $notificationType);
        });
    }
}
