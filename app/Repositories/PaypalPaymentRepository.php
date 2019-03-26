<?php

namespace App\Repositories;

use Bosnadev\Repositories\Eloquent\Repository;

class PaypalPaymentRepository extends Repository
{
    public function model()
    {
        return 'App\Models\PaypalPayment';
    }
}
