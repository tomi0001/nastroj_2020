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
use App\Http\Services\Mood;
use DB;
use App\Http\Services\Common;

use Auth;

class Search {
    
    public $errors = [];
    public $question;
    private $second1 = 0;
    private $second2 = 0;
    public $arrayList = [];
    public $arraySecond = [];
    public $listPercent = [];
    private $i = 0;
    public $count = 0;
    private function sortMoods2($listMoods) {
        $Mood = new Mood;
        foreach ($listMoods as $Moodss) {
            $this->arrayList[$this->i]["second"] = strtotime($Moodss->date_end) - strtotime($Moodss->date_start);
            $this->arraySecond[$this->i] = $this->arrayList[$this->i]["second"];
            $this->arrayList[$this->i]["color_nas"] = $Mood->setColor(array("mood"=>$Moodss->nas));
            $this->arrayList[$this->i]["color_mood"] = $Mood->setColor(array("mood"=>$Moodss->level_mood));
            $this->arrayList[$this->i]["percent"] = 0;
            $this->i++;
        }
    }
    

    public function sumMoodPercent(Request $request,$id) {
        $Mood =  AppMood::query();
        $Mood->selectRaw("(sum(TIMESTAMPDIFF (SECOND, date_start , date_end)) / 3600) as sum");
        if ($request->get("dateFrom") != "") {
            $Mood->where("date_start",">=",$request->get("dateFrom"));
        }
        if ($request->get("dateTo") != "") {
            $Mood->where("date_end","<=",$request->get("dateTo"));
        }
        $Mood->where("id_users",$id);
        $sum = $Mood->first();
        return $sum;
    }
    public function sumMood(Request $request,$id) {
        $Mood =  AppMood::query();
        $Mood->selectRaw("(sum(TIMESTAMPDIFF (SECOND, date_start , date_end)) / 3600) as sum");
        if ($request->get("dateFrom") != "") {
            $Mood->where("date_start",">=",$request->get("dateFrom"));
        }
        if ($request->get("dateTo") != "") {
            $Mood->where("date_end","<=",$request->get("dateTo"));
        }
        if ($request->get("moodFrom") != "") {
            $Mood->where("level_mood",">=",$request->get("moodFrom") - 0.0001);
        }
        if ($request->get("moodTo") != "") {
            $Mood->where("level_mood","<=",$request->get("moodTo") + 0.0001) ;
        }
        if ($request->get("anxietyFrom") != "") {
            $Mood->where("level_anxiety",">=",$request->get("anxietyFrom") - 0.0001);
        }
        if ($request->get("anxietyTo") != "") {
            $Mood->where("level_anxiety","<=",$request->get("anxietyTo") + 0.0001) ;
        }
        if ($request->get("voltageFrom") != "") {
            $Mood->where("level_nervousness",">=",$request->get("voltageFrom") - 0.0001);
        }
        if ($request->get("voltageTo") != "") {
            $Mood->where("level_nervousness","<=",$request->get("voltageTo") + 0.0001) ;
        }
        if ($request->get("stimulationFrom") != "") {
            $Mood->where("level_stimulation",">=",$request->get("stimulationFrom") - 0.0001);
        }
        if ($request->get("stimulationTo") != "") {
            $Mood->where("level_stimulation","<=",$request->get("stimulationTo") + 0.0001) ;
        }
        $Mood->where("id_users",$id);
        $sum = $Mood->first();
        return $sum;
    }
    public function sortSleeps($listMoods,$bool = false) :bool {
        
        $arraySecond = [];
        $this->sortSleeps2($listMoods);


        if ($this->i != 0) {
            
            array_multisort($this->arraySecond,SORT_ASC);
            if ($bool == true) {
                array_multisort($this->arrayList,SORT_ASC);
            }
            $longSecond = count($this->arraySecond);
            $this->listPercent = $this->sumPercent($this->arraySecond[$longSecond-1],$this->arrayList);
            return true;
        }
        return false;
    }
        private function sortSleeps2($listMoods) {
        $Mood = new Mood;
        foreach ($listMoods as $Moodss) {
            $this->arrayList[$this->i]["second"] = strtotime($Moodss->date_end) - strtotime($Moodss->date_start);
            $this->arraySecond[$this->i] = $this->arrayList[$this->i]["second"];
            $this->arrayList[$this->i]["color_nas"] = $Mood->setColor(array("mood"=>$Moodss->nas));
            $this->arrayList[$this->i]["color_mood"] = $Mood->setColor(array("mood"=>$Moodss->level_mood));
            $this->arrayList[$this->i]["percent"] = 0;
            $this->i++;
        }
    }
    private function sumPercent(int $second,array $list) {
        for ($i=0;$i < count($list);$i++) {
            $list[$i]["percent"] = round(($list[$i]["second"] / $second) * 100);
            if ($list[$i]["percent"] == 0) {
                $list[$i]["percent"] = 1;
            }
            $list[$i]["second"] = $this->changeSecondAtHour($list[$i]["second"] / 3600);
            
        }
        return $list;
    }    
    public function sortMoods($listMoods,$bool = false) :bool {
        
        $arraySecond = [];
        $this->sortMoods2($listMoods);


        if ($this->i != 0) {
            
            array_multisort($this->arraySecond,SORT_ASC);
            if ($bool == true) {
                array_multisort($this->arrayList,SORT_ASC);
            }
            $longSecond = count($this->arraySecond);
            $this->listPercent = $this->sumPercent($this->arraySecond[$longSecond-1],$this->arrayList);
            return true;
        }
        return false;
    }
    
    private function changeSecondAtHour($hour) {
        if (strstr($hour,".")) {
            $div = explode(".",$hour);
            if ($div[0] == 0) {
                $min = "0." . $div[1];
                $min *= 60;
                return round($min) . " minut";
            }
            else {
                $hour = $div[0] . " Godzin i ";
                $min = "0." . $div[1];
                $min *= 60;
                return $hour . round($min) . " minut";
            }
        }
        return $hour . " Godzin";
        
    }
    public function createQuestion(Request $request,$id) {
        $this->question =  AppMood::query();
        $this->setDate($request);
        $this->setTime($request);
        
        $hour = Auth::User()->start_day;
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
        $this->question->selectRaw(DB::Raw("(DATE(IF(HOUR(moods.date_start) >= '$hour', moods.date_start,Date_add(moods.date_start, INTERVAL - 1 DAY) )) ) as dat"));
        $this->question->selectRaw(DB::Raw("(YEAR(IF(HOUR(moods.date_start) >= '$hour', moods.date_start,Date_add(moods.date_start, INTERVAL - 1 DAY) )) ) as year"));
        $this->question->selectRaw(DB::Raw("(MONTH(IF(HOUR(moods.date_start) >= '$hour', moods.date_start,Date_add(moods.date_start, INTERVAL - 1 DAY) )) ) as month"));
        $this->question->selectRaw(DB::Raw("(DAY(IF(HOUR(moods.date_start) >= '$hour', moods.date_start,Date_add(moods.date_start, INTERVAL - 1 DAY) )) ) as day"));
        $this->question->selectRaw("moods.date_start as date_start");
        $this->question->selectRaw("moods.date_end as date_end");
        $this->question->selectRaw("moods.level_mood  as level_mood ");
        $this->question->selectRaw("moods.level_anxiety as level_anxiety");
        $this->question->selectRaw("moods.level_nervousness as level_nervousness");
        $this->question->selectRaw("moods.level_stimulation as level_stimulation");
        $this->question->selectRaw("moods.epizodes_psychotik as epizodes_psychotik");
        $this->question->selectRaw("moods.what_work as what_work");
        $this->question->selectRaw("moods.id as id");
       
        //if ($request->get("actions") != null and $this->emptyArray($request->get("actions")) or $request->get("ifactions") == "on") {
            $this->question->leftjoin("moods_actions","moods_actions.id_moods","moods.id")->leftjoin("actions","actions.id","moods_actions.id_actions");
            $this->question->selectRaw("moods_actions.id_actions as id_actions");
            $this->question->selectRaw("actions.name as actionDay ");
        //}
        $this->setIdUsers($id);
        if ($request->get("valueAllDay") == "on") {
            
            $this->setGroup($request);
            $this->setHavingAction($request);
        }
  
        else {
            $this->setWhereMoods($request);
            $this->setLongMoods($request);
            
            $this->whereEpizodes($request);
            if ($request->get("descriptions") != null and count($request->get("descriptions")) > 0) {
                $this->setWhatWork($request);
            }
            if ( $request->get("actions") != null and  $this->emptyArray($request->get("actions"))) {
                $this->setWhatAction($request);
            }
            if ($request->get("ifDescriptions") == "on") {
                $this->question->where("moods.what_work", "!=" ,  ""  );
            }
            if ($request->get("ifactions") == "on") {
                $this->question->where("moods_actions.id", "!=" ,  ""  );
            }
            $this->setGroupId();
        }
        if ($request->get("valueAllDay") == "on") {
            $this->setSortAllDay($request);
        }
        else {
            $this->setSort($request);
        }
        $this->count = $this->question->get()->count();
        return $this->question->paginate(15);
    }
    
    
    public function createQuestionForSleep(Request $request,$id) {
        $this->question =  Sleep::query();
        $this->setDateSleep($request);
        $this->setTimeSleep($request);
        
        $hour = 24  - 3;
        $this->question->selectRaw("TIMESTAMPDIFF (SECOND, date_start , date_end) as longMood");

        //$hour = Auth::User()->start_day;
        $this->question->selectRaw(DB::Raw("(DATE(IF(HOUR(date_end) >= '$hour', date_start,Date_add(date_end, INTERVAL - 0 DAY) )) ) as dat"));
        $this->question->selectRaw(DB::Raw("(YEAR(IF(HOUR(date_end) >= '$hour', date_start,Date_add(date_end, INTERVAL - 0 DAY) )) ) as year"));
        $this->question->selectRaw(DB::Raw("(MONTH(IF(HOUR(date_end) >= '$hour', date_start,Date_add(date_end, INTERVAL - 0 DAY) )) ) as month"));
        $this->question->selectRaw(DB::Raw("(DAY(IF(HOUR(date_end) >= '$hour', date_start,Date_add(date_end, INTERVAL - 0 DAY) )) ) as day"));
        $this->question->selectRaw("date_start as date_start");
        $this->question->selectRaw("date_end as date_end");

        $this->question->selectRaw("how_wake_up as how_wake_up");
        $this->question->selectRaw("id as id");

        $this->setLongSleep($request);
        $this->setIdUsersSleep($id);
        $this->whereWakeUp($request);

 
        $this->setSortSleep($request);
        
        return $this->question->paginate(15);
    }
    
    
    private function setIdUsers($id) {
        $this->question->where("moods.id_users",$id);
    }
    private function setIdUsersSleep($id) {
        $this->question->where("id_users",$id);
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
    private function setSortSleep(Request $request) {
        switch ($request->get("sort")) {
            case 'date': $this->question->orderBy("date_start","DESC");
                break;
            case 'hour': $this->question->orderByRaw("time(date_start)","DESC");
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
            if (isset($request->get("descriptions")[$i]) and  $request->get("descriptions")[$i] != null ) {
                    $string = Common::charset_utf_fix2($request->get("descriptions")[$i]);
                    $query->orwhereRaw("what_work like '%" . $string  . "%'");
                    $query->orwhereRaw("what_work like '%" . $request->get("descriptions")[$i]  . "%'");
        }}});
                
     }
    private function setHavingAction(Request $request) {
        
        $this->question->where(function ($query) use ($request) {
        for ($i=0;$i < count($request->get("actions") );$i++) {
            //print $request->get("actions")[$i];
            //if ($request->get("actions")[$i] != "") {
                $query->orwhereRaw("actions.name like '%" . $request->get("actions")[$i]  . "%'");
                if (isset($request->get("actions")[$i]) and $request->get("actions")[$i] != null and isset($request->get("actionsNumberFrom")[$i]) and $request->get("actionsNumberFrom")[$i] != "" and   isset($request->get("actionsNumberTo")[$i]) and $request->get("actionsNumberTo")[$i] != "") {
                    $percent = $request->get("actionsNumberFrom")[$i];
                    $percent2 = $request->get("actionsNumberTo")[$i];
                    
                    $this->question->orhavingRaw("(  (sum(TIMESTAMPDIFF(minute,moods.date_start,moods.date_end)) >= '$percent') and (sum(TIMESTAMPDIFF(minute,moods.date_start,moods.date_end)) <= '$percent2'))");
                    //$query->orwhereRaw("(actions.name like '%" . $request->get("actions")[$i]  . "%'  and moods_actions.percent_executing >= '$percent'  and moods_actions.percent_executing <= '$percent2')");
                }
                else if (  isset($request->get("actionsNumberFrom")[$i])   and  $request->get("actionsNumberFrom")[$i] != ""  ) {
                    $percent = $request->get("actionsNumberFrom")[$i] ;
                    
                    $this->question->orhavingRaw("(  sum(TIMESTAMPDIFF(minute,moods.date_start,moods.date_end)) >= '$percent')");
                    //$query->orwhereRaw("(actions.name like '%" . $request->get("actions")[$i]  . "%' and moods_actions.percent_executing >= '$percent')");
                }
                else if (  isset($request->get("actionsNumberTo")[$i])   and $request->get("actionsNumberTo")[$i] != "" ) {
                    $percent = $request->get("actionsNumberTo")[$i];
                    $this->question->orhavingRaw("(  sum(TIMESTAMPDIFF(minute,moods.date_start,moods.date_end)) <= '$percent')");
                    //$query->orwhereRaw("(actions.name like '%" . $request->get("actions")[$i]  . "%' and moods_actions.percent_executing <= '$percent')");
                }

            //}
            }}); 
        
    }
    private function setWhatAction(Request $request) {

         
        $this->question->where(function ($query) use ($request) {
        for ($i=0;$i < count($request->get("actions") );$i++) {
                if (isset($request->get("actions")[$i]) and $request->get("actions")[$i] != null and isset($request->get("actionsNumberFrom")[$i]) and $request->get("actionsNumberFrom")[$i] != "" and   isset($request->get("actionsNumberTo")[$i]) and $request->get("actionsNumberTo")[$i] != "") {
                    $percent = $request->get("actionsNumberFrom")[$i];
                    $percent2 = $request->get("actionsNumberTo")[$i];
                    $query->orwhereRaw(" (actions.name like '%" . $request->get("actions")[$i]  . "%' and  (TIMESTAMPDIFF(minute,moods.date_start,moods.date_end) >= '$percent') and (TIMESTAMPDIFF(minute,moods.date_start,moods.date_end) <= '$percent2'))");
                    //$query->orwhereRaw("(actions.name like '%" . $request->get("actions")[$i]  . "%'  and moods_actions.percent_executing >= '$percent'  and moods_actions.percent_executing <= '$percent2')");
                }
                else if (  isset($request->get("actionsNumberFrom")[$i])   and  $request->get("actionsNumberFrom")[$i] != ""  ) {
                    $percent = $request->get("actionsNumberFrom")[$i] ;
                    
                    $query->orwhereRaw("(actions.name like '%" . $request->get("actions")[$i]  . "%' and  (TIMESTAMPDIFF(minute,moods.date_start,moods.date_end)) >= '$percent')");
                    //$query->orwhereRaw("(actions.name like '%" . $request->get("actions")[$i]  . "%' and moods_actions.percent_executing >= '$percent')");
                }
                else if (  isset($request->get("actionsNumberTo")[$i])   and $request->get("actionsNumberTo")[$i] != "" ) {
                    $percent = $request->get("actionsNumberTo")[$i];
                    $query->orwhereRaw("(actions.name like '%" . $request->get("actions")[$i]  . "%' and  (TIMESTAMPDIFF(minute,moods.date_start,moods.date_end)) <= '$percent')");
                    //$query->orwhereRaw("(actions.name like '%" . $request->get("actions")[$i]  . "%' and moods_actions.percent_executing <= '$percent')");
                }
                else  {
                    $query->orwhereRaw(" actions.name like '%" . $request->get("actions")[$i]  . "%'");
                }

            }});
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
    private function whereWakeUp(Request $request) {
        if ($request->get("wakeUpFrom") != "") {
            $this->question->where("how_wake_up",">=",$request->get("wakeUpFrom"));
        }
        if ($request->get("wakeUpTo") != "") {
            $this->question->where("how_wake_up","<=",$request->get("wakeUpTo"));
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
    private function setDateSleep(Request $request) {
        if ($request->get("dateFrom") != "") {
            $this->question->where("date_start", ">=" , $request->get("dateFrom"));
        }
        if ($request->get("dateTo") != "") {
            $this->question->where("date_end", "<=" , $request->get("dateTo"));
        }
        
    }
    private function sumHour($hour,$start) {
        $sumHour = $hour[0] - $start;
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

        
        
            

        
        if ($request->get("timeFrom") != "" and $request->get("timeTo") != "") {
            $timeFrom = explode(":",$request->get("timeFrom"));
            $timeTo = explode(":",$request->get("timeTo"));
            $hourFrom = $this->sumHour($timeFrom,$hour);
            $hourTo = $this->sumHour($timeTo,$hour);

            $this->question->whereRaw("(time(date_add(date_start,INTERVAL - $hour hour))) <= '$hourTo'");
            $this->question->whereRaw("(time(date_add(date_end,INTERVAL - $hour hour))) >= '$hourFrom'");   
           
        }
        else if ($request->get("timeTo") != "") {
            $this->question->whereRaw("time(date_end) <= " . "'" .  $request->get("timeTo") . ":00'");
        }
        else if ($request->get("timeFrom") != "") {
            $this->question->whereRaw("time(date_start) >= " . "'" .  $request->get("timeFrom") . ":00'");
        }

        
         
    }
    private function setTimeSleep(Request $request) {
        $hour = 13;

        
        
            

        
        if ($request->get("timeFrom") != "" and $request->get("timeTo") != "") {
            $timeFrom = explode(":",$request->get("timeFrom"));
            $timeTo = explode(":",$request->get("timeTo"));
            $hourFrom = $this->sumHour($timeFrom,$hour);
            $hourTo = $this->sumHour($timeTo,$hour);

            $this->question->whereRaw("(time(date_add(date_start,INTERVAL - $hour hour))) <= '$hourTo'");
            $this->question->whereRaw("(time(date_add(date_end,INTERVAL - $hour hour))) >= '$hourFrom'");   
           
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
            $this->setHour2($request);
        }        
        if ($this->second1 != 0) {
            $this->question->whereRaw("(TIMESTAMPDIFF (SECOND, date_start , date_end)) >= '" . $this->second1 . "'");
        }
        if ($this->second2 != 0) {
            $this->question->whereRaw("(TIMESTAMPDIFF (SECOND, date_start , date_end)) <= '" . $this->second2 . "'");
        }
    }
    private function setLongSleep(Request $request) {
        if ($request->get("longSleepFromHour") != "" or $request->get("longSleepFromMinutes") != "") {
            $this->setHourSleep1($request);
        }
        if ( $request->get("longSleepToHour") != "" or  $request->get("longSleepToMinutes") != "") {
            $this->setHourSleep2($request);
        }        
        if ($this->second1 != 0) {
            $this->question->whereRaw("(TIMESTAMPDIFF (SECOND, date_start , date_end)) >= '" . $this->second1 . "'");
        }
        if ($this->second2 != 0) {
            $this->question->whereRaw("(TIMESTAMPDIFF (SECOND, date_start , date_end)) <= '" . $this->second2 . "'");
        }
    }
    private function setHourSleep1(Request $request) {
        if ($request->get("longSleepFromHour") != "") {
            $this->second1 += ($request->get("longSleepFromHour") * 3600);
        }
        if ($request->get("longSleepFromMinutes") != "") {
            $this->second1 += ($request->get("longSleepFromMinutes") * 60);
        }
  
    }
    private function setHourSleep2(Request $request) {
        if ($request->get("longSleepToHour") != "") {
            $this->second2 += ($request->get("longSleepToHour") * 3600);
        }
        if ($request->get("longSleepToMinutes") != "") {
            $this->second2 += ($request->get("longSleepToMinutes") * 60);
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
            $this->question->where("moods.level_mood", ">=" ,  $request->get("moodFrom") - 0.0001 );
        }
        if ($request->get("moodTo") != "") {
            $this->question->where("moods.level_mood", "<=" ,  $request->get("moodTo") + 0.0001 );
        }
        if ($request->get("anxietyFrom") != "") {
            $this->question->where("moods.level_anxiety", ">=" ,  $request->get("anxietyFrom") - 0.0001 );
        }
        if ($request->get("anxietyTo") != "") {
            $this->question->where("moods.level_anxiety", "<=" ,  $request->get("anxietyTo")  + 0.0001);
        }
        if ($request->get("voltageFrom") != "") {
            $this->question->where("moods.level_nervousness", ">=" ,  $request->get("voltageFrom") - 0.0001 );
        }
        if ($request->get("voltageTo") != "") {
            $this->question->where("moods.level_nervousness", "<=" ,  $request->get("voltageTo")  + 0.0001);
        }
        if ($request->get("stimulationFrom") != "") {
            $this->question->where("moods.level_stimulation", ">=" ,  $request->get("stimulationFrom") - 0.0001 );
        }
        if ($request->get("stimulationTo") != "") {
            $this->question->where("moods.level_stimulation", "<=" ,  $request->get("stimulationTo")  + 0.0001);
        }
    }
    private function setGroupId() {
        
        $this->question->groupBy("moods.id");
        
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
        if (!empty($request->get("actionsNumberFrom"))) {
            for ($i = 0;$i < count($request->get("actionsNumberFrom"));$i++) {
                $this->checkPercent($request->get("actionsNumberFrom")[$i],"Procent akcji ");
            }
        }
        if (!empty($request->get("actionsNumberTo"))) {
            for ($i = 0;$i < count($request->get("actionsNumberTo"));$i++) {
                $this->checkPercent($request->get("actionsNumberTo")[$i],"Procent akcji ");
            }
        }
        $this->checkLevelPsychotic($request->get("epizodesFrom"),"Liczba epizodów psychotycznych od ");
        $this->checkLevelPsychotic($request->get("epizodesTo"),"Liczba epizodów psychotycznych do ");
        $this->comparateLevel($request->get("moodFrom"),$request->get("moodTo")," nastroju ");
        $this->comparateLevel($request->get("anxietyFrom"),$request->get("anxietyTo")," nastroju ");
        $this->comparateLevel($request->get("voltageFrom"),$request->get("voltageTo")," nastroju ");
        $this->comparateLevel($request->get("stimulationFrom"),$request->get("stimulationTo")," nastroju ");
    }
    public function checkErrorSleep(Request $request) {
        $this->checkLevelPsychotic($request->get("wakeUpFrom"),"Liczba wybudzeń  od ");
        $this->checkLevelPsychotic($request->get("wakeUpTo"),"Liczba wybudzen do ");
    }
    private function checkLevelPsychotic($number,string $what) {
        if ($number == "") {
            return;
        }
        if (strstr($number,".")) {
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
    private function checkPercent($number,string $what) {
        if ($number == "") {
            return;
        }
        if (!is_numeric($number)) {
            array_push($this->errors, $what . " nie jest liczbą");
        }
        else if ($number > 3000 or $number < 0) {
            array_push($this->errors, $what . " musi się mieścić w przedziele od 0 do +3000");
        }

    }
}
