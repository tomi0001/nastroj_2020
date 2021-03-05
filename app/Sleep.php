<?php
/*
 * copyright 2020 Tomasz Leszczyński tomi0001@gmail.com
 * 
 */
namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
class Sleep extends Model
{
    public static function checkTimeExist($dateStart,$dateEnd) {
        return Sleep::where("date_start","<=",$dateEnd)->where("date_end",">",$dateStart)->where("id_users",Auth::User()->id)->first();
    }
    public static function selectAwek($id) {
        return Sleep::where("id",$id)->where("id_users",Auth::User()->id)->first();
    }
}
