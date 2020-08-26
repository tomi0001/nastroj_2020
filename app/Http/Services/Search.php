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
use App\Actions_plan;
use App\Sleep;
use DB;
//use App\Services\Common;

use Auth;

class Search {
    
    public $errors = [];
    public $question;
    private $second1 = 0;
    private $second2 = 0;
    public function createQuestion(Request $request) {
        $this->question =  AppMood::query();
        $this->setDate($request);
        $this->setTime($request);
        
        $this->question->selectRaw("TIMESTAMPDIFF (SECOND, date_start , date_end) as longMood");
        if ($request->get("valueAllDay") == "on") {
            
            $this->question->selectRaw("round(sum(TIMESTAMPDIFF (SECOND, moods.date_start , moods.date_end)  * moods.level_mood) / "
                   . "sum(TIMESTAMPDIFF(second,moods.date_start,moods.date_end)),2) as nas");
            $this->question->selectRaw("round(sum(TIMESTAMPDIFF (SECOND, date_start , date_end)  * level_anxiety) / "
                   . "sum(TIMESTAMPDIFF(second,date_start,date_end)),2) as nas2");
            $this->question->selectRaw("round(sum(TIMESTAMPDIFF (SECOND, date_start , date_end)  *  	level_nervousness ) / "
                   . "sum(TIMESTAMPDIFF(second,date_start,date_end)),2) as nas3");
            $this->question->selectRaw("round(sum(TIMESTAMPDIFF (SECOND, date_start , date_end)  * level_stimulation) / "
                   . "sum(TIMESTAMPDIFF(second,date_start,date_end)),2) as nas4");
        }
        //$hour = Auth::User()->start_day;
        //$this->selectRaw(DB::Raw("(DATE(IF(HOUR(moods.date_start) >= '$hour', moods.date_start,Date_add(moods.date_start, INTERVAL - 1 DAY) )) ) "));
        $this->question->selectRaw("moods.date_start as date_start");
        $this->question->selectRaw("moods.date_end as date_end");
        if ($this->emptyArray($request->get("actions")) or $request->get("ifactions") == "on") {
            $this->question->leftjoin("moods_actions","moods_actions.id_moods","moods.id")->leftjoin("actions","actions.id","moods_actions.id_actions");
        }
        if ($request->get("valueAllDay") == "on") {
            $this->setGroup($request);
        }
        else {
            $this->setWhereMoods($request);
            $this->setLongMoods($request);
            $this->whereEpizodes($request);
            if (count($request->get("descriptions")) > 0) {
                $this->setWhatWork($request);
            }
            if ($this->emptyArray($request->get("actions"))) {
                $this->setWhatAction($request);
            }
            if ($request->get("ifDescriptions") == "on") {
                $this->question->where("moods.what_work", "!=" ,  ""  );
            }
            if ($request->get("ifactions") == "on") {
                $this->question->where("moods_actions.id", "!=" ,  ""  );
            }
        }
        if ($request->get("valueAllDay") == "on") {
            $this->setSortAllDay($request);
        }
        else {
            $this->setSort($request);
        }
        return $this->question->paginate(15);
    }
    private function setSort(Request $request) {
        switch ($request->get("sort")) {
            case 'date': $this->question->orderBy("moods.date_start","DESC");
                break;
            case 'hour': $this->question->orderByRaw("time(moods.date_start)","DESC");
                break;
            case 'mood': $this->question->orderBy("moods.level_mood","DESC");
                break;
            case 'anxiety': $this->question->orderBy("moods.level_anxiety","DESC");
                break;
            case 'voltage': $this->question->orderBy("moods.level_nervousness","DESC");
                break;
            case 'stimulation': $this->question->orderBy("moods.level_stimulation","DESC");
                break;
            case 'longMood': $this->question->orderBy("longMood","DESC");
                break;
            
        }
    }
    private function setSortAllDay(Request $request) {
        switch ($request->get("sort")) {
            case 'date': $this->question->orderBy("moods.date_start","DESC");
                break;
            case 'mood': $this->question->orderBy("nas","DESC");
                break;
            case 'anxiety': $this->question->orderBy("nas2","DESC");
                break;
            case 'voltage': $this->question->orderBy("nas3","DESC");
                break;
            case 'stimulation': $this->question->orderBy("nas4","DESC");
                break;

            
        }
    }
    private function setWhatWork(Request $request) {
        $this->question->where(function ($query) use ($request) {
        for ($i=0;$i < count($request->get("descriptions"));$i++) {
            if ($request->get("descriptions")[$i] != null) {
                
                    $query->orwhereRaw("what_work like '%" . $request->get("descriptions")[$i]  . "%'");
        }}});
                
     }
     
    private function setWhatAction(Request $request) {
        $this->question->where(function ($query) use ($request) {
        for ($i=0;$i < count($request->get("actions"));$i++) {
            if ($request->get("actions")[$i] != null) {
                
                    $query->orwhereRaw("actions.name like '%" . $request->get("actions")[$i]  . "%'");
        }}});         
    } 
    private function emptyArray($array) {
        $bool = false;
        for ($i = 0;$i < count($array);$i++) {
            if ($array[$i] != "") {
                $bool = true;
                break;
            }
        }
        return $bool;
    }
    private function whereEpizodes(Request $request) {
        if ($request->get("epizodesFrom") != "") {
            $this->question->where("epizodes_psychotik",">=",$request->get("epizodesFrom"));
        }
        if ($request->get("epizodesTo") != "") {
            $this->question->where("epizodes_psychotik","<=",$request->get("epizodesTo"));
        }
    }
    private function setDate(Request $request) {
        if ($request->get("dateFrom") != "") {
            $this->question->where("date_start", ">=" , $request->get("dateFrom"));
        }
        if ($request->get("dateTo") != "") {
            $this->question->where("date_end", "<=" , $request->get("dateTo"));
        }
        
    }
    private function sumHour($hour) {
        $sumHour = $hour[0] - Auth::User()->start_day;
        if ($sumHour < 0) {
            $sumHour = 24 + $sumHour;
        }
        if (strlen($sumHour) == 1) {
            $sumHour = "0" .$sumHour;
        }
        if (strlen($hour[1]) == 1) {
            $hour[1] = "0" . $hour[1];
        }
        return $sumHour . ":" .  $hour[1] . ":00";
    }
    private function setTime(Request $request) {
        $hour = Auth::User()->start_day;

        
        $timeFrom = explode(":",$request->get("timeFrom"));
        $timeTo = explode(":",$request->get("timeTo"));
        $hourFrom = $this->sumHour($timeFrom);
        $hourTo = $this->sumHour($timeTo);
            

        
        if ($request->get("timeFrom") != "" and $request->get("timeTo") != "") {
        

                $this->question->whereRaw("(time(date_add(date_start,INTERVAL - 5 hour))) <= '$hourTo'");
                $this->question->whereRaw("(time(date_add(date_end,INTERVAL - 5 hour))) >= '$hourFrom'");

            
                 
                 
                
           
        }
        else if ($request->get("timeTo") != "") {
            $this->question->whereRaw("time(date_end) <= " . "'" .  $request->get("timeTo") . ":00'");
        }
        else if ($request->get("timeFrom") != "") {
            $this->question->whereRaw("time(date_start) >= " . "'" .  $request->get("timeFrom") . ":00'");
        }

        
         
    }
    private function setLongMoods(Request $request) {
        if ($request->get("longMoodFromHour") != "" or $request->get("longMoodFromMinutes") != "") {
            $this->setHour1($request);
        }
        if ( $request->get("longMoodToHour") != "" or  $request->get("longMoodToMinutes") != "") {
            $this->setHour1($request);
        }        
        if ($this->second1 != 0) {
            $this->question->whereRaw("(TIMESTAMPDIFF (SECOND, date_start , date_end)) >= '" . $this->second1 . "'");
        }
        if ($this->second2 != 0) {
            $this->question->whereRaw("(TIMESTAMPDIFF (SECOND, date_start , date_end)) <= '" . $this->second2 . "'");
        }
    }
    private function setHour1(Request $request) {
        if ($request->get("longMoodFromHour") != "") {
            $this->second1 += ($request->get("longMoodFromHour") * 3600);
        }
        if ($request->get("longMoodFromMinutes") != "") {
            $this->second1 += ($request->get("longMoodFromMinutes") * 60);
        }
  
    }
    private function setHour2(Request $request) {
        if ($request->get("longMoodToHour") != "") {
            $this->second2 += ($request->get("longMoodToHour") * 3600);
        }
        if ($request->get("longMoodToMinutes") != "") {
            $this->second2 += ($request->get("longMoodToMinutes") * 60);
        }
    }
    private function setWhereMoods(Request $request) {
        if ($request->get("moodFrom") != "") {
            $this->question->where(" moods.level_mood", ">=" ,  $request->get("moodFrom")  );
        }
        if ($request->get("moodTo") != "") {
            $this->question->where(" moods.level_mood", "<=" ,  $request->get("moodTo")  );
        }
        if ($request->get("anxietyFrom") != "") {
            $this->question->where(" moods.level_anxiety", ">=" ,  $request->get("anxietyFrom")  );
        }
        if ($request->get("anxietyTo") != "") {
            $this->question->where(" moods.level_anxiety", "<=" ,  $request->get("anxietyTo")  );
        }
        if ($request->get("voltageFrom") != "") {
            $this->question->where(" moods.level_nervousness", ">=" ,  $request->get("voltageFrom")  );
        }
        if ($request->get("voltageTo") != "") {
            $this->question->where(" moods.level_nervousness", "<=" ,  $request->get("voltageTo")  );
        }
        if ($request->get("stimulationFrom") != "") {
            $this->question->where(" moods.level_stimulation", ">=" ,  $request->get("stimulationFrom")  );
        }
        if ($request->get("stimulationTo") != "") {
            $this->question->where(" moods.level_stimulation", "<=" ,  $request->get("stimulationTo")  );
        }
    }

    private function setGroup(Request $request) {
        $hour = Auth::User()->start_day;
        $this->question->groupBy(DB::Raw("(DATE(IF(HOUR(moods.date_start) >= '$hour', moods.date_start,Date_add(moods.date_start, INTERVAL - 1 DAY) )) ) "));
        
        if ($request->get("moodFrom") != "") {
            $this->question->havingRaw("round(sum(TIMESTAMPDIFF (SECOND, moods.date_start , moods.date_end)  * moods.level_mood) / "
                   . "sum(TIMESTAMPDIFF(second,moods.date_start,moods.date_end)),2) >= '" . $request->get("moodFrom") . "'");
        }
        if ($request->get("moodTo") != "") {
            $this->question->havingRaw("round(sum(TIMESTAMPDIFF (SECOND, moods.date_start , moods.date_end)  * moods.level_mood) / "
                   . "sum(TIMESTAMPDIFF(second,moods.date_start,moods.date_end)),2) <= '" . $request->get("moodTo") . "'");
        }
        if ($request->get("anxietyFrom") != "") {
            $this->question->havingRaw("round(sum(TIMESTAMPDIFF (SECOND, date_start , date_end)  * level_anxiety) / "
                   . "sum(TIMESTAMPDIFF(second,date_start,date_end)),2) >=" . $request->get("anxietyFrom"));
        }
        if ($request->get("anxietyTo") != "") {
            $this->question->havingRaw("round(sum(TIMESTAMPDIFF (SECOND, date_start , date_end)  * level_anxiety) / "
                   . "sum(TIMESTAMPDIFF(second,date_start,date_end)),2) <= " . $request->get("anxietyTo"));
        }
        if ($request->get("voltageFrom") != "") {
            $this->question->havingRaw("round(sum(TIMESTAMPDIFF (SECOND, date_start , date_end)  *  	level_nervousness ) / "
                   . "sum(TIMESTAMPDIFF(second,date_start,date_end)),2) >= " .$request->get("voltageFrom"));
        }
        if ($request->get("voltageTo") != "") {
            $this->question->havingRaw("round(sum(TIMESTAMPDIFF (SECOND, date_start , date_end)  *  	level_nervousness ) / "
                   . "sum(TIMESTAMPDIFF(second,date_start,date_end)),2) <= " . $request->get("voltageTo"));
        }
        if ($request->get("stimulationFrom") != "") {
            $this->question->havingRaw("round(sum(TIMESTAMPDIFF (SECOND, date_start , date_end)  * level_stimulation) / "
                   . "sum(TIMESTAMPDIFF(second,date_start,date_end)),2) >= " . $request->get("stimulationFrom"));
        }
        if ($request->get("stimulationTo") != "") {
            $this->question->havingRaw("round(sum(TIMESTAMPDIFF (SECOND, date_start , date_end)  * level_stimulation) / "
                   . "sum(TIMESTAMPDIFF(second,date_start,date_end)),2) <= " . $request->get("stimulationTo"));
        }
    }
    
    public function checkErrorMood(Request $request) {
        $this->checkLevel($request->get("moodFrom"), "Nastrój od ");
        $this->checkLevel($request->get("moodTo"), "Nastrój do ");
        $this->checkLevel($request->get("anxietyFrom"), "Lęk od ");
        $this->checkLevel($request->get("anxietyTo"), "Lek do ");
        $this->checkLevel($request->get("voltageFrom"), "Napięcie od ");
        $this->checkLevel($request->get("voltageTo"), "Napięcie do ");
        $this->checkLevel($request->get("stimulationFrom"), "Pobudzenie od ");
        $this->checkLevel($request->get("stimulationTo"), "Pobudzenie do ");
        $this->checkLevelPsychotic($request->get("epizodesFrom"),"Liczba epizodów psychotycznych od ");
        $this->checkLevelPsychotic($request->get("epizodesTo"),"Liczba epizodów psychotycznych do ");
        $this->comparateLevel($request->get("moodFrom"),$request->get("moodTo")," nastroju ");
        $this->comparateLevel($request->get("anxietyFrom"),$request->get("anxietyTo")," nastroju ");
        $this->comparateLevel($request->get("voltageFrom"),$request->get("voltageTo")," nastroju ");
        $this->comparateLevel($request->get("stimulationFrom"),$request->get("stimulationTo")," nastroju ");
    }
    
    private function checkLevelPsychotic($number,string $what) {
        if ($number == "") {
            return;
        }
        if (strstr(".",$number)) {
            array_push($this->errors, $what . " nie jest liczbą całkowitą");
        }
        else if ($number < 0) {
            array_push($this->errors, $what . " nie jest liczbą dodatnią");
        }

    }
    private function comparateLevel($number1,$number2,string $what) {
        if ($number1 == "" or $number2 == "") {
            return;
        }
        if ($number1 > $number2) {
            array_push($this->errors,  " pierwsza wartośc" . $what . " jest większa od drugiej");
        }
    }
    private function checkLevel($number,string $what) {
        if ($number == "") {
            return;
        }
        if (!is_numeric($number)) {
            array_push($this->errors, $what . " nie jest liczbą");
        }
        else if ($number > 20 or $number < -20) {
            array_push($this->errors, $what . " musi się mieścić w przedziele od -20 do +20");
        }

    }
}
