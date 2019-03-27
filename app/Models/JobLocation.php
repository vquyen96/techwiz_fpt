<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobLocation extends Model
{
    public $table = 'job_locations';

    public $fillable = [
        'location_id',
        'job_id',
        'id'
    ];

    public function location()
    {
        return $this->belongsTo('App\Models\Location');
    }

    public function job()
    {
        return $this->belongsTo('App\Models\Job');
    }
}
