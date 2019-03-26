<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use App\Repositories\ChattingRepository;
use App\Helpers\ChattingHelper;
use App\Repositories\ProductRepository;
use App\Enums\Notifications\Type as NotificationType;

class ChattingService implements ChattingServiceInterface
{
    private $chattingRepository;
    private $chattingHelper;
    private $productRepository;
    private $notificationService;
    const MAX_MESSAGES = 15;

    public function __construct(
        ChattingRepository $chattingRepository,
        ChattingHelper $chattingHelper,
        ProductRepository $productRepository,
        NotificationServiceInterface $notificationService
    ) {
        $this->chattingRepository = $chattingRepository;
        $this->chattingHelper = $chattingHelper;
        $this->productRepository = $productRepository;
        $this->notificationService = $notificationService;
    }

    /**
     * Get all messages
     *
     * @return array messages
     */
    public function list($productId, $perPage, $page)
    {
        $userId = Auth::id();
        if (!$this->chattingHelper->checkUserValid($productId)) {
            abort(403, 'Your request was rejected');
        }

        $messages = $this->chattingRepository->getAllMessage($productId, $perPage, $page)->toArray();
        return [
            'messages' => $messages,
            'total_messages' => $this->chattingRepository->countMessages($productId, $userId),
            'maximum_messages' => $this::MAX_MESSAGES
        ];
    }

    /**
     * Get all messages
     *
     * @return array messages
     */
    public function send($productId, $message)
    {
        $userId = Auth::id();
        if (!$this->chattingHelper->checkUserValid($productId)) {
            abort(403, 'Your request was rejected');
        }
        if ($this->chattingRepository->countMessages($productId, $userId) > $this::MAX_MESSAGES) {
            abort(400, 'You have run out of messages to send');
        }

        $this->chattingRepository->create([
            'product_id' => $productId,
            'user_id' => $userId,
            'message' => $message
        ]);

        $product = $this->productRepository->find($productId);
        if (!is_null($product) && $product['user_id'] == Auth::id()) {
            $notificationType = NotificationType::BUY;
        } else {
            $notificationType = NotificationType::SELL;
        }

        $this->notificationService->sendChattingNotification($product, $notificationType);
        return [
            'messages' => 'OK',
        ];
    }
}
