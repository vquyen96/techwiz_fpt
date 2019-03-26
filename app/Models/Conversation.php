<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;

class Conversation extends Model
{
    protected $keyType = 'string';
    public $incrementing = false;

    public $fillable = [
        'id',
        'title',
        'description',
        'status',
        'from_user_id',
        'to_user_id'
    ];

    public static $rules = [

    ];

    public function fromUser()
    {
        return $this->belongsTo('\App\Models\User', 'from_user_id');
    }

    public function toUser()
    {
        return $this->belongsTo('\App\Models\User', 'to_user_id');
    }

    public function images()
    {
        return $this->belongsToMany('\App\Models\Image');
    }

    public function privateMessages()
    {
        return $this->hasMany('\App\Models\PrivateMessage');
    }

    public function lastPrivateMessages()
    {
        return $this->hasOne('\App\Models\PrivateMessage')->latest();
    }
}
