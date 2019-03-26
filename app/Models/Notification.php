<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;

/**
 * Class Product
 * @package App\Models
 * @version November 26, 2018, 10:11 am UTC
 *
 */
class Notification extends Model
{
    public $fillable = [
        'id',
        'title',
        'content',
        'type',
        'user_id',
        'image_url',
        'path',
        'status',
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
