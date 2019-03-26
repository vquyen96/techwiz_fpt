<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;

/**
 * Class game
 * @package App\Models
 * @version January 20, 2019, 9:50 am UTC
 */
class Game extends Model
{
    public $table = 'games';
    
    public $fillable = [
        'category_id',
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
    public function category()
    {
        return $this->belongsTo('\App\Models\Category');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function gamesLang()
    {
        return $this->hasMany('\App\Models\GameLang');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     **/
    public function image()
    {
        return $this->hasOne('App\Models\Image');
    }
}
