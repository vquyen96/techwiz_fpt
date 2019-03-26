<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyCategory extends Model
{
    public $table = 'company_categories';

    public $fillable = [
        'id',
        'company_id	',
        'category_id'
    ];
}
