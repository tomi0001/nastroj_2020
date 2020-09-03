<?php



use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
namespace App\Http\Services;
use Auth;
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
        return round($result) + 1;
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

}
