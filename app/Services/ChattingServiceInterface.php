<?php

namespace App\Services;

interface ChattingServiceInterface
{
    public function list($productId, $perPage, $page);
    public function send($productId, $message);
}
