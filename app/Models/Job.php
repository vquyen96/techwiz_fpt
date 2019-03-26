<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $keyType = 'string';
    public $incrementing = false;

    public $table = 'jobs';

    public $fillable = [
        'id',
        'title',
        'benefit',
        'salary',
        'year_experience',
        'description',
        'requirement',
        'keyword',
        'language',
        'rank',
        'expired',
        'expired_date',
        'start_date',
        'company_id',
        'category_id'
    ];

    public function jobCvs()
    {
        return $this->hasMany('\App\Models\JobCv');
    }
}
