<?php

namespace App\Services;

use Illuminate\Http\Request;

interface PaypalPaymentServiceInterface
{
    public function savePaypalPayment($jsonData);
    public function handlePaymentSaleCompleted($paymentData);
    public function handlePaymentRefund($productId, $buyerId);
    public function transferToSeller($productId, $buyerId);
    public function isWebHookRequestValidated(Request $request);
}
