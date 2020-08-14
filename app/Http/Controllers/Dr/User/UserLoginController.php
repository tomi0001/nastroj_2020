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
            "login2" => $request->get("email"),
            "password" => $request->get("password"),
            "if_true" => 1
            
        );
        if ( $request->get('password') == "" ) {
            return Redirect('/User/Login')->with('error','Uzupełnij pole login i hasło');
        }
        /*
        else if (Auth::User()->if_true != 0) {
            return Redirect('/User/Login')->with('error','Uzupełnij pole login i hasło');
        }
         * 
         */
        if (Auth::attempt($User) ) {
            return Redirect("/Main");
        }
        else {
            return Redirect('/User/Login')->with('error','Nie prawidłowy login lub hasło');
        }
    }
     
}
