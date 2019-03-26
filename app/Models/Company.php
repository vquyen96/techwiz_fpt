<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $keyType = 'string';
    public $incrementing = false;

    public $table = 'companies';

    public $fillable = [
        'id',
        'name',
        'thumbnail',
        'description',
        'user_id'
    ];
}
