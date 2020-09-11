<?php


namespace App\Http\Controllers\Dr\Mood;
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
use App\Sleep;
use App\Http\Services\Action;
use App\Action_plan;
use App\Http\Services\Common;
use Auth;
class MoodController extends Controller  {




    public function ShowDescription(Request $request) {
        $description = (AppMood::showDescription(($request->get("id")),Auth::User()->id_user));
        return View("ajax.description")->with("description",$description->what_work);
    }

    
    public function ActionShow(Request $request) {
        
        $Action = new Action;
        $list = $Action->showListActionMood($request,Auth::User()->id_user);
        return View("ajax.ActionShow")->with("list",$list);
        
         
        
    }
    
    public function changeMinutes($minutes) {
        $User = new ServiceUser;
        $User->setMinutes($minutes);
        return Redirect::back()->with("setAction",true);
    }
    
    


}
