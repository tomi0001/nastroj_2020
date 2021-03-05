<?php
/*
 * copyright 2020 Tomasz Leszczyński tomi0001@gmail.com
 * 
 */
namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Auth;
use Spatie\Permission\Traits\HasRoles;
class User extends Authenticatable
{
    
    const ROLE_DOCTOR   = 'doctor';
    const ROLE_USER= 'user';
    use Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'login', 'email', 'password','role',
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
    public function getRole()
    {
        return $this->role;

    }//end getRole()


    public function setRole(string $role)
    {
        $this->role = $role;

    }
    public static function checkExistLevelMood() {
        return User::select("level_mood0")->select("level_mood1")->where("id",Auth::User()->id)->first();
    }
    public static function selectLevelMood() {
        return User::where("id",Auth::User()->id)->first();
    }
}
