<?php

namespace App\Services;

interface ProductTransferServiceInterface
{
    public function acceptProduct($productId);
    public function cancelProduct($productId);
}
