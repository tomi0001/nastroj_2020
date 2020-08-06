<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
class Mood extends Model
{
    public static function checkTimeExist($dateStart,$dateEnd) {
        return Mood::where("date_start","<=",$dateEnd)->where("date_end",">=",$dateStart)->where("id_users",Auth::User()->id)->first();
    }
    public static function differenceDate($idMood) {
        return Mood::selectRaw("((TIME_TO_SEC(timediff(date_end,date_start)))) / 60 as diff ")->selectRaw("date_start as date_start")->selectRaw("date_end as date_end")->where("id",$idMood)->where("id_users",Auth::User()->id)->first();
    }
    
}
