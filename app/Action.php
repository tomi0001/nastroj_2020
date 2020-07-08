<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    public static function selectAction($idUsers = 0) {
        return self::where("id_users",$idUsers)->orwhere("id_users",0)->get();
    }
}
