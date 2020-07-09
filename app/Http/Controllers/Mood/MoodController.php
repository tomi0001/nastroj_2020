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
use App\Http\Services\Action;
use App\Action_plan;
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
            $id = $Mood->saveMood($request);
            if (!empty($request->get("idAction"))) {
                $Mood->saveAction($request,$id);
            }
        }
       //print ("<script>document.getElementById('form2').reset() </script>");
        
       
    }
    public function Actionadd(Request $request) {
        $Action = new Action;
        $Action->checkAddActionDate($request);
        //$Action->checkAddMood($request);
        if (count($Action->errors) != 0) {
            return View("ajax.error")->with("error",$Action->errors);
            
        }
        else {
            if (!empty($request->get("idAction"))) {
                $id = $Action->saveAction($request);
            }
            
        }
        
    }
}
