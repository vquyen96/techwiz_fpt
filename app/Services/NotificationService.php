<?php

namespace App\Services;

use App\Enums\Notifications\Type as NotificationType;
use App\Enums\Notifications\Status as NotificationStatus;
use App\Helpers\ChattingHelper;
use App\Helpers\Notifications\Payment\Refund;
use App\Helpers\Notifications\Product\Product;
use App\Helpers\Notifications\Product\Transfer as ProductTransfer;
use App\Helpers\Notifications\Payment\Payment;
use App\Helpers\Notifications\Request\Conversation;
use App\Helpers\Notifications\Request\CloseRequest;
use App\Helpers\Notifications\Request\ExpiredRequest;
use App\Helpers\Notifications\Request\PrivateMessage;
use App\Repositories\NotificationRepository;
use Illuminate\Support\Facades\Auth;

class NotificationService implements NotificationServiceInterface
{
    private $notificationRepository;
    private $chattingHelper;
    private $productHelper;
    private $privateMessageHelper;
    private $conversationHelper;
    private $closeRequestHelper;

    public function __construct(
        NotificationRepository $notificationRepository,
        ChattingHelper $chattingHelper,
        Product $productHelper,
        PrivateMessage $privateMessageHelper,
        Conversation $conversationHelper,
        CloseRequest $closeRequestHelper
    ) {
        $this->notificationRepository = $notificationRepository;
        $this->chattingHelper = $chattingHelper;
        $this->productHelper = $productHelper;
        $this->privateMessageHelper = $privateMessageHelper;
        $this->conversationHelper = $conversationHelper;
        $this->closeRequestHelper = $closeRequestHelper;
    }

    public function getNotification($type, $perPage)
    {
        $selectedFields = [
            'id',
            'title',
            'content',
            'type',
            'image_url',
            'path',
            'status',
            'created_at',
        ];
        $userId = Auth::id();
        $typeArray = $this->handleNotificationType($type);
        $countUnread = $this->notificationRepository->getCountUnread($userId);
        $notification = $this->notificationRepository
                        ->getNotification($userId, $typeArray, $perPage, $selectedFields)
                        ->all();
        return [
            'count_unread' => $countUnread,
            'notifications' => $notification
        ];
    }

    private function handleNotificationType($type)
    {
        switch ($type) {
            case 0:
                return [
                    NotificationType::SYSTEM,
                    NotificationType::BUY,
                    NotificationType::SELL,
                    NotificationType::CHAT,
                ];
            case 1:
                return [NotificationType::SYSTEM];
            case 2:
                return [NotificationType::BUY];
            case 3:
                return [NotificationType::SELL];
            case 4:
                return [NotificationType::CHAT];
            default:
                return [];
        }
    }

    public function sendProductTransferNotification($product, $notificationType)
    {
        $notificationData = ProductTransfer::buildNotificationData($product, $notificationType);
        return $this->notificationRepository->create($notificationData);
    }

    public function sendPaymentNotification($product, $notificationType)
    {
        $notificationData = Payment::buildNotificationData($product, $notificationType);
        return isset($notificationData) ? $this->notificationRepository->create($notificationData) : null;
    }

    public function sendChattingNotification($product, $notificationType)
    {
        $notificationData = $this->chattingHelper->buildNotificationData($product, $notificationType);
        return $this->notificationRepository->create($notificationData);
    }

    public function sendRefundNotification($product)
    {
        $notificationData = Refund::buildNotificationData($product);
        return $this->notificationRepository->create($notificationData);
    }

    public function sendProductClose($product)
    {
        $notificationData = $this->productHelper->buildNotificationClose($product);
        return $this->notificationRepository->create($notificationData);
    }

    public function readNotification($id)
    {
        $this->notificationRepository->update([
            'status' => NotificationStatus::READ
        ], $id);

        return ['status' => NotificationStatus::READ];
    }

    public function sendPrivateMessageNotification($message, $notificationType)
    {
        $notificationData = $this->privateMessageHelper->buildNotificationReply($message, $notificationType);
        return $this->notificationRepository->create($notificationData);
    }

    public function sendConversationCreateNotification($conversation)
    {
        $notificationData = $this->conversationHelper->buildNotificationCreate($conversation);
        return $this->notificationRepository->create($notificationData);
    }
    public function sendConversationCloseNotification($conversation)
    {
        $notificationData = $this->conversationHelper->buildNotificationClose($conversation);
        return $this->notificationRepository->create($notificationData);
    }

    public function sendRequestClosedNotification($request)
    {
        $notificationData = $this->closeRequestHelper->buildNotificationClose($request);
        return $this->notificationRepository->create($notificationData);
    }

    public function sendRequestExpiredNotification($request)
    {
        $notificationData = ExpiredRequest::buildNotificationClose($request);
        return $this->notificationRepository->create($notificationData);
    }
}
