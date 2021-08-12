<?php
/*
 * copyright 2020 Tomasz Leszczyński tomi0001@gmail.com
 * 
 */

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
use Redirect;
use App\Http\Services\User as ServiceUser;
use App\Http\Services\Calendar;
use App\Http\Services\Mood;
use App\Mood as AppMood;
use App\Sleep;
use App\Http\Services\Action;
use App\Action_plan;
use App\Moods_action;
use App\Action as ActionApp;
use App\Http\Services\Common;
use Auth;
class MoodController extends Controller  {
    public function add(Request $request) {
        if (Auth::User()->type == "user") {
            $Mood = new Mood;
            $Mood->checkAddMoodDate($request);
            $Mood->checkAddMood($request);
            if (!empty($request->get("int_"))) {
                $Mood->checkPercentMoodAction($request);
            }
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
    }
    public function changeDay(Request $request) {
        if (Auth::User()->type == "user") {
            $Action = new Action;
                $id = $Action->UpdateActionDay($request);
                return View("ajax.succes")->with("succes","Pomyslnie zmodyfikowany Akcję");
           //print ("<script>document.getElementById('form2').reset() </script>");
        
        }        
    }
    public function edit(Request $request) {
        if (Auth::User()->type == "user") {
            $Mood = new Mood;
            $mood = $Mood->selectMood($request);
            return View("ajax.editMood")->with("list",$mood)->with("i",$request->get("i"));
        }
    }
    
    public function EditAction(Request $request) {
        if (Auth::User()->type == "user") {
            $Mood = new Mood;

                $levelMood = $Mood->checkLevel($request->get("levelMood"),"nastroju");
                $levelAnxiety = $Mood->checkLevel($request->get("levelAnxiety"),"lęku");
                $levelNervousness = $Mood->checkLevel($request->get("levelNervousness"),"zdenerowania");
                $levelStimulation = $Mood->checkLevel($request->get("levelStimulation"),"pobudzenia");
                if (count($Mood->errors) != 0) {
                    return View("ajax.error")->with("error",$Mood->errors);
                }
                else {
                    $Mood->updateMood($request);
                    return View("ajax.succes")->with("succes","Pomyslnie zmodyfikowany nastrój");
                }

        }
    }


    public function Sleepadd(Request $request) {
        if (Auth::User()->type == "user") {
            $Mood = new Mood;
            $Mood->checkAddSleepDate($request);
            //$Mood->checkAddMood($request);
            if (count($Mood->errors) != 0) {
                return View("ajax.error")->with("error",$Mood->errors);
            }
            else {
                $Mood->saveSleep($request);
            }
        }
    }
    public function addActionDay(Request $request) {
        if (Auth::User()->type == "user") {
            $Action = new Action;
            $Action->checkErrorsDayAction($request);
            if (count($Action->errors) != 0) {
                return View("ajax.error")->with("error",$Action->errors);

            }
            $Action->saveActionDay($request);
        }
    }
    public function AddDescription(Request $request) {
        if (Auth::User()->type == "user") {
            $description = AppMood::showDescription($request->get("id"),Auth::User()->id);
            return View("ajax.editDescription")->with("description",$description->what_work)->with("idMood",$request->get("id"));
        }
    }
    
    
    public function EditDescription(Request $request) {
        if (Auth::User()->type == "user") {
            $Mood = new Mood;
            $Mood->updateDescription($request);
            return View("ajax.succes")->with("succes","pomyslnie zmodyfikowano");
        }
    }
    
    
    public function Actionadd(Request $request) {
        if (Auth::User()->type == "user") {
            $Action = new Action;
            $Action->checkAddActionDate($request);
            $Action->checkAddAction($request);
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
    public function SleepEdit(Request $request) {
        if (Auth::User()->type == "user") {
            $awek = Sleep::selectAwek($request->get("id"));
            return View("ajax.editSleep")->with("awek",$awek->how_wake_up)->with("id",$request->get("id"))->with("i",$request->get("i"));
        }
    }
    public function ShowDescription(Request $request) {
        $description = (AppMood::showDescription($request->get("id"),Auth::User()->id));
        return View("ajax.description")->with("description",$description->what_work);
    }
    public function SleepEditAction(Request $request) {
        if (Auth::User()->type == "user") {
            $Mood = new Mood;
            $Mood->IfInt($request->get("sleep")," ilośc wybudzen ");
            if (count($Mood->errors) > 0 ) {
                return View("ajax.error")->with("error",$Mood->errors);
            }
            else {
                $Mood->updateSleep($request);
                return View("ajax.succes")->with("succes","Pomyslnie edytowano");
            }
        }
    }
    
    public function ActionShow(Request $request) {
        
        $Action = new Action;
        $list = $Action->showListActionMood($request,Auth::User()->id);
        return View("ajax.ActionShow")->with("list",$list);
        
         
        
    }
    
    public function changeMinutes($minutes) {
        $User = new ServiceUser;
        $User->setMinutes($minutes);
        return Redirect::back()->with("setAction",true);
    }
    
    
    public function delete(Request $request) {
        if (Auth::User()->type == "user") {
            $Mood = new Mood;
            $Mood->deleteMood($request);
        }
    }
    public function SleepDelete(Request $request) {
        if (Auth::User()->type == "user") {
            $Mood = new Mood;
            $Mood->deleteSleep($request);
        }
    }
    public function ddDeleteAction(Request $request) {
        if (Auth::User()->type == "user") {
            
            $list = ActionApp::selectAction(Auth::id());
            return View("ajax.ActionAddShow")->with("Action",$list)->with("i",$request->get("i"))->with("id",$request->get("id"));
        }
    }
    public function updateActionMoods(Request $request) {
        if (Auth::User()->type == "user") {
            $Action = new Action;
            $Action->updateAddDeleteAction(json_decode($request->get("array")),$request->get("idMood"));
            
            
        }
    }
}
