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
use DateTime;

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
    public $list;
    public $countList;
    public $IdUsers;
    public $bool = false;
    
    function __construct($idUsers) {
        $this->IdUsers = $idUsers;
        
    }
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
            $this->bool = true;
        }
        else {
            $hourOne= Auth::User()->start_day . ":00:00";
            $this->hourStart = $this->sumHour(explode(":",$hourOne));
        }
        if ($hourEnd != "") {
            $this->hourEnd = $this->sumHour($timeTo);
            $this->bool = true;
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
    
    
    public function selectWeek() {
        $daystart = strtotime($this->dateStart) + (Auth::User()->start_day * 3600);
        $dayend = strtotime($this->dateEnd) + (Auth::User()->start_day * 3600) + 84600;
        $days = [];
        $days2 = [];

        $z = 1;
        $u = 0;
        $d = 0;
        
        $sum = 0;
        for ($i = $daystart;$i <= $dayend;$i += 604800 ) {
            $sumNer = 0;
            $sumAnxiety = 0;
            $sumMood = 0;
            $sumStimu = 0;
            $t = 0;
            $tmp2 =[];
            $tmp3 = [];
            $tmp4 = [];
            $tmp5  =[];
            $tmp6 = [];
          for ($j=0;$j <= 604800 - 86400;$j+= 86400) {
              if ($i+$j >= $dayend) {
                  break;
              }
      
            
            $check = $this->check(date("Y-m-d H:i:s",$j+$i),date("Y-m-d H:i:s",$j+$i+86400),$this->IdUsers);
           
            if ($check == false) {
                continue;
            }
            else {
                $tmp2 = $this->calculateAverage(date("Y-m-d H:i:s",$j+$i),date("Y-m-d H:i:s",$j+$i+86400),$this->IdUsers);
                if (!empty($tmp2)) {
                    $days[0][$u] = $tmp2[0];
                    $days[1][$u] = $tmp2[1];
                    $days[2][$u] = $tmp2[2];
                    $days[3][$u] = $tmp2[3];
                    array_push($tmp3,$days[0][$u]);
                    array_push($tmp4,$days[1][$u]);
                    array_push($tmp5,$days[2][$u]);
                    array_push($tmp6,$days[3][$u]);
                }

            }
            $sumMood += $days[0][$u];
            $sumAnxiety += $days[1][$u];
            $sumNer += $days[2][$u];
            $sumStimu += $days[3][$u];
       
           

           
            $u++;
            $t++;
            
          }
         $tmp = $this->minMaxcalculate(date("Y-m-d H:i:s",$i),date("Y-m-d H:i:s",$i+604800),"mood",$this->IdUsers);
         if ($t == 0) {
             $t = 1;
         }
         
            $days2[0][$d] = $sumMood/ $t;
            $days2[1][$d] = $sumAnxiety /  $t;
            $days2[2][$d] =  $sumNer / $t;
            $days2[3][$d] = $sumStimu / $t;
            $days2[4][$d] = $tmp[0];
            $days2[5][$d] = $tmp[1];
            $days2[6][$d] = round($this->sortMood($tmp3) ,2);
            $days2[7][$d] = round($this->sortMood($tmp4) ,2);
            $days2[8][$d] = round($this->sortMood($tmp5) ,2);
            $days2[9][$d] = round($this->sortMood($tmp6) ,2);
            //if ($i != $daystart) {
              //  $sum = 86400;
            //}
           $this->days[$d] = date("Y-m-d",$i ) . "-" . date("Y-m-d",$i + 604800 - 86400 );
           $d++;
        }
        
        return $days2;
        
    }
    
    
    public function selectMonth($day) {
        
        $div = explode("-",$this->dateStart);
        $div[2] = "01";
        
        $daystart = strtotime($div[0] . "-" . $div[1] . "-" . $div[2]) + (Auth::User()->start_day * 3600);
        $firstDate = new DateTime($this->dateStart);
        $secondDate = new DateTime($this->dateEnd);
        $diff = $firstDate->diff($secondDate);
        
        $this->j = 0;
        $array = [];
        $month = $div[1];
        $year = $div[0];
        $howMonth =  (12 * $diff->y) + $diff->m;;
        for ($i = 0;$i<=$howMonth;$i++) {
            

            $daysMonth = kalendar::check_month($month, $year);
            print $month . " ";
            $array[$i] = $this->selectDaysMonth($year . "-" . $month . "-01",$year . "-" . $month . "-" . $daysMonth ,$day);
            $arrays = Common::return_next_month($month, $year);
            $year = $arrays[0];
            $month = $arrays[1];
            $this->j++;
        }
             
             
        
        
        return $array;        
    }
    public function  selectDaysAll($day) {
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
            $check = $this->check(date("Y-m-d H:i:s",$i),date("Y-m-d H:i:s",$i+86400));
           
            if ($check == false) {
                continue;
            }
            else {
                $tmp2 = $this->calculateAverage(date("Y-m-d H:i:s",$i),date("Y-m-d H:i:s",$i+86400));
                if (empty($tmp2)) {
                    continue;
                }
                    $days[0][$j] = $tmp2[0];
                    $days[1][$j] = $tmp2[1];
                    $days[2][$j] = $tmp2[2];
                    $days[3][$j] = $tmp2[3];
                    $tmp = $this->minMaxcalculate(date("Y-m-d H:i:s",$i),date("Y-m-d H:i:s",$i+86400),"mood");
                    $days[4][$j] = $tmp[0];
                    $days[5][$j] = $tmp[1];
                
                //$days[6][$j] = $this->sumDifferences();
            }
            $sumMood += $days[0][$j];
            $sumAnxiety += $days[1][$j];
            $sumNer += $days[2][$j];
            $sumStimu += $days[3][$j];
           

            //$this->days[$j] = date("Y-m-d",$i);
            $j++;
        }
        $minDay = min($days[4]);
        $maxDay = max($days[5]);
        
            if ($j == 0) {
                return 0;
            }
            //return [round($sumMood / $j,2),round($sumAnxiety / $j,2),round($sumNer / $j,2),round($sumStimu / $j,2),$minDay,$maxDay];
            
            return [round($sumMood / $j,2),
                round($this->sortMood((($days[0]) )) ,2)
                ,round($sumAnxiety / $j,2)
                ,round($this->sortMood((($days[1]) )),2)
                ,round($sumNer / $j,2)
                ,round($this->sortMood((($days[2]) )),2)
                ,round($sumStimu / $j,2)
                ,round($this->sortMood((($days[3]) )),2),
                $minDay,$maxDay];
            
             
             
        
        
        return $days;
    }
    



    
    private function  selectDaysMonth($dateStarts,$dateEnds,$day) {
        $daystart = strtotime($dateStarts) +  (Auth::User()->start_day * 3600);
        $dayend = strtotime($dateEnds) + (Auth::User()->start_day * 3600);  
        $days = [];
        $sumNer = 0;
        $sumAnxiety = 0;
        $sumMood = 0;
        $sumStimu = 0;
        $days2 = [];
        $z = 1;
        $j = 0;
        for ($i = $daystart;$i <= $dayend;$i += 86400 ) {
            if (  $day != "") {
                if (date('N', $i) != $day) {
                
                    continue;
                }
            }
            $check = $this->check(date("Y-m-d H:i:s",$i),date("Y-m-d H:i:s",$i+86400));
           
            if ($check == false) {
                continue;
            }
            else {
                $tmp2 = $this->calculateAverage(date("Y-m-d H:i:s",$i),date("Y-m-d H:i:s",$i+86400));
                if (empty($tmp2)) {
                    continue;
                }
                    $days[0][$j] = $tmp2[0];
                    $days[1][$j] = $tmp2[1];
                    $days[2][$j] = $tmp2[2];
                    $days[3][$j] = $tmp2[3];
                    $tmp = $this->minMaxcalculate(date("Y-m-d H:i:s",$i),date("Y-m-d H:i:s",$i+86400),"mood");
                    $days[4][$j] = $tmp[0];
                    $days[5][$j] = $tmp[1];
                
                //$days[6][$j] = $this->sumDifferences();
            }
            $sumMood += $days[0][$j];
            $sumAnxiety += $days[1][$j];
            $sumNer += $days[2][$j];
            $sumStimu += $days[3][$j];
           

            //$this->days[$j] = date("Y-m-d",$i);
            $j++;
        }
        $this->days[$this->j] = date("Y-m",$daystart);
        
        $minDay = min($days[4]);
        $maxDay = max($days[5]);
        
            if ($j == 0) {
                return 0;
            }
            //return [round($sumMood / $j,2),round($sumAnxiety / $j,2),round($sumNer / $j,2),round($sumStimu / $j,2),$minDay,$maxDay];
            
            //print "<br>" . ($j)  ."<br>";
            
            $days2[0] = $sumMood / ($j);
            $days2[1] = $sumAnxiety /  ($j);
            $days2[2] =  $sumNer / ($j) ;
            $days2[3] = $sumStimu / ($j) ;
            $days2[4] = $minDay;
            $days2[5] = $maxDay;
            $days2[6] = round($this->sortMood($days[0]) ,2);
            $days2[7] = round($this->sortMood($days[1]) ,2);
            $days2[8] = round($this->sortMood($days[2]) ,2);
            $days2[9] = round($this->sortMood($days[3]) ,2);
            
            //var_dump($days2);
            
            return $days2;
            
             
             
    }


    
    
    
    public function  selectDays($day) {
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
            $check = $this->check(date("Y-m-d H:i:s",$i),date("Y-m-d H:i:s",$i+86400));
           
            if ($check == false) {
                continue;
            }
            else {
                $tmp2 = $this->calculateAverage(date("Y-m-d H:i:s",$i),date("Y-m-d H:i:s",$i+86400));
                if (empty($tmp2)) {
                    continue;
                }
                
                
        
                
                    $days[0][$j] = $tmp2[0];
                    $days[1][$j] = $tmp2[1];
                    $days[2][$j] = $tmp2[2];
                    $days[3][$j] = $tmp2[3];
                    $tmp = $this->minMaxcalculate(date("Y-m-d H:i:s",$i),date("Y-m-d H:i:s",$i+86400),"mood");
                    $days[4][$j] = $tmp[0];
                    $days[5][$j] = $tmp[1];
                
                
                //$days[6][$j] = $this->sumDifferences();
            }
            /*
            $sumMood += $days[0][$j];
            $sumAnxiety += $days[1][$j];
            $sumNer += $days[2][$j];
            $sumStimu += $days[3][$j];
           
             * 
             */

            $this->days[$j] = date("Y-m-d",$i);
            $j++;
        }
        $minDay = min($days[4]);
        $maxDay = max($days[5]);
            if ($j == 0) {
                return 0;
            }

        
        return $days;
    }
    private function check($dataStart,$dataEnd) {
        $Moods = Moods::query();        
        $hour = Auth::User()->start_day;
                $Moods->select(DB::Raw("(DATE(IF(HOUR(date_start) >= '$hour', date_start,Date_add(date_start, INTERVAL - 1 DAY) )) ) as dat  "))
               ->selectRaw("Date_add(date_start, INTERVAL - '$hour' HOUR)  as date_start")
                ->selectRaw("Date_add(date_end, INTERVAL - '$hour' HOUR)  as date_end")
                ->selectRaw("level_anxiety as level_anxiety")
                ->selectRaw("level_nervousness as level_nervousness")
                ->selectRaw("level_stimulation as level_stimulation")
                ->selectRaw("level_mood as level_mood")
                        
                
                      ->where("id_users",$this->IdUsers);
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
    
    public function returnTime($time, $bool) {
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

    private function minMaxcalculate($dataStart,$dataEnd,$type,$dayInput = "") {
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

                      ->where("id_users",$this->IdUsers);
        if ($dataStart != "") {
            $Moods2->where("date_start",">=",$dataStart);
            $Moods2->where("date_start","<=",$dataEnd);
        }


            $Moods2->whereRaw("(time(date_add(date_start,INTERVAL - $hour hour))) < '" .$this->hourEnd . "'");
            $Moods2->whereRaw("(time(date_add(date_end,INTERVAL - $hour hour))) >= '" .$this->hourStart . "'");   
        $list2 = $Moods2->first();
        return array($list2->min,$list2->max);
    }
    private function sumDifferences() {
        //print $this->countList ."<br>";
        if ($this->countList == 1) {
            return 0;
        }
        if (($this->countList % 2) == 0) {
            $diff = $this->countList -1;
        }
        else {
            $diff = $this->countList;
        }
        $diff2 = (int) $this->countList / 2;
        //$diff3 = (int) $this->countList / 3;
        $i = 0;
        $result["mood"] = 0;
        $result["anxienty"] = 0;
        $result["nervousness"] = 0;
        $result["stimulation"] = 0;
        $sumMood = 0;
        $sumAnxienty = 0;
        $sumNervousness = 0;
        $sumStimulation = 0;
                
        /*
        $sumMood2 = ($this->list["mood"][0] + $this->list["mood"][$this->countList-1]) / 2;
        $sumMood3 = ($this->list["mood"][0] + $this->list["mood"][$diff2]) / 2;
        $sumMood4 = ($this->list["mood"][$diff2] + $this->list["mood"][$this->countList-1]) / 2;
         * 
         */
        for ($i = 0;$i < count($this->list);$i++) {
            $sumMood += $this->list["mood"][$i];
            $sumAnxienty += $this->list["anxiety"][$i];
            $sumNervousness += $this->list["nervousness"][$i];
            $sumStimulation += $this->list["stimulation"][$i];
        }
            $sumMood = $sumMood  /$i;
            $sumAnxienty = $sumAnxienty / $i;
            $sumNervousness = $sumNervousness / $i;
            $sumStimulation = $sumStimulation  /$i;
        
        
        if ($sumMood > $this->list["mood"][0]) {
            $result["mood"] += 10;
        }
        
        if ($sumMood > $this->list["mood"][$diff2]) {
            $result["mood"] += 5;
        }
        if ($sumMood > $this->list["mood"][$this->countList-1]) {
            $result["mood"] += -10;
        }
        /*
        
        if ($sumMood < $this->list["mood"][0]) {
            $result["mood"] += 1;
        }
        
        if ($sumMood > $this->list["mood"][$this->countList-1]) {
            $result["mood"] += -1;
        }
         * 
         */
        /*
        else if ($sumMood == $this->list["mood"][0]) {
            $result["mood"] = 0;
        }
        else {
            $result["mood"] = 1;
        }
         
         * 
         */
        //print $result["mood"] . "<br>";
        //print $result["mood"] . "<br>";
        return $result;
    }
    private function calculateAverage($dataStart,$dataEnd,$dayInput = "") {
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

                      ->where("id_users",$this->IdUsers);
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
            $this->list["mood"][$i] = $moodss->level_mood;
            $this->list["anxiety"][$i] = $moodss->level_anxiety;
            $this->list["nervousness"][$i] = $moodss->level_nervousness;
            $this->list["stimulation"][$i] = $moodss->level_stimulation;
        
            $i++;
        }
        $this->countList = $i;
        if ($i == 0) {
            //return;
        }
                 //if ($type == "anxiety") {
                     
        array_push($this->tableAnxiety,round(($this->sortMood($harmonyAnxiety) ),2));
         //}
         //else if ($type=="ner") {
        array_push($this->tableNer,round(($this->sortMood($harmonyNer) ),2));
         //}
         //else if ($type=="stimulation") {
        array_push($this->tableStimu,round(($this->sortMood($harmonyStimu) ),2));
         //}
         //else {
        array_push($this->tableMood,round(($this->sortMood($harmonyMood) ),2));
        //}


         
          if ($second == 0) {
              return [];
          }
         
          $return = [];
        //if ($type == "mood") {
        array_push($return,round($sumMood  / $second,2));
            //return ;
        //}
        //else if ($type=="anxiety") {
        array_push($return,round($sumAnxiety  / $second,2));
            //return round($sumAnxiety  / $second,2);
        //}
        //else if ($type=="ner") {
            array_push($return,round($sumNer  / $second,2));
            //return round($sumNer  / $second,2);
        //}
        //else  {
            array_push($return,round($sumStimu  / $second,2));
            //return round($sumStimu  / $second,2);
        //}
            return $return;

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