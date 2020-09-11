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
use App\Http\Services\Action;
use App\Action as ActionApp;
use App\Actions_plan;
use App\Http\Services\User as ServiceUser;

class SettingController  extends Controller  {
    public function Setting() {
        $Users = new ServiceUser;
        $array = $Users->CheckIfLevelMood();
        $actionName = $Users->selectAction();
        $actionDate = $Users->selectActionPlans();
        $Hash = $Users->selectHash();
        return View("User.Setting.index")->with("levelMood",$array)->with("actionName",$actionName)->with("actionDate",$actionDate)->with("hash",$Hash);
    }
    public function SettingupdateHash(Request $request) {
        $Users = new ServiceUser;
        $Users->checkErrorHash($request);
        if (count($Users->errors) > 0) {
            return View("ajax.error")->with("error",$Users->errors);
        }
        else {
            $Users->updateHash($request);
            return View("ajax.succes")->with("succes","Pomyslnie zmodyfikowano hash");
        }
    }
    public function SettingActionAdd(Request $request) {
        $Action = new Action;
        $Action->checkSettingAction($request);
        if (count($Action->errors) != 0) {
            return View("ajax.error")->with("error",$Action->errors);
        }
        else {
            $Action->saveSettingAction($request);
        }
    }
    public function SettingaChangeActionDateName2(Request $request) {
        
        $Action = new Action;
        $Action->checkAddActionDate($request);
        $Action->checkAddActionName($request);
        //$Action->checkAddAction($request);
        //$Action->checkAddMood($request);
        
        if (count($Action->errors) != 0) {
            return View("ajax.error")->with("error",$Action->errors);
            
        }
        else {
            if (!empty($request->get("idAction"))) {
                $id = $Action->updateActions($request);
                return View("ajax.succes")->with("succes","Pomyślnie zmodyfikowano");
                
            }
            
        }
         
         
         
         
         
         
         
         
         
    }

    public function SettingaChangeActionDateName(Request $request) {
        //$actionArray = Actions_plan::selectAction($request->get("actionNameDate"));
        if (!empty($request->get("actionNameDate"))) {
            $actionArray = Actions_plan::selectAction($request->get("actionNameDate"));
            $actionArray2 = ActionApp::selectActionName();
            $array = [];
            $longer  =[];
            //array_push($array,$actionArray);
            //array_push($array,$actionArray);
            //array_push($array,$actionArray);

            //, json_decode(count($actionArray2))
            $array = array_merge(json_decode($actionArray,true),json_decode($actionArray2,true));
            $array2 = array_merge($array,array("count" => count($actionArray2)));
            if ($actionArray->longer == "") {
                $longer["longer"] = "";
            }
            else if ($actionArray->datediff == 0 and $actionArray->longer != "") {
                $longer["longer"] = $actionArray->longer;
                
            }
            else if ($actionArray->datediff == 0) {
                $longer["longer"] = $actionArray->longer;
            }
            else {
                $longer["longer"] = round($actionArray->longer / $actionArray->datediff);
            }
            $array3 = array_merge($array2,$longer);
            print json_encode($array3, true);
        }
        //print json_encode($actionArray);
    }
    public function SettingaChangeActionName2(Request $request) {
        if ($request->get("actionName") == "") {
            return View("ajax.error")->with("error",["Uzupełnij akcje"]);
        }
        else {
            $Users = new ServiceUser;
            $Users->changeNameAction($request);
            return View("ajax.succes")->with("succes","Pomyślnie zmieniono nazwę");
        }
    }
    public function SettingaChangeActionName(Request $request) {
        
        $name = ActionApp::selectNameAction($request->get("actionName"));
        print $name->name;
        //print $request->get("actionName");
        //var_dump($request);
        //$Action->selectNameAction($request->get("id"));
    }
    public function SettingchengeMood(Request $request) {
        $Users = new ServiceUser;
        $Users->CheckIfLevelMoodForm($request);
        if (count($Users->errors) != 0) {
            return View("ajax.error")->with("error",$Users->errors);
        }
        else {
            $Users->updateSettingMood($request);
        }
    }
}
