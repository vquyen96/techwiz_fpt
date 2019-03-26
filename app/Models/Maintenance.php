<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;

class Maintenance extends Model
{
    public $fillable = [
        'start_time',
        'end_time',
        'status'
    ];

    public static $rules = [

    ];
}
