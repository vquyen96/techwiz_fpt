<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyLocation extends Model
{
    public $table = 'company_locations';

    public $fillable = [
        'id',
        'company_id	',
        'location_id'
    ];
}
