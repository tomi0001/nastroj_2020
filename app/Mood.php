<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
class Mood extends Model
{
    public static function checkTimeExist($dateStart,$dateEnd) {
        return Mood::where("date_start","<=",$dateEnd)->where("date_end",">=",$dateStart)->where("id_users",Auth::User()->id)->first();
    }
}
