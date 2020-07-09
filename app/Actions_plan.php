<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
class Actions_plan extends Model
{
    public static function checkTimeExist($dateStart,$dateEnd) {
        return Actions_plan::where("date_start","<=",$dateEnd)->where("date_end",">=",$dateStart)->where("id_users",Auth::User()->id)->first();
    }
}
