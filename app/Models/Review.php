<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;
use App\Enums\Review\EmotionalType;

/**
 * Class Review
 * @package App\Models
 * @version October 10, 2018, 10:14 am UTC
 */
class Review extends Model
{
    public $fillable = [
        'user_id',
        'rating',
        'content',
        'reviewer_id'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    protected $appends = ['emotion'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function user()
    {
        return $this->belongsTo('\App\Models\User');
    }

    public function getEmotionAttribute()
    {
        return EmotionalType::fromReviewPoint($this->rating);
    }
}
