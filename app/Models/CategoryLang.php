<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;

/**
 * Class CategoryLang
 * @package App\Models
 * @version October 10, 2018, 9:50 am UTC
 */
class CategoryLang extends Model
{
    public $table = 'categories_lang';
    
    public $fillable = [
        'category_id',
        'title',
        'description',
        'lang'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];
}
