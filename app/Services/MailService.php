<?php

namespace App\Services;

use App\Enums\Alerts\Product\Confirm as AlertProductConfirm;
use App\Enums\Alerts\Product\Transfer as AlertProductTransfer;
use App\Enums\Alerts\Payment\Payment as AlertPayment;
use App\Mail\Factory\Product\Confirm as ProductConfirmFactory;
use App\Mail\Factory\Product\Transfer as ProductTransferFactory;
use App\Mail\Factory\Payment\Payment as PaymentFactory;
use App\Mail\Factory\Request\CloseRequest;
use App\Mail\Factory\Request\ExpiredRequest;
use App\Mail\Factory\Request\PrivateMessage;
use App\Mail\Factory\Ticket\Ticket;
use App\Mail\Factory\Auth\VerifyUser;
use App\Mail\Factory\Auth\ResetPassword;
use App\Mail\Factory\Request\Conversation;
use App\Mail\MailTemplate;
use App\Enums\Alerts\Request\Conversation as AlertConversation;
use App\Enums\Notifications\Type as NotificationType;
use Illuminate\Support\Facades\Mail;

class MailService implements MailServiceInterface
{
    public function sendProductTransferEmail($product, $mailingType)
    {
        $mailData = ProductTransferFactory::buildMailData($product, $mailingType);
        $mailInfo = ProductTransferFactory::buildMailInfo($mailingType);
        $mailTemplate = new MailTemplate($mailData, $mailInfo);

        switch ($mailingType) {
            case AlertProductTransfer::TO_BUYER_WITH_BUYER_RECEIVED_TRANSFER:
                Mail::to($product->buyer->user->email)->send($mailTemplate);
                break;
            case AlertProductTransfer::TO_SELLER_WITH_BUYER_RECEIVED_TRANSFER:
                Mail::to($product->user->email)->send($mailTemplate);
                break;
            case AlertProductTransfer::TO_BUYER_WITH_SELLER_CANCEL_TRANSFER:
                Mail::to($product->buyer->user->email)->send($mailTemplate);
                break;
            case AlertProductTransfer::TO_SELLER_WITH_SELLER_CANCEL_TRANSFER:
                Mail::to($product->user->email)->send($mailTemplate);
                break;
            default:
                break;
        }
    }

    public function sendPaymentEmail($product, $paymentData, $mailingType)
    {
        $transferAmount = $paymentData['resource']['amount']['total'] ?? 0;
        $mailData = PaymentFactory::buildMailData($product, $transferAmount, $mailingType);
        $mailInfo = PaymentFactory::buildMailInfo($mailingType);
        $mailTemplate = new MailTemplate($mailData, $mailInfo);
        
        switch ($mailingType) {
            case AlertPayment::TO_BUYER_WITH_BUYER_TRANSFER_MONEY:
            case AlertPayment::TO_BUYER_WITH_RMT_REFUND_MONEY:
                Mail::to($product->buyer->user->email)->send($mailTemplate);
                break;
            case AlertPayment::TO_SELLER_WITH_RMT_TRANSFER_MONEY:
            case AlertPayment::TO_SELLER_WITH_RMT_REFUND_MONEY:
                Mail::to($product->user->email)->send($mailTemplate);
                break;
            default:
                break;
        }
    }

    public function sendVerifyEmail($user)
    {
        $mailData = VerifyUser::buildMailData($user);
        $mailInfo = VerifyUser::buildMailInfo();
        $mailTemplate = new MailTemplate($mailData, $mailInfo);
        Mail::to($user['email'])->send($mailTemplate);
    }

    public function sendResetPassword($user)
    {
        $mailData = ResetPassword::buildMailData($user);
        $mailInfo = ResetPassword::buildMailInfo();
        $mailTemplate = new MailTemplate($mailData, $mailInfo);
        Mail::to($user['email'])->send($mailTemplate);
    }

    public function sendReceivedTicket($user)
    {
        $mailData = Ticket::buildMailData();
        $mailInfo = Ticket::buildMailInfo();
        $mailTemplate = new MailTemplate($mailData, $mailInfo);
        Mail::to($user['email'])->send($mailTemplate);
    }

    public function sendConversationCreate($conversation)
    {
        $toUser = $conversation->toUser;
        $mailingType = AlertConversation::CREATE;
        $mailData = Conversation::buildMailData($conversation);
        $mailInfo = Conversation::buildMailInfo($mailingType);
        $mailTemplate = new MailTemplate($mailData, $mailInfo);
        Mail::to($toUser['email'])->send($mailTemplate);
    }

    public function sendConversationClose($conversation)
    {
        $userFrom = $conversation->fromUser;
        $mailingType = AlertConversation::CLOSE;
        $mailData = Conversation::buildMailData($conversation);
        $mailInfo = Conversation::buildMailInfo($mailingType);
        $mailTemplate = new MailTemplate($mailData, $mailInfo);
        Mail::to($userFrom['email'])->send($mailTemplate);
    }

    public function sendCloseRequest($request)
    {
        $mailData = CloseRequest::buildMailData($request);
        $mailInfo = CloseRequest::buildMailInfo();
        $mailTemplate = new MailTemplate($mailData, $mailInfo);
        Mail::to($request->user->email)->send($mailTemplate);
    }

    public function sendExpiredRequest($request)
    {
        $mailData = ExpiredRequest::buildMailData($request);
        $mailInfo = ExpiredRequest::buildMailInfo();
        $mailTemplate = new MailTemplate($mailData, $mailInfo);
        Mail::to($request->user->email)->send($mailTemplate);
    }

    public function sendPrivateMessageReply($message, $notificationType)
    {
        switch ($notificationType) {
            case NotificationType::BUY:
                $user = $message->conversation->toUser;
                break;
            case NotificationType::SELL:
                $user = $message->conversation->fromUser;
                break;
            default:
                $user = false;
                break;
        }
        if (!$user) {
            return false;
        }
        $mailInfo = PrivateMessage::buildMailInfo();
        $mailData = PrivateMessage::buildMailData($message);

        $mailTemplate = new MailTemplate($mailData, $mailInfo);
        Mail::to($user->email)->send($mailTemplate);
    }
}
