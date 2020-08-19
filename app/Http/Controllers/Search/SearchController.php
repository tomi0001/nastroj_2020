<?php


namespace App\Http\Controllers\Search;
//namespace App\Http\Controllers\Guest;
//use App\Http\Controllers\User\UserRegisterController;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Validator;
use Illuminate\Http\Request;
use Redirect;
use App\Http\Services\User as ServiceUser;
use App\Http\Services\Calendar;
use App\Http\Services\Mood;
use App\Mood as AppMood;
use App\Http\Services\Action;
use App\Action_plan;
use Auth;
class SearchController extends Controller  {

    public function main() {
        return View("Search.main");
    }
    public function mainAction(Request $request) {
        
        dd($request->get("descriptions"));
    }
}
