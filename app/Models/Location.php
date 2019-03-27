<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    public $table = 'locations';

    public $fillable = [
        'id',
        'title',
        'status'
    ];
}
