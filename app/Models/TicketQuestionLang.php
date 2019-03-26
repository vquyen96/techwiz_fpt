<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketQuestionLang extends Model
{
    public $table = 'ticket_questions_lang';
    
    public $fillable = [
        'ticket_question_id',
        'title',
        'lang'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];
}
