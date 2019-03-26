<?php
namespace App\Services;

use App\Enums\Conversation\Status;
use App\Helpers\Notifications\Request\Conversation;
use App\Helpers\ProductHelper;
use App\Repositories\ConversationRepository;
use App\Repositories\PrivateMessagesRepository;
use Illuminate\Support\Facades\DB;

class ConversationService implements ConversationServiceInterface
{
    private $conversationRepository;
    private $privateMessagesRepository;
    private $productHelper;
    private $notiService;
    private $mailService;

    public function __construct(
        ConversationRepository $conversationRepository,
        PrivateMessagesRepository $privateMessagesRepository,
        ProductHelper $productHelper,
        NotificationServiceInterface $notiService,
        MailServiceInterface $mailService
    ) {
        $this->conversationRepository = $conversationRepository;
        $this->privateMessagesRepository = $privateMessagesRepository;
        $this->productHelper = $productHelper;
        $this->notiService = $notiService;
        $this->mailService = $mailService;
    }

    public function indexFromUser($perPage, $page)
    {
        $data =  $this->conversationRepository->with(['lastPrivateMessages'])->getListFromUser($perPage)->toArray();
        return [
            'data' => $data["data"],
            'total' => $data['total']
        ];
    }

    public function indexToUser($perPage, $page)
    {
        $data =  $this->conversationRepository->with(['lastPrivateMessages'])->getListToUser($perPage)->toArray();
        return [
            'data' => $data["data"],
            'total' => $data['total']
        ];
    }

    public function create($data, $dataMessages, $imagesData)
    {
        $imagesInDB = $this->productHelper->checkImagesInDB($imagesData);
        DB::transaction(function () use ($data, $dataMessages, $imagesInDB) {
            $conversation = $this->conversationRepository->create($data);
            $messages = $this->privateMessagesRepository->create($dataMessages);
            $messages->images()->attach($imagesInDB);
            $this->notiService->sendConversationCreateNotification($conversation);
            $this->mailService->sendConversationCreate($conversation);
        });
    }

    public function close($id)
    {
        $conversation = $this->conversationRepository->find($id);
        if (!$conversation) {
            abort('404');
        }
        DB::transaction(function () use ($conversation) {
            $conversation->update([
                'status' => Status::CLOSED
            ]);
            $this->notiService->sendConversationCloseNotification($conversation);
            $this->mailService->sendConversationClose($conversation);
        });
    }
}
