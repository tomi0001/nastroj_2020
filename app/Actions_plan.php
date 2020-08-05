<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
class Actions_plan extends Model
{
    public static function checkTimeExist($dateStart,$dateEnd) {
        return Actions_plan::where("date_start","<=",$dateEnd)->where("date_end",">=",$dateStart)->where("id_users",Auth::User()->id)->first();
    }

    public static function checkTimeExistActionAllDay($dateStart,$dateEnd) {
        return Actions_plan::where("date_start","<=",$dateEnd)->where("date_end",">=",$dateStart)
                ->where("id_users",Auth::User()->id)->whereRaw("Time(date_start) <= Time('$dateEnd')")->whereRaw("Time(date_end) >= Time('$dateStart')")->first();
    }
    
    public static function checkTimeExistAction($dateStart,$dateEnd,$id) {
        return Actions_plan::where("date_start","<=",$dateEnd)->where("date_end",">=",$dateStart)->where("id_users",Auth::User()->id)->where("id_actions",$id)->first();
    }
}

