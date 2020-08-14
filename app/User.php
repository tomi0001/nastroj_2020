<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Auth;
class User extends Authenticatable
{
    
    const ROLE_DOCTOR   = 'doctor';
    const ROLE_USER= 'user';
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'login', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function checkExistLevelMood() {
        return User::select("level_mood0")->select("level_mood1")->where("id",Auth::User()->id)->first();
    }
    public static function selectLevelMood() {
        return User::where("id",Auth::User()->id)->first();
    }
}
