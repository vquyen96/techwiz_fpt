<?php
namespace App\Services;

interface TicketCommentServiceInterface
{
    public function comment($commentData, $imagesData);
}
