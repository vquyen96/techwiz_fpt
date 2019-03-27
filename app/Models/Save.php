<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Save extends Model
{
    protected $keyType = 'string';
    public $incrementing = false;

    public $fillable = [
        'job_id',
        'user_id',
        'status'
    ];

    public function job()
    {
        return $this->belongsTo('App\Models\Job');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
