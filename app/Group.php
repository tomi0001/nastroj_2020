<?php
/*
 * copyright 2020 Tomasz Leszczyński tomi0001@gmail.com
 * 
 */
namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
class Group extends Model
{
    public static function selectGroupId(int $id) {
        return self::where("id",$id)->where("id_users",Auth::User()->id)->first();
    }
}
