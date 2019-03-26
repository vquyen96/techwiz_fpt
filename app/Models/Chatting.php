<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;

/**
 * Class Chatting
 * @package App\Models
 * @version January 23, 2019, 9:56 am UTC
 */
class Chatting extends Model
{
    public $fillable = [
        'product_id',
        'user_id',
        'message'
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
    public function product()
    {
        return $this->belongsTo('\App\Models\Product');
    }

    public function user()
    {
        return $this->belongsTo('\App\Models\User');
    }
}
