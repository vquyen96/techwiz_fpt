<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    
    protected $keyType = 'string';
    public $incrementing = false;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
        'description',
        'avatar_url',
        'role',
        'tel',
        'verified',
        'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function buyings()
    {
        return $this->hasMany('\App\Models\Buying');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function favorites()
    {
        return $this->hasMany('\App\Models\Favorite');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function reviews()
    {
        return $this->hasMany('\App\Models\Review');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function products()
    {
        return $this->hasMany('\App\Models\Product');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function productTransactions()
    {
        return $this->hasMany('\App\Models\ProductTransaction');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function passwordResets()
    {
        return $this->hasMany('\App\Models\PasswordReset');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function followings()
    {
        return $this->hasMany('\App\Models\Following');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     **/
    public function verifyUser()
    {
        return $this->hasOne('App\Models\VerifyUser');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function notifications()
    {
        return $this->hasMany('\App\Models\Notification');
    }

    /**
     * @return array
     **/
    public function getBasicInfo()
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'description' => $this->description,
            'avatar_url' => $this->avatar_url,
            'role' => $this->role,
            'tel' => $this->tel,
            'user_id' => $this->id,
        ];
    }
}
