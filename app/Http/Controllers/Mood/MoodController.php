<?php


namespace App\Http\Controllers\Mood;
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
use App\Http\Services\Calendar;
use App\Http\Services\Mood;
use App\Action;
use Auth;
class MoodController extends Controller  {
    public function add(Request $request) {
        $Mood = new Mood;
        $Mood->checkAddMoodDate($request);
        $Mood->checkAddMood($request);
        if (count($Mood->errors) != 0) {
            return View("ajax.error")->with("error",$Mood->errors);
        }
        else {
            $Mood->saveMood($request);
        }
       //print ("<script>document.getElementById('form2').reset() </script>");
        
       
    }
}
