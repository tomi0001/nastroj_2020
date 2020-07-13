<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
class Sleep extends Model
{
    public static function checkTimeExist($dateStart,$dateEnd) {
        return Sleep::where("date_start","<=",$dateEnd)->where("date_end",">=",$dateStart)->where("id_users",Auth::User()->id)->first();
    }
}
