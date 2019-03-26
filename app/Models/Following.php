<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;

/**
 * Class Following
 * @package App\Models
 * @version October 10, 2018, 9:56 am UTC
 */
class Following extends Model
{
    public $fillable = [
        'user_id',
        'follower_id'
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
