<?php


namespace App\Http\Controllers\Dr\User;
//namespace App\Http\Controllers\Guest;
//use App\Http\Controllers\User\UserRegisterController;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Validator;
use Illuminate\Http\Request;
use App\Http\Services\User as ServiceUser;
use App\Hashe;
use Auth;
class UserLoginController extends Controller {


    public function loginDr(Request $request) {
        $User = array(
            "login" => $request->get("email"),
            "password" => $request->get("password"),
            "if_true" => 1
            
        );
        if ( $request->get('password') == "" ) {
            return Redirect()->route("userDr")->with('errors2','Uzupełnij pole login i hasło');
        }
        /*
        else if (Auth::User()->if_true != 0) {
            return Redirect('/User/Login')->with('error','Uzupełnij pole login i hasło');
        }
         * 
         */
        $bool = false;
        if ($request->get("remember") == "on") {
            $bool = true;
        }
        if (Auth::attempt($User,$bool) ) {
            return Redirect()->route("mainmainDr");
        }
        else {
            return Redirect()->route("userDr")->with('errors2','Nie prawidłowy login lub hasło');
        }
    }
     
}
