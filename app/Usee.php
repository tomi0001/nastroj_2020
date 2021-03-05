<?php
/*
 * copyright 2020 Tomasz Leszczyński tomi0001@gmail.com
 * 
 */
namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
class Usee extends Model
{
    public static function IfDrugs($dateStart,$dateEnd,$idUser) {
        return self::where("date",">=",$dateStart)->where("date","<=",$dateEnd)->where("id_users",$idUser)->count();
    }
}
