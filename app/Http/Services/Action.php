<?php

namespace App\Http\Services;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use App\Action as ActionApp;
use App\Actions_plan;
use App\Moods_action;
use Auth;

class Action {
    
    public $errors = [];
    public $listActionMood = [];
    public function checkAddActionDate(Request $request) {
        $bool = 4;
        
        if ((!($request->get("dateStart") or $request->get("dateEnd")) and $request->get("long") == "")) {
            array_push($this->errors,"Musisz uzupełnić czas lub długośc");
        }
        
        if (empty($request->get("idAction"))) {
            array_push($this->errors,"Musisz uzupełnić akcje");
        }
        if ($request->get("dateStart") == "") {
                array_push($this->errors,"Uzupełnij datę zaczęcia");
                $bool--;
        }
        if ($request->get("dateEnd") == "" ) {
                array_push($this->errors,"Uzupełnij datę zakończenia");
                $bool--;
        }
        if (($request->get("timeStart") and $request->get("timeEnd"))) {

            if ($request->get("timeStart") == "") {
                array_push($this->errors,"Uzupełnij czas zaczęcia");
                $bool--;
            }
            if ($request->get("timeEnd") == "" ) {
                array_push($this->errors,"Uzupełnij czas zakończenia");
                $bool--;
            }
            if (StrToTime( date("Y-m-d H:i:s") ) > strtotime($request->get("dateStart") . " " . $request->get("timeStart") . ":00")) {
                array_push($this->errors,"Data zaczęcia nastroju jest mniejsza od teraźniejszej daty");
            }
            if ($bool == 4 and strtotime($request->get("dateStart") . " " . $request->get("timeStart") . ":00") >= strtotime($request->get("dateEnd") . " " . $request->get("timeEnd") . ":00")) {
                
               array_push($this->errors,"Godzina zaczęcia jest wieksza bądź równa godzinie skończenia");
            }
            
        
            else if ((strtotime($request->get("dateEnd") . " " . $request->get("timeEnd") . ":00") - strtotime($request->get("dateStart") . " " . $request->get("timeStart") . ":00")) <  ($request->get("long") * 60)) {
                array_push($this->errors,"Ilośc minut w długośc trwania akcji jest większa od przedziału datowego");
            }

            /*
            if (!empty(Actions_plan::checkTimeExist($request->get("dateStart") . " " . $request->get("timeStart") . ":00", $request->get("dateEnd") . " " . $request->get("timeEnd") . ":00"))) {
                array_push($this->errors,"Godziny Akcji  nachodza na inne akcje");
            }
             * 
             */
        }
        else {
            if ($bool == 4 and strtotime($request->get("dateStart") . " " . "00:00:00") >= strtotime($request->get("dateEnd") . " " .  "00:00:00")) {        
                   array_push($this->errors,"Godzina zaczęcia jest wieksza bądź równa godzinie skończenia");
            }
            if (((strtotime($request->get("dateEnd") . " " .  "00:00:00") - strtotime($request->get("dateStart") . " " . "00:00:00")) <  ($request->get("long") * 60))) {
                array_push($this->errors,"Ilośc s minut w długośc trwania akcji jest większa od przedziału datowego");
            }
        }
        //else {
            if ($request->get("long") == "" and !($request->get("dateStart") and $request->get("dateEnd"))) {
                array_push($this->errors,"Jeżeli chcesz, żeby tylko czas musisz chociaż uzupełnić date startu i end");
            }
        //}
        /*
       
         * 
         */

    }
    public function checkAddMood(Request $request) {
        if ($request->get("moodLevel") != "" and $request->get("moodLevel") < -20 or $request->get("moodLevel") > 20) {
            array_push($this->errors,"Nastroj musi mieścić się w zakresie od -20 do +20");
        }
        
        if ($request->get("anxietyLevel") != "" and $request->get("anxietyLevel") < -20 or $request->get("anxietyLevel") > 20) {
            array_push($this->errors,"Lęk musi mieścić się w zakresie od -20 do +20");
        }
        
        if ($request->get("voltageLevel") != "" and $request->get("voltageLevel") < -20 or $request->get("voltageLevel") > 20) {
            array_push($this->errors,"Napięcie musi mieścić się w zakresie od -20 do +20");
        }
        
        if ($request->get("stimulationLevel") != "" and $request->get("stimulationLevel") < -20 or $request->get("stimulationLevel") > 20) {
            array_push($this->errors,"Pobudzenie musi mieścić się w zakresie od -20 do +20");
        }
        
        if (($request->get("epizodesPsychotic") != "" and $request->get("epizodesPsychotic") < 0)  ) {
            array_push($this->errors,"Liczba Epizodów psychotycznych musi być wieksza lub równa 0");
        }
        //array_push($this->errors,  (int) $request->get("epizodesPsychotic"));
    }
    
   
    public function saveAction(Request $request) {
        for ($i = 0;$i < count($request->get("idAction"));$i++) {
            if ($request->get("idAction")[$i] != "") {
                $Actions_plan = new Actions_plan;
                $Actions_plan->id_users = Auth::User()->id;
                $Actions_plan->id_actions = $request->get("idAction")[$i];
                if ($request->get("timeStart") != "") {
                    $Actions_plan->date_start = $request->get("dateStart") . " " . $request->get("timeStart") . ":00";
                    $Actions_plan->date_end = $request->get("dateEnd") . " " . $request->get("timeEnd") . ":00";
                }
                else if ($request->get("timeStart") == "") {
                    $Actions_plan->date_start = $request->get("dateStart");
                    $Actions_plan->date_end = $request->get("dateEnd");
                }
                if ($request->get("long") != "") {
                    $Actions_plan->long = $request->get("long");
                }
                $Actions_plan->save();
            }
        }
    }
    public function checkSettingAction(Request $request) {
        if ($request->get("name") == "") {
             array_push($this->errors,"Uzupełnij pole nazwa");
        }
        if (!($request->get("pleasure") > -20 and $request->get("pleasure") < 20) or !is_numeric($request->get("pleasure")) ) {
            array_push($this->errors,"Poziom przyjemności musi być w graniach od -20 do +20");
        }
        if (!empty(ActionApp::IfNameExist($request->get("name")))) {
            array_push($this->errors,"Już jest taka akcje o takiej nazwie");
        }
    }
    public function saveSettingAction(Request $request) {
        $Action = new ActionApp;
        $Action->name = $request->get("name");
        $Action->id_users = Auth::User()->id;
        $Action->level_pleasure = $request->get("pleasure");
        $Action->save();
    }
    
    public function downloadAction(int $idUsers,$dateStart,$dateEnd) {
        $Action = new Actions_plan;
        $this->listActionMood = $Action->where("id_users",$idUsers)
//                /timeDIFF(date,'$new_date') <= '" . $time . 
                                       //->whereRaw("dateDIFF(date_start,'$dateStart') >= '$dateStart'")
                                       //->whereRaw("dateDIFF(date_end, '$dateEnd') <= '$dateEnd'")
                                      ->whereRaw("(date_start >= '$dateStart' and date_end < '$dateEnd') or (date_start < '$dateEnd' and date_end >= '$dateStart')")
                                       //->where("date_start",">=",$dateStart)
                                       //->where("date_end","<=",$dateEnd)
                                        ->get();
    }
}
