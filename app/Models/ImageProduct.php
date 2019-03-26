<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;

/**
 * Class ImageProduct
 * @package App\Models
 * @version October 11, 2018, 2:59 am UTC
 */
class ImageProduct extends Model
{
    public $fillable = [
        'product_id',
        'image_id'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function image()
    {
        return $this->belongsTo('\App\Models\Image');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function product()
    {
        return $this->belongsTo('\App\Models\Product');
    }
}
