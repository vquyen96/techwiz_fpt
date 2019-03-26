<?php

namespace App\Repositories;

use Bosnadev\Repositories\Eloquent\Repository;

class ImageTicketRepository extends Repository
{
    public function model()
    {
        return 'App\Models\ImageTicket';
    }
}
