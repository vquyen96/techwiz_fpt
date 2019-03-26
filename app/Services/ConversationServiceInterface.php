<?php
namespace App\Services;

interface ConversationServiceInterface
{
    public function indexFromUser($perPage, $page);
    public function indexToUser($perPage, $page);
    public function create($data, $dataMessages, $imageData);
    public function close($id);
}
