<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobCv extends Model
{
    public $table = 'job_cvs';

    public $fillable = [
        'job_id',
        'cv_id',
        'status'
    ];

    public function job()
    {
        return $this->belongsTo('App\Models\Job');
    }

    public function cv()
    {
        return $this->belongsTo('App\Models\Cv');
    }
}
