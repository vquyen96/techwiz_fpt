<?php

namespace App\Services\Admin;

interface MailServiceInterface
{
    public function sendResetPassword($mailData);
    public function sendProductExpired($mailData);
    public function sendRefundForBuyer($mailData);
    public function sendProductClose($mailData);
    public function sendTicketComment($mailData);
    public function sendRemindReceivedProduct($mailData);
    public function sendReceivedProduct($mailData);
    public function sendReceivedTicket($userAuth);
}
