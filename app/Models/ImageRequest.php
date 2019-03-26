<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImageRequest extends Model
{
    public $fillable = [
        'request_id',
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
    public function request()
    {
        return $this->belongsTo('\App\Models\Request');
    }
}
