<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;

/**
 * Class GameLang
 * @package App\Models
 * @version January 20, 2019, 9:50 am UTC
 */
class GameLang extends Model
{
    public $table = 'games_lang';
    
    public $fillable = [
        'game_id',
        'title',
        'description',
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
