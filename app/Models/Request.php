<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;

class Request extends Model
{
    protected $keyType = 'string';
    public $incrementing = false;

    public $fillable = [
        'id',
        'title',
        'game_id',
        'description',
        'min_price',
        'max_price',
        'expired_date',
        'status',
        'user_id'
    ];

    public static $rules = [

    ];

    public function game()
    {
        return $this->belongsTo('\App\Models\Game');
    }

    public function user()
    {
        return $this->belongsTo('\App\Models\User');
    }

    public function images()
    {
        return $this->belongsToMany('\App\Models\Image');
    }
}
