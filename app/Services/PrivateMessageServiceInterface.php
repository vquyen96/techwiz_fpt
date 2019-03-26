<?php
namespace App\Services;

interface PrivateMessageServiceInterface
{
    public function list($conversationId, $perPage, $page);
    public function send($conversationId, $message, $imagesData);
}
