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
use App\Sleep;
use Auth;

class Mood {
    public $levelMood = [
        0 =>  ["from" => -20, "to" => -18],
        1 =>  ["from" => -18, "to" => -16],
        2 =>  ["from" => -16, "to" => -14],
        3 =>  ["from" => -14, "to" => -12],
        4 =>  ["from" => -12, "to" => -10],
        5 =>  ["from" => -10, "to" => -8],
        6 =>  ["from" => -8, "to" => -6],
        7 =>  ["from" => -4, "to" => -2],
        8 =>  ["from" => -2, "to" => -1],
        9 =>  ["from" => -1, "to" => 0],
        10 =>  ["from" => 0, "to" => 1],
        11 =>  ["from" => 1, "to" => 2],
        12 =>  ["from" => 2, "to" => 4],
        13 =>  ["from" => 4, "to" => 6],
        14 =>  ["from" => 6, "to" => 8],
        15 =>  ["from" => 8, "to" => 10],
        16 =>  ["from" => 10, "to" => 12],
        17 =>  ["from" => 12, "to" => 14],
        18 =>  ["from" => 14, "to" => 16],
        19 =>  ["from" => 16, "to" => 18],
        20 =>  ["from" => 18, "to" => 20],
        
    ];
    public $dateStart;
    public $dateEnd;
    public $startDay = 0;
    public $listMood;
    public $dateStartHour;
    public $dateEndHour;
    public $listSleep;
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
        if (!empty(AppMood::checkTimeExist($request->get("dateStart") . " " . $request->get("timeStart") . ":00", $request->get("dateEnd") . " " . $request->get("timeEnd") . ":00"))
                or !empty(Sleep::checkTimeExist($request->get("dateStart") . " " . $request->get("timeStart") . ":00", $request->get("dateEnd") . " " . $request->get("timeEnd") . ":00"))) {
            array_push($this->errors,"Godziny nastroju  nachodza na inne nastroje");
        }
        if ($bool == 4 and strtotime($request->get("dateStart") . " " . $request->get("timeStart") . ":00") >= strtotime($request->get("dateEnd") . " " . $request->get("timeEnd") . ":00")) {
            array_push($this->errors,"Godzina zaczęcia jest wieksza bądź równa godzinie skończenia");
        }
    }
   public function checkAddSleepDate(Request $request) {
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
        if (  (strtotime($request->get("dateEnd") . " " . $request->get("timeEnd") . ":00") - strtotime($request->get("dateStart") . " " . $request->get("timeStart") . ":00")) > 82000) {
            array_push($this->errors,"Sen nie może mieć takiego dużego przedziału czasowego");
        }
        if (!empty(Sleep::checkTimeExist($request->get("dateStart") . " " . $request->get("timeStart") . ":00", $request->get("dateEnd") . " " . $request->get("timeEnd") . ":00"))
                or !empty(AppMood::checkTimeExist($request->get("dateStart") . " " . $request->get("timeStart") . ":00", $request->get("dateEnd") . " " . $request->get("timeEnd") . ":00"))) {
            array_push($this->errors,"Godziny Snu  nachodza na inne nastroje");
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
    public function saveSleep(Request $request) :void {
        $Sleep = new Sleep;
        $Sleep->date_start = $request->get("dateStart") . " " . $request->get("timeStart") . ":00";
        $Sleep->date_end = $request->get("dateEnd") . " " . $request->get("timeEnd") . ":00";
        $Sleep->how_wake_up = $request->get("wakeUp");
        $Sleep->id_users = Auth::User()->id;
        $Sleep->save();
    }
    public function saveAction(Request $request,int $idMood) :void {
        for ($i = 0;$i < count($request->get("idAction"));$i++) {
            if ($request->get("idAction")[$i] != "") {
                $Moods_action = new Moods_action;
                $Moods_action->id_moods = $idMood;
                $Moods_action->id_actions = $request->get("idAction")[$i];
                $Moods_action->save();
            }
        }
    }

    
    public function downloadMood($year,$month,$day) {
        $Moods = new AppMood;
        $this->initStartDay();
        $this->setHourMood($year,$month,$day);
        $this->listMood = $Moods->leftjoin("moods_actions","moods.id","moods_actions.id_moods")
                ->selectRaw("moods.id as id")
                ->selectRaw("moods_actions.id_moods as actions")
                ->selectRaw("moods.date_start as date_start")
                ->selectRaw("moods.date_end as date_end")
                ->selectRaw("moods.level_mood as level_mood")
                ->selectRaw("moods.level_anxiety as level_anxiety")
                ->selectRaw("moods.level_nervousness as level_nervousness")
                ->selectRaw("moods.level_stimulation  as level_stimulation")
                ->selectRaw("moods.epizodes_psychotik as epizodes_psychotik")
                ->selectRaw("moods.what_work  as what_work ")
                ->where("moods.id_users",Auth::id())
                ->where("moods.date_start",">=",$this->dateStart)
                ->where("moods.date_start","<",$this->dateEnd)
                ->groupBy("moods.id")
                ->get();

        //return $this->listMood;
    }
    public function downloadSleep($year,$month,$day) {
        $Sleep = new Sleep;
        $this->setHourSleep($year,$month,$day);

        $this->listSleep = $Sleep
                        ->where("id_users",Auth::id())
                        ->where("date_start",">=",$this->dateStartHour)
                        ->where("date_start","<",$this->dateEndHour)
                        ->get();
        
    }
    private function setHourSleep($year,$month,$day) {
        $second = strtotime($year . "-" . $month . "-" . $day . " " . $this->startDay . ":00:00");
        $second2 = $second -  (3600 * 9);
        $second3 = $second + (3600 * 24);
        $this->dateStartHour = date("Y-m-d H:i:s",$second2);
        $this->dateEndHour = date("Y-m-d H:i:s",$second3);
                
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
    private function initStartDay() {
        $this->startDay = Auth::User()->start_day;
        
    }
}