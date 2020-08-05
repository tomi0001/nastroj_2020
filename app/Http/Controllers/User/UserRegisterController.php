<?php


namespace App\Http\Controllers\User;
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
class UserRegisterController extends Controller {
    public function index() {
        return View("User.Register.index");
    }
    public function store(Request $request) {
        $validator = Validator::make(
            $request->all(),
            ['password' => 'required',
             'password' => 'min:6',
             'password_confirm' => 'required_with:password|same:password|min:6',
             'start_day' => 'integer|min:0|integer|max:23',
             'login' => 'unique:users',
             'email' => 'unique:users']
    
        );
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->messages());
        }
        else {
            $User = new ServiceUser;
            $User->saveUser($request);
            return redirect()->route('login')->withSuccess("Rejestracja zakończona możesz się zalogować");
        }
    }
}
