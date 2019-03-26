<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $keyType = 'string';
    public $incrementing = false;

    public $fillable = [
        'id',
        'user_id',
        'title',
        'content',
        'status',
        'product_url',
        'ticket_question_id',
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function comments()
    {
        return $this->hasMany('\App\Models\TicketComment');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     **/
    public function images()
    {
        return $this->belongsToMany('\App\Models\Image');
    }

    public function question()
    {
        return $this->belongsTo('\App\Models\TicketQuestion');
    }
}
