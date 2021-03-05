<?php
/*
 * copyright 2020 Tomasz Leszczyński tomi0001@gmail.com
 * 
 */
namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
class Planned_drug extends Model
{
    public static function showName(int $id) {
        return self::select("name")->where("id_users",Auth::User()->id)->where("id",$id)->first();
    }
    public static function showPlaned(string $name) {
        return self::where("id_users",Auth::User()->id)->where("name",$name)->get();
    }
}
