<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Actions_day extends Model
{
    public static function selectAction($idUsers,$date) {
        return self::where("id_users",$idUsers)->where("date",$date)->orderBy("id")->get();
    }
}
