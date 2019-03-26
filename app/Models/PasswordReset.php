<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;

/**
 * Class PasswordReset
 * @package App\Models
 * @version October 10, 2018, 10:13 am UTC
 */
class PasswordReset extends Model
{
    protected $primaryKey = 'token';
    protected $keyType = 'string';
    public $incrementing = false;

    public $fillable = [
        'expired_date',
        'user_id',
        'token',
        'status'
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
        return $this->belongsTo('\App\Models\User', 'user_id');
    }
}
