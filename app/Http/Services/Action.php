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
use App\Http\Services\Common as common;
use Auth;

class Action {
    
    public $errors = [];
    public $listActionMood = [];
    public $listActionMoodSeparate = [];
    public $startDay;
    public $dateStart;
    public $dateEnd;
    public $timeTnterval;
    private function setMinutes() {
        $this->timeTnterval = Auth::User()->minutes;
    }
    
    
    private  static function setColorPleasure($color) {
        if ($color <= -16) {
            return 0;
        }
        else if ($color <= -12) {
            return 1;
        }
        else if ($color <= -7) {
            return 2;
        }
        else if ($color <= -4) {
            return 3;
        }
        else if ($color <= -1) {
            return 4;
        }
        else if ($color <= 1) {
            return 5;
        }
        else if ($color <= 5) {
            return 6;
        }
        else if ($color <= 8) {
            return 7;
        }
        else if ($color <= 12) {
            return 8;
        }
        else if ($color <= 16) {
            return 9;
        }
        else if ($color <= 20) {
            return 10;
        }
    }
    
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
            if ($request->get("allDay") == "on") {
                array_push($this->errors,"Musiz uzupełnić czas wzięcia");
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
    
    
    public function checkAddAction(Request $request) {
        //$Action = new Actions_plan;
        if (!empty($request->get("idAction"))) {
            for ($i = 0;$i < count($request->get("idAction"));$i++) {
                if ($this->separateAllDay($request->get("idAction")[$i]) == 1) {
                    if (!empty(Actions_plan::checkTimeExistActionAllDay($request->get("dateStart") . " " . $request->get("timeStart") . ":00", $request->get("dateEnd") . " " . $request->get("timeEnd") . ":00"))
                         ) {
                         array_push($this->errors,"Godziny akcji  nachodza na inne akcje 2");
                     }
                }
                else if (!empty(Actions_plan::checkTimeExistAction($request->get("dateStart") . " " . $request->get("timeStart") . ":00", $request->get("dateEnd") . " " . $request->get("timeEnd") . ":00",$request->get("idAction")[$i]))
                         ){
                         array_push($this->errors,"Godziny akcji  nachodza na inne akcje 1");
                }
                
            }
        }
    }
    
    private function separateAllDay($idAction) {
        //$array = [];
        $Action = new Actions_plan;
        //for ($i=0;$i < count($idAction);$i++) {
        $array = $Action->select("if_all_day")->where("id_actions",$idAction)->first();
        //}
        
        return $array->if_all_day;
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
                    $Actions_plan->date_start = $request->get("dateStart")  .  " ". Auth::User()->start_day . ":00:00";
                    $Actions_plan->date_end = $request->get("dateEnd") . " ".  Auth::User()->start_day . ":00:00";
                }
                if ($request->get("allDay") == "on") {
                    $Actions_plan->if_all_day  = 1;
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
        if (!($request->get("pleasure") >= -20 and $request->get("pleasure") <= 20) or !is_numeric($request->get("pleasure")) ) {
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
    
    public function downloadAction(int $idUsers,$year,$month,$day) {
        $Action = new Actions_plan;
        //print $year;
        $this->initStartDay();
        $this->setHourMood($year,$month,$day);
        $this->listActionMood = $Action->where("id_users",$idUsers)
                                      ->whereRaw("(date_start > '" . $this->dateStart . "' and date_end < '" . $this->dateEnd . "') "
                                              . "or (date_start < '" . $this->dateEnd . "' and date_end > '" . $this->dateStart . "')"
                                              
                                              )
                                        ->get();
    }
    public function separateShare($year,$month,$day) {
        $this->initStartDay();
        $this->setHourMood($year,$month,$day);
        $this->setMinutes();
        
        $start = strtotime($this->dateStart);
        $end = strtotime($this->dateEnd);
        $result = $end - $start;
        $array = [];
        $j = 0;
        $second = ($this->timeTnterval * 60);
        $z = 0;
        
        for ($i = $start;$i <= $end;$i += $second) {
            
            foreach ($this->listActionMood as $list) {
            
                if (strtoTime($list->date_start) > $i  and strToTime($list->date_end) <  $i  + ($second)
                        or (strToTime($list->date_start) < $i  + ($second)) and strToTime($list->date_end) > $i   
                            ) {
                        if ($i == $end) {
                            continue;
                        }


                        if ((($list->if_all_day  == 1 and  !((common::sumMinutesHour(((date("G",strtoTime($list->date_start)))),date("i",strtoTime($list->date_start))) > common::sumMinutesHour((date("G",$i)),date("i",$i)) 
                                and common::sumMinutesHour((date("G",strtoTime($list->date_end))),date("i",strtoTime($list->date_end))) < common::sumMinutesHour(date("G",$i + ($second) ),date("i",$i + ($second))) 
                                or common::sumMinutesHour((date("G",strtoTime($list->date_start))),date("i",(strtoTime($list->date_start)))) < common::sumMinutesHour(date("G",$i + ($second)),date("i",$i + ($second)))) 
                                and common::sumMinutesHour(date("G",strtoTime($list->date_end)),date("i",strtoTime($list->date_end))) > common::sumMinutesHour((date("G",$i  )),date("i",$i))))) and $second != 86400   ) {
                            continue;
                        }
                            $array[$z]["date_start"] = date(" H:i",($i));
       
            
                        if (($i + $second) > $end ) {
                            $array[$z]["date_end"] = date(" H:i",$end);
                        }
                        else {
                            $array[$z]["date_end"] = date("H:i",($i + $second));
                        }
 
                        $arrayAction = ActionApp::selectActions($list->id_actions);
                        $array[$z]["start"] = $list->date_start;
                        $array[$z]["end"] = $list->date_end;
                        $array[$z]["id"] = $list->id;
                        $array[$z]["name"] = $arrayAction->name;
                        $array[$z]["level_pleasure"] = $this->setColorPleasure($arrayAction->level_pleasure);
                        
                        
                        $z++;

                }
                
            }
            $j++;
        }
        
        $this->listActionMoodSeparate  = $array;
    }
    
    private function initStartDay() {
        $this->startDay = Auth::User()->start_day;
        
    }
    private function setHourMood($year,$month,$day,$bool = false) {
        $second = strtotime($year . "-" . $month . "-" . $day . " " . $this->startDay . ":00:00");
        
        $second2 = $second + (3600 * 24);
        if ($bool == false) {
            $this->dateStart = date("Y-m-d H:i:s",$second);
            $this->dateEnd = date("Y-m-d H:i:s",$second2);
        }
        else {
            return [date("Y-m-d H:i:s",$second),date("Y-m-d H:i:s",$second2)];
        }
    }
    
    

}
