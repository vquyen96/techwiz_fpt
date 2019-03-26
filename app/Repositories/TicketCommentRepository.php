<?php

namespace App\Repositories;

use Bosnadev\Repositories\Eloquent\Repository;

class TicketCommentRepository extends Repository
{
    public function model()
    {
        return 'App\Models\TicketComment';
    }

    public function getCommentByTicketId($id)
    {
        return $this->model->where('ticket_id', $id)->get();
    }
}
