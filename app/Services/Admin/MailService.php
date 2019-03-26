<?php

namespace App\Services\Admin;

use Illuminate\Support\Facades\Mail;

class MailService implements MailServiceInterface
{
    public function sendResetPassword($mailData)
    {
        Mail::send(
            'emails.auth.password.reset_admin',
            $mailData,
            function ($message) use ($mailData) {
                $message->to($mailData['email'])->subject('Reset password');
            }
        );
    }

    public function sendProductExpired($mailData)
    {
        Mail::send(
            'emails.product.expired.expired',
            $mailData,
            function ($message) use ($mailData) {
                $message->to($mailData['user']->email)->subject('Your product is expired');
            }
        );
    }

    public function sendRefundForBuyer($mailData)
    {
        Mail::send(
            'emails.payment.refund.to-buyer',
            $mailData,
            function ($message) use ($mailData) {
                $message->to($mailData['user']->email)->subject('Refuned money success');
            }
        );
    }

    public function sendProductClose($mailData)
    {
        Mail::send(
            'emails.product.status.close',
            $mailData,
            function ($message) use ($mailData) {
                $message->to($mailData['user']->email)->subject('Your product is closed');
            }
        );
    }

    public function sendTicketComment($mailData)
    {
        Mail::send(
            'emails.ticket.comment',
            $mailData,
            function ($message) use ($mailData) {
                $message->to($mailData['user']->email)->subject('New ticket comment');
            }
        );
    }

    public function sendRemindReceivedProduct($mailData)
    {
        Mail::send(
            'emails.product.remind.received',
            $mailData,
            function ($message) use ($mailData) {
                $message->to($mailData['user']->email)->subject('Confirm received product');
            }
        );
    }

    public function sendReceivedProduct($mailData)
    {
        Mail::send(
            'emails.product.buyer.received',
            $mailData,
            function ($message) use ($mailData) {
                $message->to($mailData['user']->email)->subject('The product you bought has been received');
            }
        );
    }

    public function sendReceivedTicket($userAuth)
    {
        Mail::send(
            'emails.ticket.confirm_received',
            ['url' => asset('add-ticket')],
            function ($message) use ($userAuth) {
                $message->to($userAuth->email)->subject('The product you bought has been received');
            }
        );
    }
}
