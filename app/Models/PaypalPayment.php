<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaypalPayment extends Model
{
    public $fillable = [
        'event_id',
        'action_type',
        'resource_type',
        'summary',
        'parent_payment',
        'transaction_id',
        'payment_mode',
        'amount_total',
        'currency',
        'state',
        'paid_create_time',
        'transaction_create_time',
        'transaction_clear_time',
        'product_id',
        'user_id',
        'total_fee',
        'total_fee_currency',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];
}
