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
class UserLoginController extends Controller {
    public function index() {
        return View("User.Login.index");
    }
    
    public function __construct()
    {
        $this->middleware('auth');

    }
     
}
