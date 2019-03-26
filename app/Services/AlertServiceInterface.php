<?php

namespace App\Services;

interface AlertServiceInterface
{
    public function sendProductTransferAlert($product, $alertType);
    public function sendPaymentAlert($product, $paymentData, $alertType);
}
