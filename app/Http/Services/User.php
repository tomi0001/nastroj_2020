<?php
/*
 * copyright 2020 Tomasz Leszczyński tomi0001@gmail.com
 * 
 */
namespace App\Http\Services;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Hash;
use Auth;
use App\User as User2;
use App\Action;
use App\Actions_plan;
use App\Product;
use App\Http\Services\Mood;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\Mail;
class User {
    public $errors = [];
    public function saveUser(Request $request) {
        $User = new User2;
        $User->login = $request->get("login");
        $User->email = $request->get("email");
        $User->password = Hash::make($request->get("password"));
        $User->start_day = $request->get("start_day");
        $User->save();
    }
    public function selectHash() {
        $User = new User2;
        $hash = $User->where("id_user",Auth::User()->id)->first();
        return $hash;
    }
    public function updateHash(Request $request) {
        $User2 = new User2;
        $count = $User2->where("id_user",Auth::User()->id)->count();
        if ($count == 0) {
            $this->addHash($request);
        }
        else {
            $this->updateHash2($request);
        }
    }
    
    private function updateHash2(Request $request) {
        $bool = 0;
        if ($request->get("ifTrue") == "on") {
            $bool = 1;
        }
        else {
            $bool = 0;
        }
        if ($request->get("hash") == "") {
            $User2 = new User2;
            $User2->where("id_user",Auth::User()->id)->update(["login" => $request->get("login"),"if_true"=>$bool,"start_day" => Auth::User()->start_day]);
        }
        else {
            $hash = Hash::make($request->get("hash"));
            $User2 = new User2;
            $User2->where("id_user",Auth::User()->id)->update(["login" => $request->get("login"),"if_true"=>$bool,"password" => $hash,"start_day" => Auth::User()->start_day]);
        }
    }
    private function addHash(Request $request) {
        $User2 = new User2;
        $User2->id_user = Auth::User()->id;
        $User2->login = $request->get("login");
        $User2->start_day = Auth::User()->start_day;
        $User2->email = " ";
        $User2->type = "doctor";
        if ($request->get("ifTrue") == "on") {
            $User2->if_true = 1;
        }
        else {
            $User2->if_true = 0;
        }
        $User2->password = Hash::make($request->get("hash"));
        $User2->save();

        
    }
    public function checkErrorHash(Request $request) {
        if ($request->get("hash") != "" and strlen($request->get("hash")) != 10) {
            array_push($this->errors,"Hash musi mieć 10 znaków długości");
        }
        if ($request->get("login") == "") {
            array_push($this->errors,"Login nie może być pusty");
        }
        $User2 = new User2;
        $count = $User2->where("login",$request->get("login"))->where("id_user","!=",Auth::User()->id)->count();
        $count2 = $User2->where("id_user",Auth::User()->id)->count();
        if ($count > 0) {
            array_push($this->errors,"Już jest podany login wybierz inny");
        }
        if ($request->get("hash") == "" and $count2 == 0) {
            array_push($this->errors,"Musisz uzupełnić hash");
        }
        
    }
    public function selectActionPlans() {
        $Action = new Actions_plan;
        $list = $Action->selectRaw("LEFT(actions.name,15) as name")->selectRaw("actions_plans.created_at as created_at")->selectRaw("actions_plans.id as id")->selectRaw("actions_plans.date_start as date_start")
                ->join("actions","actions.id","actions_plans.id_actions")->where("actions.id_users",Auth::User()->id)->orderBy("actions_plans.created_at","DESC")->get();
        return $list;
    }
    public function changeNameAction(Request $request) {
        $Action = new Action;
        $Action->where("id",$request->get("actionName"))->update(["name" => $request->get("nameActionChange")]);
    }
    public function setMinutes($minutes) {
        $User = new User2;
        $User->where("id",Auth::User()->id)->update(["minutes" => $minutes]);
    }
    public function selectAction() {
        $Action = new Action;
        return $Action->where("id_users",Auth::User()->id)->get();
    }
    public function CheckIfLevelMood() {
        $Mood = new Mood;
        $check = User2::checkExistLevelMood();
        $array = User2::selectLevelMood();

        if ($check->level_mood0 == 0 and $check->level_mood1 == 0) {
            return $Mood->levelMood;
        }
        else {
            //$array = User2::checkExistLevelMood();
            
            return [
                        0 =>  ["from" => $array->level_mood_10 , "to" => $array->level_mood_10_to],
                        1 =>  ["from" => $array->level_mood_9 , "to" => $array->level_mood_9_to],
                        2 =>  ["from" => $array->level_mood_8 , "to" => $array->level_mood_8_to],
                        3 =>  ["from" => $array->level_mood_7 , "to" => $array->level_mood_7_to],
                        4 =>  ["from" => $array->level_mood_6 , "to" => $array->level_mood_6_to],
                        5 =>  ["from" => $array->level_mood_5 , "to" => $array->level_mood_5_to],
                        6 =>  ["from" => $array->level_mood_4 , "to" => $array->level_mood_4_to],
                        7 =>  ["from" => $array->level_mood_3 , "to" => $array->level_mood_3_to],
                        8 =>  ["from" => $array->level_mood_2 , "to" => $array->level_mood_2_to],
                        9 =>  ["from" => $array->level_mood_1 , "to" => $array->level_mood_1_to],
                        10 =>  ["from" => $array->level_mood0 , "to" => $array->level_mood0_to],
                        11 =>  ["from" => $array->level_mood1 , "to" => $array->level_mood1_to],
                        12 =>  ["from" => $array->level_mood2 , "to" => $array->level_mood2_to],
                        13 =>  ["from" => $array->level_mood3 , "to" => $array->level_mood3_to],
                        14 =>  ["from" => $array->level_mood4 , "to" => $array->level_mood4_to],
                        15 =>  ["from" => $array->level_mood5 , "to" => $array->level_mood5_to],
                        16 =>  ["from" => $array->level_mood6 , "to" => $array->level_mood6_to],
                        17 =>  ["from" => $array->level_mood7 , "to" => $array->level_mood7_to],
                        18 =>  ["from" => $array->level_mood8 , "to" => $array->level_mood8_to],
                        19 =>  ["from" => $array->level_mood9 , "to" => $array->level_mood9_to],
                        20 =>  ["from" => $array->level_mood10 , "to" => $array->level_mood10_to],
            ];
             
        }
        
    }
    public function CheckIfLevelMoodForm(Request $request) {
        
        for ($i = -10;$i <= 10;$i++) {
            if ($request->get("valueMood" . $i . "From") == "") {
                array_push($this->errors,"Formularz o numerze "  . ($i + 11) . " 'Od' musi być uzpełniony");
            }
            if ($request->get("valueMood" . $i . "To") == "") {
                array_push($this->errors,"Formularz o numerze " . ($i + 11) . " 'Do' musi być uzpełniony");
            }
            if (!is_numeric($request->get("valueMood" . $i . "From") ) or $request->get("valueMood" . $i . "From") < -20 or $request->get("valueMood" . $i . "From") > 20) {
                array_push($this->errors,"Formularz o numerze "  . ($i + 11) . " 'Od' być w zakresie od -20 do +20");
            }
            if (!is_numeric($request->get("valueMood" . $i . "To") ) or $request->get("valueMood" . $i . "To") < -20 or $request->get("valueMood" . $i . "To") > 20) {
                array_push($this->errors,"Formularz o numerze "  . ($i + 11) . " 'Do' być w zakresie od -20 do +20");
            }
            
            else if ($request->get("valueMood" . $i . "To") <= $request->get("valueMood" . $i . "From")) {
                array_push($this->errors,"Formularz o numerze "  . ($i + 11) . " 'Od' Jest większy bądź równy od Formularza 'Do' o numerze " .  ($i + 11));
            }
            if ($i > -10 and $request->get("valueMood" . ($i -1). "To") != $request->get("valueMood" . ($i) . "From")) {
                array_push($this->errors,"Formularz o numerze "  . ($i + 11) . " 'Od' Jest mniejszy  od Formularza 'Do' o numerze " .  (($i + 11) -1));
            }
        }
        
 
    }
    public function updateSettingMood(Request $request) {
        $User = new User2;
        $User->where("id",Auth::User()->id)->update([
            "level_mood_10" => $request->get("valueMood-10From"),
            "level_mood_9" => $request->get("valueMood-9From"),
            "level_mood_8" => $request->get("valueMood-8From"),
            "level_mood_7" => $request->get("valueMood-7From"),
            "level_mood_6" => $request->get("valueMood-6From"),
            "level_mood_5" => $request->get("valueMood-5From"),
            "level_mood_4" => $request->get("valueMood-4From"),
            "level_mood_3" => $request->get("valueMood-3From"),
            "level_mood_2" => $request->get("valueMood-2From"),
            "level_mood_1" => $request->get("valueMood-1From"),
            "level_mood0" => $request->get("valueMood0From"),
            "level_mood1" => $request->get("valueMood1From"),
            "level_mood2" => $request->get("valueMood2From"),
            "level_mood3" => $request->get("valueMood3From"),
            "level_mood4" => $request->get("valueMood4From"),
            "level_mood5" => $request->get("valueMood5From"),
            "level_mood6" => $request->get("valueMood6From"),
            "level_mood7" => $request->get("valueMood7From"),
            "level_mood8" => $request->get("valueMood8From"),
            "level_mood9" => $request->get("valueMood9From"),
            "level_mood10" => $request->get("valueMood10From"),
            "level_mood_10_to" => $request->get("valueMood-10To"),
            "level_mood_9_to" => $request->get("valueMood-9To"),
            "level_mood_8_to" => $request->get("valueMood-8To"),
            "level_mood_7_to" => $request->get("valueMood-7To"),
            "level_mood_6_to" => $request->get("valueMood-6To"),
            "level_mood_5_to" => $request->get("valueMood-5To"),
            "level_mood_4_to" => $request->get("valueMood-4To"),
            "level_mood_3_to" => $request->get("valueMood-3To"),
            "level_mood_2_to" => $request->get("valueMood-2To"),
            "level_mood_1_to" => $request->get("valueMood-1To"),
            "level_mood0_to" => $request->get("valueMood0To"),
            "level_mood1_to" => $request->get("valueMood1To"),
            "level_mood2_to" => $request->get("valueMood2To"),
            "level_mood3_to" => $request->get("valueMood3To"),
            "level_mood4_to" => $request->get("valueMood4To"),
            "level_mood5_to" => $request->get("valueMood5To"),
            "level_mood6_to" => $request->get("valueMood6To"),
            "level_mood7_to" => $request->get("valueMood7To"),
            "level_mood8_to" => $request->get("valueMood8To"),
            "level_mood9_to" => $request->get("valueMood9To"),
            "level_mood10_to" => $request->get("valueMood10To")
            
            
            
        ]);
 
        
    }
    public function checkEmail(Request $request) {
        $User = new User2;
        $bool = $User->where("email",$request->get("email"))->first();
        if (empty($bool)) {
            array_push($this->errors,"Nie ma takiego adresu email");
        }
    }
    public function sendMail(Request $request) {
        $uuid1 = Uuid::uuid4(); 
        $User = new User2;
        $User->where("email",$request->get("email"))->update(["hash"=> $uuid1]);
      $data = array(
        'email' => "tomi@www.d",
        'subject' => 'resetowanie hasła',
        'link' => route("user.passwordConfirm",$uuid1),
      );
      Mail::send('emails.reset', $data, function($message) use($data,$request) {
            $message->to($request->get("email"));
            $message->from("tomi@www.d");
            $message->subject($data['subject']);
      });
                
       return true;
    }
    public function selectHashes($hash) {
        $User = new User2;
        $select = $User->where("hash",$hash)->first();
        if (empty($select)) {
            array_push($this->errors,"Nie można nadać nowego hasła");
        }
        else {
            return $select;
        }
        
    }
    public function checkErrors(Request $request) {
        $this->errors = Validator::make(
            $request->all(),
            ['password' => 'required',
             'password' => 'min:6',
             'password2' => 'required_with:password|same:password|min:6'
        ]
    
        );
                
        if ($this->errors->fails()) {
            
            return false;
        }
        else {
            $this->updatePassword($request);
            return true;
            
            
        }
    }
    private function updatePassword(Request $request) {
        $User = new User2;
        $User->where("hash",$request->get("hash"))->update(["password" => Hash::make($request->get("password")),"hash" => ""]);
    }
    


}
