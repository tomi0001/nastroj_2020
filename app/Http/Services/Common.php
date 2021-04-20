<?php
/*
 * copyright 2020 Tomasz Leszczyński tomi0001@gmail.com
 * 
 */


use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
namespace App\Http\Services;
use Auth;
use DB;
use App\Mood;
/**
 * Description of common
 *
 * @author tomi
 */
class common {
       
    public static function charset_utf_fix2($string) {

	$utf = array(
	  "Ą" =>"%u0104",
	  "Ć" => "%u0106",
	  "Ę"  => "%u0118",
	  "Ł" => "%u0141",
	  "Ń" => "%u0143",
	  "Ó" => "%D3",
	  "Ś" => "%u015A",
	  "Ź" => "%u0179",
	  "Ż" => "%u017B",
	  "ą" => "%u0105",
	  "ć" => "%u0107",
	  "ę" => "%u0119",
	  "ł" => "%u0142",
	  "ń" => "%u0144",
	  "ó" => "%F3",
	  "ś" => "%u015B",
	  "ź" => "%u017A",
	  "ż" => "%u017C",
          " " => "&nbsp",
            "\n" => "<br>"
            
	);
	
	return str_replace(array_keys($utf), array_values($utf), $string);
        
	
    }
    public static function diffDate($dateStart,$dateEnd) {
        $timeSecond2 = strtotime($dateEnd);
        $timeSecond = strtotime($dateStart);
        $result = ($timeSecond2 - $timeSecond) / 86400;
        if ($result == 0) {
            $result = round($result) + 1;
        }
        else {
            $result = round($result);
        }
        return $result;
    }
    public static function charset_utf_fix($string,$bool = false) {
 
	$utf = array(
	 "%u0104" => "Ą",
	 "%u0106" => "Ć",
	 "%u0118" => "Ę",
	 "%u0141" => "Ł",
	 "%u0143" => "Ń",
	 "%D3" => "Ó",
	 "%u015A" => "Ś",
	 "%u0179" => "Ź",
	 "%u017B" => "Ż",
	 "%u0105" => "ą",
	 "%u0107" => "ć",
	 "%u0119" => "ę",
	 "%u0142" => "ł",
	 "%u0144" => "ń",
	 "%F3" => "ó",
	 "%u015B" => "ś",
	 "%u017A" => "ź",
	 "%u017C" => "ż",
         "%20" => " ",
            "&nbsp" => " "
            
	);
	if ($bool == true) {
            $utf["<br>"] = "\n";
	 
                
        }
	return str_replace(array_keys($utf), array_values($utf), $string);
        
	
    }
    
    public static function sumMinutesHour($day,$hour,$minutes) {
        
        $hour2 = $hour - Auth::User()->start_day;
        
        if ($hour2 < 0) {
            $hour2 = 24 + $hour2;
        }
        return (int) ($hour2)  . $minutes;
    }
    public static function subHour($hourStart,$hourEnd) {
        $hourStart = explode(":",$hourStart);
        $hourEnd = explode(":",$hourEnd);
        if ($hourStart[0] == $hourEnd[0]) {
            return ($hourEnd[1] - $hourStart[1]) * 60;
        }
        else {
            $sum = ($hourEnd[0] - $hourStart[0]) * 3600;
            if ($hourStart[1] > $hourEnd[1]) {
                $sum += ($hourEnd[1] - $hourStart[1]) * 60;
            }
            else {
                $sum -= ($hourStart[1] - $hourEnd[1]) * 60;
            }
            return $sum;
        }
    }
    public static function changeTime($time) {
        $time1 = explode(":",$time);
        $hour2 = $time1[0] - Auth::User()->start_day;
        if ($hour2 < 0) {
            $hour2 = 24 + $hour2;
        }
        if (strlen($hour2) == 1) {
            $hour2 = "0"  . $hour2;
        }
        if (strlen($time1[1]) == 1) {
            $time2 =  "0" .  $time1[1];
        }
        else {
            $time2 = $time1[1];
        }
        return $hour2 . ":" . $time2;
    }
    public static function selectPortion(int $type) {
        $typePortion = [
            0 => [1,'Mg',""],
            1 => [2,'mililitry',""],
            2 => [3,'ilości',""],
            3 => [4,'Waga ciała Kg',""]
        ];
        $array =[];
        $html = "";
        for ($i = 0;$i < count($typePortion);$i++) {
            if ($typePortion[$i][0] == $type) {
                $html .= "<option value='" . $typePortion[$i][0] . "' selected>" . $typePortion[$i][1] . "</option>";
            }
            else {
                $html .= "<option value='" . $typePortion[$i][0] . "'>" . $typePortion[$i][1] . "</option>";
            }
        }
        return $html;
    }
    public static function selectPortionInt(int $type) {
        $typePortion = [
            0 => [1,'Mg',""],
            1 => [2,'mililitry',""],
            2 => [3,'ilości',""],
            3 => [4,'Waga ciała Kg',""]
        ];
        $i = 0;
        while ($i < count($typePortion)) {
            if ($typePortion[$i][0] == $type) {
                return $typePortion[$i][1];
            }
            $i++;
        }
        return $typePortion[0][1];
    }
    public static function returnDayWeek($data) {
        $week = date('N', strtotime($data));
        switch ($week) {
            case 1: return "Poniedziałek";
                break;
            case 2: return "Wtorek";
                break;
            case 3: return "Środa";
                break;
            case 4: return "Czwartek";
                break;
            case 5: return "Piątek";
                break;
            case 6: return "Sobota";
                break;
            default: return "Niedziela";
                break;
            
            
        }
    }
    public static function sumHour($minute) {
        //return $minute;
        
        if ($minute < 60) {
            return $minute . " minut";
        }
        else {
            $hour = $minute / 60;
            if (!strstr($hour,".") ) {
                return $hour . " Godzin";
            }
            else {
                $hour = round($hour,2);
                $hour2 = explode(".",($hour));
                //$hour2[1] = $hour2[1];
                if (strlen(($hour2[1])) == 1 ) {
                    return $hour2[0] . " Godzin i " .round( ($hour2[1] * 10) / 1.65 ) . " Minut ";
                }
                else if (strlen(($hour2[1])) == 2 ) {
                    return $hour2[0] . " Godzin i " . round($hour2[1]   / 1.65) . " Minut ";
                }
                else {
                    return $hour2[0] . " Godzin i " . round($hour2[1][2]  / 1.65) . " Minut ";
                }
            }
        }
    }
    
    public static function return_next_month($month,$year) {
          if ($month == 12) {
            $year++;
            $month = 1;
          }
          else {
            $month++;
          }
          return array($year,$month);
    }
    public static function sumMoods($date,$idUser) {
        $Moods = new Mood;
        //$this->initStartDay($start);
        $hour = Auth::User()->start_day;
        $listMood = $Moods
                
                ->selectRaw(DB::Raw("(DATE(IF(HOUR(moods.date_start) >= '$hour', moods.date_start,Date_add(moods.date_start, INTERVAL - 1 DAY) )) ) as dat"))
                ->select("level_mood")
                ->select("level_anxiety")
                ->select("level_nervousness")
                ->select("level_stimulation")
                ->selectRaw("sum((unix_timestamp(date_end)  - unix_timestamp(date_start)))   as division")
                ->selectRaw("(((sum(unix_timestamp(date_end)  - unix_timestamp(date_start) ) * level_mood))) / sum((unix_timestamp(date_end)  - unix_timestamp(date_start)))  as average_mood")
                ->selectRaw("sum((unix_timestamp(date_end)  - unix_timestamp(date_start)) * level_anxiety) / sum((unix_timestamp(date_end)  - unix_timestamp(date_start))) as average_anxiety")
                ->selectRaw("sum( (unix_timestamp(date_end)  - unix_timestamp(date_start)) * level_nervousness) / sum((unix_timestamp(date_end)  - unix_timestamp(date_start))) as average_nervousness")
                ->selectRaw("sum( (unix_timestamp(date_end)  - unix_timestamp(date_start)) * level_stimulation) / sum((unix_timestamp(date_end)  - unix_timestamp(date_start)))  as average_stimulation")
                ->where(DB::Raw("(DATE(IF(HOUR(moods.date_start) >= '$hour', moods.date_start,Date_add(moods.date_start, INTERVAL - 1 DAY) )) )"),$date)
                ->where("moods.id_users",$idUser)
                ->get();
        return $listMood;
    }

}
