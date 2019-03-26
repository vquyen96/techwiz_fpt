<?php

namespace App\Services;

interface ProductConfirmServiceInterface
{
    public function transferMoney($product);
    public function handleSellingSuccess($productId, $buyerId, $paymentData);
    public function cancelProduct($productId);
}
