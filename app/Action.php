<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
class Action extends Model
{
    public static function selectAction($idUsers = 0) {
        return self::where("id_users",$idUsers)->orwhere("id_users",0)->orderBy("id_users")->orderBy("name")->get();
    }
    public static function IfNameExist($name) {
        return self::where("name",$name)->where("id_users",Auth::User()->id)->first();
    }
    public static function selectActions($idAction) {
        return self::where("id",$idAction)->where("id_users",Auth::User()->id)->first();
    }
}
