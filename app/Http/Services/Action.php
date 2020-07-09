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
    public function checkAddActionDate(Request $request) {
        $bool = 4;
        if (!(($request->get("timeStart") or $request->get("timeEnd")) xor $request->get("long") != "")) {
            array_push($this->errors,"Musisz się zdecydować czy chcesz mieć godzine zaczęcia akcji czy długośc akcji");
        }
        if (empty($request->get("idAction"))) {
            array_push($this->errors,"Musisz uzupełnić akcje");
        }
        if ($request->get("long") == "") {
            if ($request->get("dateStart") == "") {
                array_push($this->errors,"Uzupełnij datę zaczęcia");
                $bool--;
            }
            if ($request->get("dateEnd") == "" ) {
                array_push($this->errors,"Uzupełnij datę zakończenia");
                $bool--;
            }
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
            if (!empty(Actions_plan::checkTimeExist($request->get("dateStart") . " " . $request->get("timeStart") . ":00", $request->get("dateEnd") . " " . $request->get("timeEnd") . ":00"))) {
                array_push($this->errors,"Godziny Akcji  nachodza na inne akcje");
            }
        }
        else {
            if ($request->get("long") == 0) {
                array_push($this->errors,"Czas nie może być równy 0");
            }
        }
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
                else {
                    $Actions_plan->long = $request->get("long");
                }
                $Actions_plan->save();
            }
        }
    }
    private function checkTimeExist($dateStart,$dateEnd) {
        
    }
}
