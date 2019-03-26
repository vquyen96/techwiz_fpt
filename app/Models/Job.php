<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    public $table = 'jobs';

    public $fillable = [
        'title',
        'benefit',
        'description',
        'requirement',
        'keyword',
        'language',
        'rank',
        'view',
        'type',
        'status',
        'expired',
        'expired_date',
        'start_date',
        'company_id',
        'category_id'
    ];
}
