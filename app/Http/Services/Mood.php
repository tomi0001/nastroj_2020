<?php

namespace App\Http\Services;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use App\Action;
use App\Mood as AppMood;
use App\Moods_action;
use Auth;

class Mood {
    
    public $errors = [];
    public function checkAddMoodDate(Request $request) {
        $bool = 4;
        if ($request->get("dateStart") == "") {
            array_push($this->errors,"Uzupełnij datę zaczęcia");
            $bool--;
        }
        if ($request->get("dateEnd") == "") {
            array_push($this->errors,"Uzupełnij datę zakończenia");
            $bool--;
        }
        if ($request->get("timeStart") == "") {
            array_push($this->errors,"Uzupełnij czas zaczęcia");
            $bool--;
        }
        if ($request->get("timeEnd") == "") {
            array_push($this->errors,"Uzupełnij czas zakończenia");
            $bool--;
        }
        if (StrToTime( date("Y-m-d H:i:s") ) < strtotime($request->get("dateEnd") . " " . $request->get("timeEnd") . ":00")) {
            array_push($this->errors,"Data skończenia nastroju jest wieksza od teraźniejszej daty");
        }
        if (  (strtotime($request->get("dateEnd") . " " . $request->get("timeEnd") . ":00") - strtotime($request->get("dateStart") . " " . $request->get("timeStart") . ":00")) > 72000) {
            array_push($this->errors,"Nastroj nie może mieć takiego dużego przedziału czasowego");
        }
        if (!empty(AppMood::checkTimeExist($request->get("dateStart") . " " . $request->get("timeStart") . ":00", $request->get("dateEnd") . " " . $request->get("timeEnd") . ":00"))) {
            array_push($this->errors,"Godziny nastroju  nachodza na inne nastroje");
        }
        if ($bool == 4 and strtotime($request->get("dateStart") . " " . $request->get("timeStart") . ":00") >= strtotime($request->get("dateEnd") . " " . $request->get("timeEnd") . ":00")) {
            array_push($this->errors,"Godzina zaczęcia jest wieksza bądź równa godzinie skończenia");
        }
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
    
    public function saveMood(Request $request) :int {
        $Mood = new AppMood;
        $Mood->date_start = $request->get("dateStart") . " " . $request->get("timeStart") . ":00";
        $Mood->date_end = $request->get("dateEnd") . " " . $request->get("timeEnd") . ":00";
        if ($request->get("moodLevel") != "") {
            $Mood->level_mood = $request->get("moodLevel");
        }
        if ($request->get("anxietyLevel") != "") {
            $Mood->level_anxiety = $request->get("anxietyLevel");
        }
        if ($request->get("voltageLevel") != "") {
            $Mood->level_nervousness = $request->get("voltageLevel");
        }
        if ($request->get("stimulationLevel") != "") {
            $Mood->level_stimulation = $request->get("stimulationLevel");
        }
        if ($request->get("epizodesPsychotic") != "") {
            $Mood->epizodes_psychotik = $request->get("epizodesPsychotic");
        }
        $Mood->what_work = $request->get("whatWork");
        $Mood->id_users = Auth::User()->id;
        $Mood->save();
        return $Mood->id;
    }
    public function saveAction(Request $request,int $idMood) {
        for ($i = 0;$i < count($request->get("idAction"));$i++) {
            if ($request->get("idAction")[$i] != "") {
                $Moods_action = new Moods_action;
                $Moods_action->id_moods = $idMood;
                $Moods_action->id_actions = $request->get("idAction")[$i];
                $Moods_action->save();
            }
        }
    }
    private function checkTimeExist($dateStart,$dateEnd) {
        
    }
}
