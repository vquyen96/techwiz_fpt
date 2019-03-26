<?php

namespace App\Services;

interface MailServiceInterface
{
    public function sendProductTransferEmail($product, $mailingType);
    public function sendPaymentEmail($product, $paymentData, $mailingType);
    public function sendVerifyEmail($user);
    public function sendReceivedTicket($user);
    public function sendConversationCreate($conversation);
    public function sendConversationClose($conversation);
    public function sendCloseRequest($request);
    public function sendExpiredRequest($request);
    public function sendPrivateMessageReply($message, $notificationType);
}
