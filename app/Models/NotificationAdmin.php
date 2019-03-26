<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationAdmin extends Model
{
    public $table = 'notification_admin';

    public $fillable = [
        'target_id',
        'type',
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

    public function target()
    {
        return $this->belongsTo('\App\Models\User');
    }
}
