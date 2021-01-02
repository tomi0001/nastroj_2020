<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
class Product extends Model
{
    public static function loadTypePortion(int $id) {
        return self::select("type_of_portion")->where("id_users",Auth::User()->id)->where("id",$id)->first();
    }
    public static function loadNameProducts(int $id) {
        return self::selectRaw("name as name")->selectRaw("id as id")->where("id_users",Auth::User()->id)->where("id",$id)->first();
    }
    public static function loadAllProducts() {
        return self::selectRaw("name as name")->selectRaw("id as id")->where("id_users",Auth::User()->id)->get();
    }
}
