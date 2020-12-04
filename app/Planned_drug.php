<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
class Planned_drug extends Model
{
    public static function showName(int $id) {
        return self::select("name")->where("id_users",Auth::User()->id)->where("id",$id)->first();
    }
}
