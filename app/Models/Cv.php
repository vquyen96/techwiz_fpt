<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cv extends Model
{
    protected $keyType = 'string';
    public $incrementing = false;

    public $table = 'cvs';

    public $fillable = [
        'id',
        'title',
        'name',
        'tel',
        'email',
        'salary',
        'introduce',
        'skill',
        'experience',
        'user_id',
        'location_id',
        'category_id',
        'status',
        'expired_date',
        'file'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }
    public function location()
    {
        return $this->belongsTo('App\Models\Location');
    }

    public function jobCvs()
    {
        return $this->hasMany('App\Models\JobCv');
    }


}
