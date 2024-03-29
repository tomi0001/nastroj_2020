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
use Illuminate\Http\Request;
use App\Action;
use App\Mood as AppMood;
use App\Moods_action;
use App\Actions_plan;
use App\Sleep;
//use App\Services\Common;
use App\Http\Services\Calendar;
use App\Http\Services\Action as ServicesAction;
use Auth;
use DB;

class Mood {
   
    public $levelMood = [
        0 =>  ["from" => -20, "to" => -18],
        1 =>  ["from" => -18, "to" => -16],
        2 =>  ["from" => -16, "to" => -14],
        3 =>  ["from" => -14, "to" => -12],
        4 =>  ["from" => -12, "to" => -10],
        5 =>  ["from" => -10, "to" => -8],
        6 =>  ["from" => -8, "to" => -6],
        7 =>  ["from" => -6, "to" => -2],
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
    public $colorDay = [];
    public $colorForMonth = [];
    public $color = [];
    public $colorForDay;
    public $arraySecond = [];
    public $listPercent;
    public $dateStart;
    public $dateEnd;
    public $startDay = 0;
    public $DayList = [];
    public $listMood = [];
    public $dateStartHour;
    public $dateEndHour;
    public $listSleep = [];
    public $arrayList = [];
    public $errors = [];
    public $level = [];
    public $listMoodPDF = [];
    public $listSleepPDF = [];
    //public $howAction = 0;
    private $i;
    public function checkAddMoodDate(Request $request,$timeStart,$timeEnd) {
        $bool = 4;
        if ($request->get("dateStart") == "") {
            array_push($this->errors,"Uzupełnij datę zaczęcia");
            $bool--;
        }
        if ($request->get("dateEnd") == "") {
            array_push($this->errors,"Uzupełnij datę zakończenia");
            $bool--;
        }
/*
        if ($request->get("timeStart") == "") {
            array_push($this->errors,"Uzupełnij czas zaczęcia");
            $bool--;
        }
        if ($request->get("timeEnd") == "") {
            array_push($this->errors,"Uzupełnij czas zakończenia");
            $bool--;
        }

        
 * 
 */

        if (StrToTime( date("Y-m-d H:i:s") ) < strtotime($request->get("dateEnd") . " " . $timeEnd . ":00")) {
            array_push($this->errors,"Data skończenia nastroju jest wieksza od teraźniejszej daty");
        }
        if (  (strtotime($request->get("dateEnd") . " " . $timeEnd . ":00") - strtotime($request->get("dateStart") . " " . $timeStart . ":00")) > 72000) {
            array_push($this->errors,"Nastroj nie może mieć takiego dużego przedziału czasowego");
        }
        if (  (strtotime($request->get("dateEnd") . " " . $timeEnd . ":00") - strtotime($request->get("dateStart") . " " . $timeStart . ":00")) < 300) {
            array_push($this->errors,"Nastroj nie może mieć takiego krótkiego przedziału czasowego");
        }
        if (!empty(AppMood::checkTimeExist($request->get("dateStart") . " " . $timeStart . ":00", $request->get("dateEnd") . " " . $timeEnd . ":00"))
                or !empty(Sleep::checkTimeExist($request->get("dateStart") . " " . $timeStart . ":00", $request->get("dateEnd") . " " . $timeEnd . ":00"))) {
            array_push($this->errors,"Godziny nastroju  nachodza na inne nastroje");
        }
        if ($bool == 2 and strtotime($request->get("dateStart") . " " . $timeStart . ":00") >= strtotime($request->get("dateEnd") . " " . $timeEnd . ":00")) {
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
        if (!is_numeric($request->get("wakeUp")) or $request->get("wakeUp") < 0) {
            array_push($this->errors,"Ilośc wybudzen musi być liczbą dodatnią lub równą 0");
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
    public function checkPercentMoodAction(Request $request) {
        for ($i = 0;$i < count($request->get("int_"));$i++) {
            if ($request->get("int_")[$i] != "" and ($request->get("int_")[$i] < 1 or $request->get("int_")[$i] > 100)) {
                
                array_push($this->errors,"Liczba Procentu wykonania musi być z zakresu od 1 do 100");
            }
        }
    }
    public function saveMood(Request $request,$timeStart,$timeEnd) :int {
        $Mood = new AppMood;
        $Mood->date_start = $request->get("dateStart") . " " . $timeStart . ":00";
        $Mood->date_end = $request->get("dateEnd") . " " . $timeEnd . ":00";
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
        $Mood->what_work = str_replace("\n", "<br>", $request->get("whatWork"));
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
    public function selectLastMood() {
        $moods = AppMood::selectLastMoods();
        $sleeps = Sleep::selectLastSleeps();
        $time1 = explode(" ",$moods->date_end);
        $time3 = explode(":",$time1[1]);
        $time2 = explode(" ",$sleeps->date_end);
        $time4 = explode(":",$time2[1]);
        if ($moods->date_end == "" and $sleeps->date_end == "") {
            return -1;
        }
        else if ($moods->date_end == "") {
            return $time3[0] . ":" . $time3[1];
        }
        else if ($sleeps->date_end == "") {
            return $time4[0] . ":" . $time4[1];
        }
        else if (strtotime($moods->date_end) > strtotime($sleeps->date_end )) {
            return $time3[0] . ":" . $time3[1];
        }
        else {
            return $time4[0] . ":" . $time4[1];
        }
    }
    private function sumHour($hour,$start,$bool = false) {
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
    private function calculatePerentingMoods(int $idAction,int $idMood) {
        $diff =  AppMood::differenceDate($idMood);
        $timeFrom2 = explode(" ",$diff->date_start);
        $timeTo2 = explode(" ",$diff->date_end);
        
            $timeFrom = explode(":",$timeFrom2[1]);
            $timeTo = explode(":",$timeTo2[1]);
            $hourFrom = $this->sumHour($timeFrom,Auth::User()->start_day);
            $hourTo = $this->sumHour($timeTo,Auth::User()->start_day);
        
        
        //return $diff->diff;
        $result2 = Actions_plan::checkTimeExist2($diff->date_start,$diff->date_end,$idAction,Auth::User()->start_day,$hourFrom,$hourTo);
        //print "<pre>";
        //print_r($result2);
        //print "</pre>";

        if (($result2) === null) {
            return null;
        }
        if ($result2->if_all_day != 0) {
           
            $result2 = Actions_plan::checkTimeExist3($diff->date_start,$diff->date_end,$idAction,Auth::User()->start_day,$hourFrom,$hourTo);
        }
        //print ("<pre>");
        //print_r ($result2);
        //var_dump($result2);

        

        if (!empty($result2->long) ) {
            $percent = $result2->long;
        }
        /*
        else if (!empty($result2->if_all_day) and $result2->if_all_day == 1) { 
            $second = 0;
            $difff  = explode(" ",$result2->date_start);
            $difff2 = explode(" ",$result2->date_end);
            $division = (strtotime($difff[0]) - strtotime($difff2[0]));
            
            if ($division != 0) {
                $second += 86400;
            }
            
            $date1 = "1970-01-01 " . $difff[1];
            $date2 = "1970-01-01 " . $difff2[1];
            //różnica w akcjach
            $division4 = (strtotime($date2) - strtotime($date1)) + $second;
            //print $division4;
            //akcje
            $division2 = (strtotime($result2->date_end) - strtotime($result2->date_start));
            //nastroje
            $division3 = (strtotime($diff->date_end) - strtotime($diff->date_start));
            
            $day = round($division2) / 86400;
            $division5 = ($division4) - $division2;
            
            $percent = ((($division5 )) /60 );
            //$hour = Auth::User()->start_day * 3600;
            
            
        }
         * 
         */
        else {
            if (isset($result2->date_end) and isset($result2->date_start)) {
                $percent = (strtotime($result2->date_end) - strtotime($result2->date_start)) / 60;
            }
            else {
                return null;
            }
        }
       
        $percent2 = ($diff->diff / $percent) * 100;
        //print $percent2;
        return $percent2;
        
         
        //return 1;
        
    }
    public function saveAction(Request $request,int $idMood) :void {
        for ($i = 0;$i < count($request->get("int2"));$i++) {
            if ($request->get("int2")[$i] != "") {
                $result = $this->calculatePerentingMoods($request->get("int2")[$i],$idMood);
                $Moods_action = new Moods_action;
                $Moods_action->id_moods = $idMood;
                $Moods_action->id_actions = $request->get("int2")[$i];
                $Moods_action->percent_executing = $result;
                if (!empty($request->get("int_")[$i]) ) {
                    $Moods_action->percent_executing2 = $request->get("int_")[$i];
                }
                $Moods_action->save();
            }
        }
    }

    public function downloadMoods(int $idUsers,$year,$month,$day) {
        $Moods = new AppMood;
        //$this->initStartDay($start);
        $arrayHour = $this->setHourMood($year,$month,$day,true);
        $listMood = $Moods
                
                
                ->select("level_mood")
                ->select("level_anxiety")
                ->select("level_nervousness")
                ->select("level_stimulation")
                ->selectRaw("(unix_timestamp(date_end)  - unix_timestamp(date_start)) as division")
                ->selectRaw(" ((unix_timestamp(date_end)  - unix_timestamp(date_start)) * level_mood) as average_mood")
                ->selectRaw("((unix_timestamp(date_end)  - unix_timestamp(date_start)) * level_anxiety) as average_anxiety")
                ->selectRaw("((unix_timestamp(date_end)  - unix_timestamp(date_start)) * level_nervousness) as average_nervousness")
                ->selectRaw("((unix_timestamp(date_end)  - unix_timestamp(date_start)) * level_stimulation) as average_stimulation")
                ->where("moods.date_start",">=",$arrayHour[0])
                ->where("moods.date_start","<",$arrayHour[1])
                ->where("moods.id_users",$idUsers)
                ->get();
        $array = $this->selectAverageMoods($listMood);
        return $array;
    }
    public function downloadMoodsPDF(int $idUsers,$dateFrom,$dateTo) {
        $Moods = new AppMood;
        //$this->initStartDay($start);
        $arrayHour = $this->setHourMoodPDF($dateFrom,$dateTo,true);
        $listMood = $Moods
                
                
                ->select("level_mood")
                ->select("level_anxiety")
                ->select("level_nervousness")
                ->select("level_stimulation")
                ->selectRaw("(unix_timestamp(date_end)  - unix_timestamp(date_start)) as division")
                ->selectRaw(" ((unix_timestamp(date_end)  - unix_timestamp(date_start)) * level_mood) as average_mood")
                ->selectRaw("((unix_timestamp(date_end)  - unix_timestamp(date_start)) * level_anxiety) as average_anxiety")
                ->selectRaw("((unix_timestamp(date_end)  - unix_timestamp(date_start)) * level_nervousness) as average_nervousness")
                ->selectRaw("((unix_timestamp(date_end)  - unix_timestamp(date_start)) * level_stimulation) as average_stimulation")
                ->where("moods.date_start",">=",$arrayHour[0])
                ->where("moods.date_start","<",$arrayHour[1])
                ->where("moods.id_users",$idUsers)
                ->get();
        $array = $this->selectAverageMoods($listMood);
        return $array;
    }
    public function downloadMood($year,$month,$day,$id) {
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
                ->selectRaw("(unix_timestamp(date_end)  - unix_timestamp(date_start)) as division")
                ->selectRaw(" ((unix_timestamp(date_end)  - unix_timestamp(date_start)) * level_mood) as average_mood")
                ->selectRaw("((unix_timestamp(date_end)  - unix_timestamp(date_start)) * level_anxiety) as average_anxiety")
                ->selectRaw("((unix_timestamp(date_end)  - unix_timestamp(date_start)) * level_nervousness) as average_nervousness")
                ->selectRaw("((unix_timestamp(date_end)  - unix_timestamp(date_start)) * level_stimulation) as average_stimulation")
                ->selectRaw("count(moods_actions.id_moods)  as name ")
                ->selectRaw("moods.what_work  as what_work ")
                ->where("moods.id_users",$id)
                ->where("moods.date_start",">=",$this->dateStart)
                ->where("moods.date_start","<",$this->dateEnd)
                ->groupBy("moods.id")
                ->get();
   
    }
    
    public function downloadMoodPDF($dateFrom,$dateTo,$idUser) {
        $Moods = new AppMood;
        $this->initStartDay();
        $this->setHourMoodPDF($dateFrom,$dateTo);
        $this->listMoodPDF = $Moods->leftjoin("moods_actions","moods.id","moods_actions.id_moods")
                ->selectRaw(DB::Raw("(DATE(IF(HOUR(moods.date_start) >= '" . $this->startDay . "', moods.date_start,Date_add(moods.date_start, INTERVAL - 1 DAY) )) ) as dat"))
                ->selectRaw("moods.id as id")
                ->selectRaw("moods_actions.id_moods as actions")
                ->selectRaw("moods.date_start as date_start")
                ->selectRaw("moods.date_end as date_end")
                ->selectRaw("moods.level_mood as level_mood")
                ->selectRaw("moods.level_anxiety as level_anxiety")
                ->selectRaw("moods.level_nervousness as level_nervousness")
                ->selectRaw("moods.level_stimulation  as level_stimulation")
                ->selectRaw("moods.epizodes_psychotik as epizodes_psychotik")
                ->selectRaw("(unix_timestamp(date_end)  - unix_timestamp(date_start)) as division")
                ->selectRaw(" ((unix_timestamp(date_end)  - unix_timestamp(date_start)) * level_mood) as average_mood")
                ->selectRaw("((unix_timestamp(date_end)  - unix_timestamp(date_start)) * level_anxiety) as average_anxiety")
                ->selectRaw("((unix_timestamp(date_end)  - unix_timestamp(date_start)) * level_nervousness) as average_nervousness")
                ->selectRaw("((unix_timestamp(date_end)  - unix_timestamp(date_start)) * level_stimulation) as average_stimulation")
                ->selectRaw("count(moods_actions.id_moods)  as name ")
                ->selectRaw("moods.what_work  as what_work ")
                ->where("moods.id_users",$idUser)
                ->where("moods.date_start",">=",$this->dateStart)
                ->where("moods.date_start","<",$this->dateEnd)
                ->groupBy("moods.id")
                ->get();
    }
    
    public function downloadSleepPDF($dateFrom,$dateTo,$idUser) {
        $Sleep = new Sleep;
        //$this->setHourSleep($year,$month,$day);

        $this->listSleepPDF = $Sleep
                        ->where("id_users",$idUser)
                        ->where("date_start",">=",$dateFrom)
                        ->where("date_start","<",$dateTo)
                        ->get();
    }
    
    private function selectAverageMoods($listMood) {
        
        $array = [];
        $i = 0;
        $mood = 0;
        $anxiety = 0;
        $nervousness = 0;
        $stimulation = 0;
        $division = 0;
        foreach ($listMood as $list) {
            $mood += $list->average_mood;
            $anxiety += $list->average_anxiety;
            $nervousness += $list->average_nervousness;
            $stimulation += $list->average_stimulation;
            $division += $list->division;
            $i++;
        }
        if ($i == 0) {
            return;
        }
        
        $array["mood"] = round($mood   / $division,2);
        //if ($array["mood"] == -0) {
            //$array["mood"] = -$array["mood"];
        //}
        $array["anxiety"] = round($anxiety / $division,2);
        //if ($array["anxiety"] == -0) {
            //$array["anxiety"] = -$array["anxiety"];
        //}
        
        $array["nervousness"]  = round($nervousness / $division,2);
        //if ($array["nervousness"] == -0) {
            //$array["nervousness"] = -$array["nervousness"];
        //}
        
        $array["stimulation"] = round($stimulation / $division,2);
        //if ($array["stimulation"] == -0) {
            //$array["stimulation"] = -$array["stimulation"];
        //}
        return $array;
    }
    public function downloadSleep($year,$month,$day,$id) {
        $Sleep = new Sleep;
        $this->setHourSleep($year,$month,$day);

        $this->listSleep = $Sleep
                        ->where("id_users",$id)
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
    private function setHourMoodPDF($dateFrom,$dateTo,$bool = false) {
        $second = strtotime($dateFrom . " " . $this->startDay . ":00:00");
        
        $second2 = strtotime($dateTo . " " . $this->startDay . ":00:00");
        if ($bool == false) {
            $this->dateStart = date("Y-m-d H:i:s",$second);
            $this->dateEnd = date("Y-m-d H:i:s",$second2);
        }
        else {
            return [date("Y-m-d H:i:s",$second),date("Y-m-d H:i:s",$second2)];
        }
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
    
    
    public function sumColorForMood($idUsers,$year,$month) {
        //$kalendar = new calendar($year, $month, $day, $action);
        $howDay = Calendar::check_month($month,$year);
        $Action = new ServicesAction;

            for ($i=0;$i < $howDay;$i++) {
                
                $this->colorForMonth[$i] = $this->downloadMoods($idUsers,$year,$month,$i+1);
                $tmp2 = $this->setColor($this->colorForMonth[$i]);
                //var_dump($tmp2);
                if ( $tmp2 == 1000) {
                    $Action->downloadAction($idUsers,$year,$month,$i+1);
                    if (count($Action->listActionMood) == 0) {
                        $this->color[$i] = 10000;
                    }
                    else {
                        $this->color[$i]  = 100;
                    }
                    
                }
                else {
                    $this->color[$i] = $tmp2;
                }
                

            }
        
    }
    public function sumColorForMoodDay($idUsers,$year,$month,$day) {
        
   
        
            $array = $this->downloadMoods($idUsers,$year,$month,$day);
            $this->DayList = $array;
            $this->colorDay["mood"] = $this->setColor($array);
            $this->colorDay["anxiety"] = -$this->setColor($array,"anxiety");
            $this->colorDay["nervousness"] = -$this->setColor($array,"nervousness");
            $this->colorDay["stimulation"] = $this->setColor($array,"stimulation");
        
        
        }
    public function sumColorForMoodDayPDF($idUsers,$dateFrom,$dateTo) {
        
   
        
            $array = $this->downloadMoodsPDF($idUsers,$dateFrom,$dateTo);
            $this->DayList = $array;
            $this->colorDay["mood"] = $this->setColor($array);
            $this->colorDay["anxiety"] = -$this->setColor($array,"anxiety");
            $this->colorDay["nervousness"] = -$this->setColor($array,"nervousness");
            $this->colorDay["stimulation"] = $this->setColor($array,"stimulation");
        
        
        }
    public function sortMoodsSleep($listMoods,$listSleep,$whatWork,$bool = false) :bool {
        
        $arraySecond = [];
        $this->i = 0;
        $this->sortMoods($listMoods,$whatWork);
        $this->sortSleep($listSleep);

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
    public function sumPercent(int $second,array $list) {
        for ($i=0;$i < count($list);$i++) {
            $list[$i]["percent"] = round(($list[$i]["second"] / $second) * 100);
            if ($list[$i]["percent"] == 0) {
                $list[$i]["percent"] = 1;
            }
            $list[$i]["second"] = $this->changeSecondAtHour($list[$i]["second"] / 3600);
            
        }
        return $list;
    }
    public function changeSecondAtHour($hour) {
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
    private function sortSleep($listSleep) {
          foreach ($listSleep as $Sleeps) {

            $this->arrayList[$this->i]["date_start"] = $Sleeps->date_start;
            $this->arrayList[$this->i]["date_end"] = $Sleeps->date_end;
            $this->arrayList[$this->i]["second"] = strtotime($Sleeps->date_end) - strtotime($Sleeps->date_start);
            $this->arraySecond[$this->i] = $this->arrayList[$this->i]["second"];
            $this->arrayList[$this->i]["epizodes_psychotik"] = $Sleeps->how_wake_up;
            $this->arrayList[$this->i]["type"] = 0;
            $this->arrayList[$this->i]["percent"] = 0;
            $this->arrayList[$this->i]["level_mood"] = 0;
            $this->arrayList[$this->i]["level_anxiety"] = 0;
            $this->arrayList[$this->i]["level_nervousness"] = 0;
            $this->arrayList[$this->i]["level_stimulation"] = 0;
            $this->arrayList[$this->i]["nas"] = $Sleeps->nas;
            $this->arrayList[$this->i]["nas2"] = $Sleeps->nas2;
            $this->arrayList[$this->i]["nas3"] = $Sleeps->nas3;
            $this->arrayList[$this->i]["nas4"] = $Sleeps->nas4;
            $this->arrayList[$this->i]["color_nas"] = $this->setColor(array("mood"=>$Sleeps->nas));
            $this->arrayList[$this->i]["color_mood"] = 0;
            $this->arrayList[$this->i]["color_anxiety"] = 0;
            $this->arrayList[$this->i]["color_nervousness"] = 0;
            $this->arrayList[$this->i]["color_stimulation"] = 0;
            $this->arrayList[$this->i]["what_work"] = false;
            $this->arrayList[$this->i]["drugs"] = 0;
            $this->arrayList[$this->i]["id"] = $Sleeps->id;
                   $this->arrayList[$this->i]["year"] = $Sleeps->year;
                   $this->arrayList[$this->i]["month"] = $Sleeps->month;
                   $this->arrayList[$this->i]["day"] = $Sleeps->day;
                   $this->arrayList[$this->i]["dat"] = $Sleeps->dat;
            $this->i++;
        }
    }
    
    
    public function setColor($array,$type = "mood") {
        if (empty($array)) {
            return 1000;
        }
        if ($array[$type] >= -20  and  $array[$type] < -16) {
            return -10;
        }
        if ($array[$type] >= -16  and  $array[$type] < -11) {
            return -9;
        }
        if ($array[$type] >= -11  and  $array[$type] < -7) {
            return -8;
        }
        if ($array[$type] >= -7  and  $array[$type] < -2) {
            return -7;
        }
        if ($array[$type] >= -2  and  $array[$type] < -1) {
            return -6;
        }
        if ($array[$type] >= -1  and  $array[$type] < -0.5) {
            return -5;
        }
        if ($array[$type] >= -0.5  and  $array[$type] < -0.2) {
            return -4;
        }
        if ($array[$type] >= -0.2  and  $array[$type] < -0.1) {
            return -3;
        }
        if ($array[$type] >= -0.1  and  $array[$type] < -0.05) {
            return -2;
        }
        if ($array[$type] >= -0.05  and  $array[$type] < 0) {
            return -1;
        }
        if ($array[$type] >= 0  and  $array[$type] < 0.03) {
            return 0;
        }
        if ($array[$type] >= 0.03  and  $array[$type] < 0.1) {
            return 1;
        }
        if ($array[$type] >= 0.1  and  $array[$type] < 0.2) {
            return 2;
        }
        if ($array[$type] >= 0.2  and  $array[$type] < 0.3) {
            return 3;
        }
        if ($array[$type] >= 0.3  and  $array[$type] < 0.5) {
            return 4;
        }
        if ($array[$type] >= 0.5  and  $array[$type] < 1) {
            return 5;
        }
        if ($array[$type] >= 1  and  $array[$type] < 3) {
            return 6;
        }
        if ($array[$type] >= 3  and  $array[$type] < 8) {
            return 7;
        }
        if ($array[$type] >= 8  and  $array[$type] < 12) {
            return 8;
        }
        if ($array[$type] >= 12  and  $array[$type] < 16) {
            return 9;
        }
        if ($array[$type] >= 16  and  $array[$type] <= 20) {
            return 10;
        }

    }    
    
    
    private function sortMoods($listMoods,$whatWork) {
        //$this->howAction = 0;
        foreach ($listMoods as $Moodss) {
            
            $this->arrayList[$this->i]["date_start"] = $Moodss->date_start;
            $this->arrayList[$this->i]["date_end"] = $Moodss->date_end;
            $this->arrayList[$this->i]["second"] = strtotime($Moodss->date_end) - strtotime($Moodss->date_start);
            $this->arraySecond[$this->i] = $this->arrayList[$this->i]["second"];
            $this->arrayList[$this->i]["level_mood"] = $Moodss->level_mood;
            $this->arrayList[$this->i]["level_anxiety"] = $Moodss->level_anxiety;
            $this->arrayList[$this->i]["level_nervousness"] = $Moodss->level_nervousness;
            $this->arrayList[$this->i]["level_stimulation"] = $Moodss->level_stimulation;
            $this->arrayList[$this->i]["nas"] = $Moodss->nas;
            $this->arrayList[$this->i]["nas2"] = $Moodss->nas2;
            $this->arrayList[$this->i]["nas3"] = $Moodss->nas3;
            $this->arrayList[$this->i]["nas4"] = $Moodss->nas4;
            $this->arrayList[$this->i]["color_nas"] = $this->setColor(array("mood"=>$Moodss->nas));
            $this->arrayList[$this->i]["color_mood"] = $this->setColor(array("mood"=>$this->arrayList[$this->i]["level_mood"]));
            $this->arrayList[$this->i]["color_anxiety"] = -$this->setColor(array("mood"=>$this->arrayList[$this->i]["level_mood"],"anxiety"));
            $this->arrayList[$this->i]["color_nervousness"] = -$this->setColor(array("mood"=>$this->arrayList[$this->i]["level_mood"],"nervousness"));
            $this->arrayList[$this->i]["color_stimulation"] = $this->setColor(array("mood"=>$this->arrayList[$this->i]["level_mood"],"stimulation"));
            
            $this->arrayList[$this->i]["name"] = $Moodss->name;
            //$this->howAction += $Moodss->name;
            if ($whatWork == "on") {
                $this->arrayList[$this->i]["what_work"] = Common::charset_utf_fix($Moodss->what_work,true);
                
            }
            else if ($Moodss->what_work != "" and $whatWork == "off") {
                $this->arrayList[$this->i]["what_work"] = true;
            }
            else {
                $this->arrayList[$this->i]["what_work"] = false;
            }

            $this->arrayList[$this->i]["epizodes_psychotik"] = $Moodss->epizodes_psychotik;
            $this->arrayList[$this->i]["type"] = 1;
            $this->arrayList[$this->i]["percent"] = 0;
            $this->arrayList[$this->i]["id"] = $Moodss->id;
                   $this->arrayList[$this->i]["year"] = $Moodss->year;
                   $this->arrayList[$this->i]["month"] = $Moodss->month;
                   $this->arrayList[$this->i]["day"] = $Moodss->day;
                   $this->arrayList[$this->i]["dat"] = $Moodss->dat;
            $this->i++;
        }
    }

    public function updateDescription(Request $request) {
        $Mood = new AppMood;
        $Mood->where("id",$request->get('id'))->update(["what_work" => str_replace("\n", "<br>", $request->get("description"))]);
    }
    public function deleteMood(Request $request) {
        $MoodsAction = new Moods_action;
        $MoodsAction->where("id_moods",$request->get("id"))->delete();
        $Mood = new AppMood;
        $Mood->where("id",$request->get("id"))->where("id_users",Auth::User()->id)->delete();
    }
    public function deleteSleep(Request $request) {
        $Sleep = new Sleep;
        $Sleep->where("id",$request->get("id"))->where("id_users",Auth::User()->id)->delete();
    }
    
    public function selectMood(Request $request) {
        $Mood = new AppMood;
        $mood = $Mood->where("id",$request->get("id"))->first();
        return $mood;
    }
    public function updateMood(Request $request) {
        $Mood = new AppMood;
        $Mood->where("id_users",Auth::User()->id)->where("id",$request->get("id"))->update(["level_mood" => $request->get("levelMood"),
            "level_anxiety" => $request->get("levelAnxiety"),
            "level_nervousness" => $request->get('levelNervousness'),
            "level_stimulation" => $request->get("levelStimulation")]);
    }
    public function updateSleep(Request $request) {
        
        
            $Sleep = New Sleep;
            $Sleep->where("id",$request->get("id"))->where("id_users",Auth::User()->id)->update(["how_wake_up"=>$request->get("sleep")]);
        
        
        
    }
    public function IfInt($number,string $what) {
        
        
        if ($number == "") {
            return;
        }
        
 
        
        if (strstr($number,".")) {
            array_push($this->errors, $what . " nie jest liczbą całkowitą");
        }
        if (!is_numeric($number)) {
            array_push($this->errors, $what . " nie jest liczbą");
        }
        else if ($number < 0) {
            array_push($this->errors, $what . " nie jest liczbą dodatnią");
        }

    }
    public function checkLevel($level,string $what) {
        if ($level == "") {
            array_push($this->level, 0);
            return;
        }
        if (!is_numeric($level)) {
            array_push($this->errors, $what . " nie jest liczbą");
        }
        else if ($level > 20 or $level < -20) {
            array_push($this->errors, $what . " musi się mieścić w przedziele od -20 do +20");
        }
        else {
            array_push($this->level, $level);
        }
    }
}