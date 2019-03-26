<?php

namespace App\Services;

interface NotificationServiceInterface
{
    public function sendProductTransferNotification($product, $notificationType);
    public function sendPaymentNotification($product, $notificationType);
    public function sendChattingNotification($product, $notificationType);
    public function sendRefundNotification($product);
    public function sendProductClose($product);
    public function getNotification($type, $perPage);
    public function readNotification($id);
    public function sendPrivateMessageNotification($message, $notificationType);
    public function sendConversationCreateNotification($conversation);
    public function sendConversationCloseNotification($conversation);
    public function sendRequestClosedNotification($request);
    public function sendRequestExpiredNotification($request);
}
