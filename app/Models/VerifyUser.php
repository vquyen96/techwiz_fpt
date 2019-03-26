<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;

/**
 * Class Product
 * @package App\Models
 * @version November 26, 2018, 10:11 am UTC
 *
 */
class VerifyUser extends Model
{
    public $fillable = [
        'user_id',
        'token'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function user()
    {
        return $this->belongsTo('\App\Models\User', 'user_id');
    }
}
