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
use App\Http\Services\User as ServiceUser;

class SettingController  extends Controller  {
    public function Setting() {
        $Users = new ServiceUser;
        $array = $Users->CheckIfLevelMood();
        return View("User.Setting.index")->with("levelMood",$array);
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
