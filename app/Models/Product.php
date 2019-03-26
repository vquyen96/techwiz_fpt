<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;

/**
 * Class Product
 * @package App\Models
 * @version October 10, 2018, 10:11 am UTC
 *
 */
class Product extends Model
{
    protected $keyType = 'string';
    public $incrementing = false;

    public $fillable = [
        'id',
        'title',
        'game_id',
        'description',
        'delivery_method',
        'buy_now_price',
        'expired_date',
        'expiration',
        'status',
        'published_date',
        'user_id',
        'view_count'
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
    public function game()
    {
        return $this->belongsTo('\App\Models\Game');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function user()
    {
        return $this->belongsTo('\App\Models\User');
    }

        /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function buyings()
    {
        return $this->hasMany('\App\Models\Buying');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     **/
    public function buyer()
    {
        return $this->hasOne('\App\Models\Buying')
            ->with('user');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function favorites()
    {
        return $this->hasMany('\App\Models\Favorite');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     **/
    public function images()
    {
        return $this->belongsToMany('\App\Models\Image');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function productTransactions()
    {
        return $this->hasMany('\App\Models\ProductTransaction');
    }
}
