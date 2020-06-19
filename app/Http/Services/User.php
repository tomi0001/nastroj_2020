<?php

namespace App\Http\Services;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Validator;
use Request;
use Hash;
use App\User as User2;
class User {
    public function saveUser() {
        $User = new User2;
        $User->login = Request::get("login");
        $User->email = Request::get("email");
        $User->password = Hash::make(Request::get("password"));
        $User->start_day = Request::get("start_day");
        $User->save();
    }
}
