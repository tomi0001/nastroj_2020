<?php
/*
 * copyright 2020 Tomasz Leszczyński tomi0001@gmail.com
 * 
 */
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
        return self::where("id",$idAction)->first();
    }
    public static function selectNameAction($id) {
        return self::select("name")->where("id",$id)->where("id_users",Auth::User()->id)->first();
    }
    public static function selectActionName() {
        return self::selectRaw("name as name2")->selectRaw("id as id2")->where("id_users",Auth::User()->id)->get();
    }
}
