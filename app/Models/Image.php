<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;

/**
 * Class Image
 * @package App\Models
 * @version October 11, 2018, 2:58 am UTC
 */
class Image extends Model
{
    public $fillable = [
        'thumbnail_bucket',
        'thumbnail_name',
        'thumbnail_url',
        'picture_bucket',
        'picture_url',
        'picture_name',
        'title'
    ];

    protected $hidden = [
        'pivot',
    ];

    public static $rules = [
        
    ];

    public function products()
    {
        return $this->belongsToMany('\App\Models\Product');
    }

    public function requests()
    {
        return $this->belongsToMany('\App\Models\Request');
    }

    public function conversations()
    {
        return $this->belongsToMany('\App\Models\Conversation');
    }

    public function privateMessages()
    {
        return $this->belongsToMany('\App\Models\PrivateMessage');
    }
}
