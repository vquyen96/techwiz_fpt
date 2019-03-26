<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;

class PrivateMessage extends Model
{
    protected $keyType = 'string';
    public $incrementing = false;

    public $fillable = [
        'id',
        'conversation_id',
        'user_id',
        'content'
    ];

    public static $rules = [

    ];

    public function conversation()
    {
        return $this->belongsTo('\App\Models\Conversation');
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
