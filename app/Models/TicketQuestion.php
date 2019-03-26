<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketQuestion extends Model
{
    
    public $table = 'ticket_questions';
    
    public $fillable = [
        'description'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function questionsLang()
    {
        return $this->hasMany('\App\Models\TicketQuestionLang');
    }
}
