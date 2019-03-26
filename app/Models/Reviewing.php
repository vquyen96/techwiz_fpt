<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;

/**
 * Class Reviewing
 * @package App\Models
 * @version October 10, 2018, 10:14 am UTC
 */
class Reviewing extends Model
{
    public $fillable = [
        'user_id',
        'product_id',
        'reviewer_id'
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
    public function user()
    {
        return $this->belongsTo('\App\Models\User');
    }
}
