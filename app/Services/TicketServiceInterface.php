<?php

namespace App\Services;

interface TicketServiceInterface
{
    public function create($ticketData, $imagesData);
    public function solveTicket($ticketId);
    public function updateTicket($ticketId, $data);
    public function myTicket($perPage, $ticketStatus);
    public function showTicketDetail($id);
    public function allQuestion();
    public function close($id);
}
