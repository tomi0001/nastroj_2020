<?php

namespace App\Http\Services;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Input as Input;
use Auth;

use Illuminate\Support\Facades\Password as Password;
use Hash;
use DB;
use App\User as Users;
use App\Mood as Moods;
use App\Sleep as Sleep;
use App\Http\Services\Common as Common;
use App\Http\Services\Calendar as kalendar;


class AIMood {
    public $arrayAI = [];
    public $z = 0;
    public $j = 0;
    public $second = 0;
    public $d = 0;
    public $days = [];
    public $harmony = [];
    public $tableMood = [];
    public $tableAnxiety = [];
    public $tableStimu = [];
    public $tableNer = [];
    public $hourStart = "";
    public $hourEnd = "";
    public $dateStart = "";
    public $dateEnd = "";
    public function setDate($dateStart,$dateEnd) {
        $Mood = new Moods;
        if ($dateStart == "") {
            $tmp = explode(" ",$Mood->select("date_start")->orderBy("date_start")->first()->date_start);
            $this->dateStart = $tmp[0];
        }
        else {
            $this->dateStart = $dateStart;
        }
        if ($dateEnd == "") {
            $tmp = explode(" ",$Mood->select("date_end")->orderBy("date_end","DESC")->first()->date_end);
            $this->dateEnd = $tmp[0];
        }
        else {
            $this->dateEnd = $dateEnd;
        }
    }
    
    public function setTime($hourStart,$hourEnd) {
        $timeFrom = explode(":",$hourStart);
        $timeTo = explode(":",$hourEnd);
        if ($hourStart != "") {
            $this->hourStart = $this->sumHour($timeFrom);
        }
        else {
            $hourOne= Auth::User()->start_day . ":00:00";
            $this->hourStart = $this->sumHour(explode(":",$hourOne));
        }
        if ($hourEnd != "") {
            $this->hourEnd = $this->sumHour($timeTo);
        }
        else {
            $hourOne = $this->subSecond(Auth::User()->start_day . ":00:00");
            $this->hourEnd = $this->sumHour(explode(":",$hourOne));
        }
    }
    
    private function subSecond($hour) {
        $hour1 = explode(":", $hour);
        $newHour = [];
        if ($hour1[0] == 0) {
            $newHour[0] = 23; 
        }
        else {
            $newHour[0] = $hour1[0] - 1;
        }
        $newHour[1] = 59;
        return $newHour[0] . ":" . $newHour[1] . ":00";
    }
    public function  selectDays($dataStart,$dataEnd,$type,$day,$id,$dayInput = "") {
        $daystart = strtotime($this->dateStart) + (Auth::User()->start_day * 3600);
        $dayend = strtotime($this->dateEnd) + (Auth::User()->start_day * 3600) + 84600;
        $days = [];
        $sumNer = 0;
        $sumAnxiety = 0;
        $sumMood = 0;
        $sumStimu = 0;
        $z = 1;
        $j = 0;
        for ($i = $daystart;$i <= $dayend;$i += 86400 ) {
            if (  $day != "") {
                if (date('N', $i) != $day) {
                
                    continue;
                }
            }
            $check = $this->check(date("Y-m-d H:i:s",$i),date("Y-m-d H:i:s",$i+86400),$id);
           
            if ($check == false) {
                continue;
            }
            else {
                $days[0][$j] = $this->calculateAverage(date("Y-m-d H:i:s",$i),date("Y-m-d H:i:s",$i+86400),"mood",$id);
                $days[1][$j] = $this->calculateAverage(date("Y-m-d H:i:s",$i),date("Y-m-d H:i:s",$i+86400),"anxiety",$id);
                $days[2][$j] = $this->calculateAverage(date("Y-m-d H:i:s",$i),date("Y-m-d H:i:s",$i+86400),"ner",$id);
                $days[3][$j] = $this->calculateAverage(date("Y-m-d H:i:s",$i),date("Y-m-d H:i:s",$i+86400),"stimulation",$id);
                $tmp = $this->minMaxcalculate(date("Y-m-d H:i:s",$i),date("Y-m-d H:i:s",$i+86400),"mood",$id);
                $days[4][$j] = $tmp[0];
                $days[5][$j] = $tmp[1];
            }
            $sumMood += $days[0][$j];
            $sumAnxiety += $days[1][$j];
            $sumNer += $days[2][$j];
            $sumStimu += $days[3][$j];
           

            $this->days[$j] = date("Y-m-d",$i);
            $j++;
        }
        $minDay = min($days[4]);
        $maxDay = max($days[5]);
        if ($dayInput == "on") {
            if ($j == 0) {
                return 0;
            }
            return [round($sumMood / $j,2),
                round($this->sortMood((($days[0]) )) ,2)
                ,round($sumAnxiety / $j,2)
                ,round($this->sortMood((($days[1]) )),2)
                ,round($sumNer / $j,2)
                ,round($this->sortMood((($days[2]) )),2)
                ,round($sumStimu / $j,2)
                ,round($this->sortMood((($days[3]) )),2),
                $minDay,$maxDay];
            
        }
        
        return $days;
    }
    private function check($dataStart,$dataEnd,$id) {
        $Moods = Moods::query();        
        $hour = Auth::User()->start_day;
                $Moods->select(DB::Raw("(DATE(IF(HOUR(date_start) >= '$hour', date_start,Date_add(date_start, INTERVAL - 1 DAY) )) ) as dat  "))
               ->selectRaw("Date_add(date_start, INTERVAL - '$hour' HOUR)  as date_start")
                ->selectRaw("Date_add(date_end, INTERVAL - '$hour' HOUR)  as date_end")
                ->selectRaw("level_anxiety as level_anxiety")
                ->selectRaw("level_nervousness as level_nervousness")
                ->selectRaw("level_stimulation as level_stimulation")
                ->selectRaw("level_mood as level_mood")
                        
                
                      ->where("id_users",$id);
        if ($dataStart != "") {
            $Moods->where("date_start",">=",$dataStart);
            $Moods->where("date_start","<=",$dataEnd);
        }


            $Moods->whereRaw("(time(date_add(date_start,INTERVAL - $hour hour))) < '" .$this->hourEnd . "'");
            $Moods->whereRaw("(time(date_add(date_end,INTERVAL - $hour hour))) >= '" . $this->hourStart . "'");   

        $list = $Moods->count();
        if ($list == 0) {
            return false;
        }
        else {
            return true;
        }
    }
    
    public function returnTime($time , $bool) {
        if ($time == "" and $bool == 0) {
            return "początek";
        }
        else if ($time == "" and $bool == 1) {
            return "koniec";
        }
        else {
            return $time;
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

    private function minMaxcalculate($dataStart,$dataEnd,$type,$id,$dayInput = "") {
        $hour = Auth::User()->start_day;
        $average = 0;
        $second = 0;
        $sumMood = 0;
        $sumAnxiety = 0;
        $sumNer = 0;
        $sumStimu = 0;
        $harmonyMood = [];
        $harmonyStimu = [];
        $harmonyNer = [];
        $harmonyAnxiety = [];
        $Moods2 = Moods::query();
        $Moods2->select(DB::Raw("(DATE(IF(HOUR(date_start) >= '$hour', date_start,Date_add(date_start, INTERVAL - 1 DAY) )) ) as dat  "))

                ->selectRaw("MIN(level_mood) as min")
                ->selectRaw("MAX(level_mood) as max")

                      ->where("id_users",$id);
        if ($dataStart != "") {
            $Moods2->where("date_start",">=",$dataStart);
            $Moods2->where("date_start","<=",$dataEnd);
        }


            $Moods2->whereRaw("(time(date_add(date_start,INTERVAL - $hour hour))) < '" .$this->hourEnd . "'");
            $Moods2->whereRaw("(time(date_add(date_end,INTERVAL - $hour hour))) >= '" .$this->hourStart . "'");   
        $list2 = $Moods2->first();
        return array($list2->min,$list2->max);
    }
    
    private function calculateAverage($dataStart,$dataEnd,$type,$id,$dayInput = "") {
        $Moods = Moods::query();
        $hour = Auth::User()->start_day;
        $average = 0;
        $second = 0;
        $sumMood = 0;
        $sumAnxiety = 0;
        $sumNer = 0;
        $sumStimu = 0;
        $harmonyMood = [];
        $harmonyStimu = [];
        $harmonyNer = [];
        $harmonyAnxiety = [];

        $Moods->select(DB::Raw("(DATE(IF(HOUR(date_start) >= '$hour', date_start,Date_add(date_start, INTERVAL - 1 DAY) )) ) as dat  "))
               ->selectRaw("Date_add(date_start, INTERVAL - '$hour' HOUR) as date_start")
                ->selectRaw("Date_add(date_end, INTERVAL - '$hour' HOUR) as date_end")
                ->selectRaw("time(Date_add(date_end,INTERVAL - '$hour' HOUR)) as d")
                ->selectRaw("level_anxiety as level_anxiety")
                ->selectRaw("level_nervousness as level_nervousness")
                ->selectRaw("level_stimulation as level_stimulation")
                ->selectRaw("level_mood as level_mood")

                      ->where("id_users",$id);
        if ($dataStart != "") {
            $Moods->where("date_start",">=",$dataStart);
            $Moods->where("date_start","<",$dataEnd);
        }


            $Moods->whereRaw("time(Date_add(date_start,INTERVAL - '$hour' HOUR)) < '" .$this->hourEnd . "'");
            $Moods->whereRaw("time(Date_add(date_end,INTERVAL - '$hour' HOUR)) >= '" .$this->hourStart . "'");   

        
        $list = $Moods->get();

        $i = 0;
        
        foreach ($list as $moodss) {
            $time1 = strtotime($moodss->date_start);
            $time2 = strtotime($moodss->date_end);


             $divi1 = explode(" ",$moodss->date_start);
             $divi2 = explode(" ",$moodss->date_end);
 
                $dataa = explode(" ",$dataEnd);

                    $dateComparate1 = strtotime($divi1[0] . " " . $this->hourStart );

                $dateComparate2 = strtotime($divi2[0] . " " . $this->hourEnd);

            if ($time1 <= $dateComparate1) {
                $div = $dateComparate1;
                
            }
            else {
                $div = $time1;
            }
            if ($time2 >= $dateComparate2) {
                $div2 = $dateComparate2;
            }
            else {
                $div2 = $time2;
            }


                    $sumAnxiety += ($div2 - $div) * $moodss->level_anxiety;
                    $harmonyAnxiety[$i] = $moodss->level_anxiety;
                    

                    $sumNer += ($div2 - $div) * $moodss->level_nervousness;
                    $harmonyNer[$i] =  $moodss->level_nervousness;

                    $sumStimu += ($div2 - $div) *  $moodss->level_stimulation;
                    $harmonyStimu[$i] = $moodss->level_stimulation;

                    $sumMood += ($div2 - $div) * $moodss->level_mood;
                    $harmonyMood[$i] =  $moodss->level_mood;
                
            $second += $div2 - $div;

            $i++;
        }
        if ($i == 0) {
            //return;
        }
                 if ($type == "anxiety") {
                     
        array_push($this->tableAnxiety,round(($this->sortMood($harmonyAnxiety) ),2));
         }
         else if ($type=="ner") {
        array_push($this->tableNer,round(($this->sortMood($harmonyNer) ),2));
         }
         else if ($type=="stimulation") {
        array_push($this->tableStimu,round(($this->sortMood($harmonyStimu) ),2));
         }
         else {
        array_push($this->tableMood,round(($this->sortMood($harmonyMood) ),2));
        }


         
          if ($second == 0) {
              return 0;
          }
         

        if ($type == "mood") {
            return round($sumMood  / $second,2);
        }
        else if ($type=="anxiety") {
            return round($sumAnxiety  / $second,2);
        }
        else if ($type=="ner") {
            return round($sumNer  / $second,2);
        }
        else  {
            return round($sumStimu  / $second,2);
        }

    }
 
    
    public function sortMoodOld($list) {

        $sort = $list;
        if (count($sort) % 2 == 1) {
            $average = array_sum($sort)/count($sort);
            array_push($sort, $average);
        }
        asort($sort);
        $count = count($sort)-1;
        $tmp = 0;
        $tmp2 = 0;

        for ($i=0;$i < count($sort) / 2;$i++) {
            $tmp = $sort[$count] - $sort[$i];

            //}
            $count--;
            if ($tmp < 0) {
                $tmp = -$tmp;
            }
            $tmp2 += $tmp;
        }
        if (count($sort) == 0)  {
            return 0;
        }      
        return ((($tmp2 / count($sort)) * 5));
        
    }
    
    public function sortMood($list) {
        
        $tmp = 0;
        $tmp2 = 0;       
        for ($i=0;$i < count($list)-1;$i++) {

           
                $tmp = ((((($list[$i]) )) ) -  ((($list[$i+1] ) )  ));
            if ($tmp < 0) {
                $tmp = -$tmp;
            }
            $tmp2 += ($tmp  * 5);
        }
        $average = array_sum($list) / 5;
        if ($average == 0) {
            $average = 0.5;
        }
        if (count($list) == 0) {
            return;
        }
        if ((((($tmp2 / count($list))) ) ) < 0) {
            return -(((($tmp2 / count($list))) ));
        }
        return  ((($tmp2 / count($list))) );
    }
    
    public function standardDeviation($list) {
            $n=count($list);
            $average=0;

            for($i=0;$i<$n;$i++)
            {
                $average += $list[$i];
            }

            $average /= $n;

            for($i=0;$i<$n;$i++)
            {
                $standardDeviation=$list[$i]-$average; // tutaj do zmiennej $wyraz_srednia przypisujesz roznice danej liczby i sredniej wszystkich liczb

                $list2[$i]= $standardDeviation * $standardDeviation;
            }
            $result = 0;
            for($i=0;$i<$n;$i++)
            {
                $result+=$list2[$i]; //dostajesz sume tych wszystkich kwadratow roznicy wyrazu i sredniej;
            }
            return sqrt($result);
            
    }
            
            

}