<?php

namespace App\Services;

class AlertService implements AlertServiceInterface
{
    private $mailService;
    private $notificationService;

    public function __construct(
        MailServiceInterface $mailService,
        NotificationServiceInterface $notificationService
    ) {
        $this->mailService = $mailService;
        $this->notificationService = $notificationService;
    }

    public function sendProductTransferAlert($product, $alertType)
    {
        $this->mailService->sendProductTransferEmail($product, $alertType);
        $this->notificationService->sendProductTransferNotification($product, $alertType);
    }
    
    public function sendPaymentAlert($product, $paymentData, $alertType)
    {
        $this->mailService->sendPaymentEmail($product, $paymentData, $alertType);
        $this->notificationService->sendPaymentNotification($product, $alertType);
    }
}
