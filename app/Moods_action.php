<?php
/*
 * copyright 2020 Tomasz Leszczyński tomi0001@gmail.com
 * 
 */
namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use DB;
class Moods_action extends Model
{
    public static function selectPercent($id,$dateStart,$dateEnd,$hour,$timeFrom,$timeTo) {
        return self::selectRaw("round(sum(moods_actions.percent_executing),2) as percent")->join("moods","moods.id","moods_actions.id_moods")->where("date_start","<=",$dateEnd)->where("date_end",">=",$dateStart)
                ->where("moods_actions.id_actions",$id)->whereRaw("(time(date_add(date_start,INTERVAL - $hour hour))) <= '$timeTo'")->whereRaw("(time(date_add(date_end,INTERVAL - $hour hour))) >= '$timeFrom'")->first();
    }
    public static function ifExistActionForDay($data,$id) {
        $hour = Auth::User()->start_day;
        return self::join("moods","moods.id","moods_actions.id_moods")
                ->selectRaw("( sum(TIMESTAMPDIFF(minute,moods.date_start,moods.date_end))) as minute ")
                ->selectRaw("  moods_actions.id_actions as action")
                ->selectRaw("round(( sum((   if (moods_actions.percent_executing2 is NULL, (     (TIMESTAMPDIFF(minute,moods.date_start,moods.date_end))  ), (   (moods_actions.percent_executing2 / 100) * (TIMESTAMPDIFF(minute,moods.date_start,moods.date_end)) ))     ) ) )) as percent  ")
                ->selectRaw(DB::Raw("(date(IF(HOUR(moods.date_start) >= '$hour', moods.date_start,Date_add(moods.date_start, INTERVAL - 1 DAY) )) ) as day"))
                ->where(DB::Raw("(date(IF(HOUR(moods.date_start) >= '$hour', moods.date_start,Date_add(moods.date_start, INTERVAL - 1 DAY) )) )"),   $data)
                ->where("moods.id_users",$id)
                //->where("moods_actions.id_actions","!=","")
                //->groupBy(DB::Raw("(DATE(IF(HOUR(moods.date_start) >= '$hour', moods.date_start,Date_add(moods.date_start, INTERVAL - 1 DAY) )) ) "))
                ->groupBy("moods_actions.id_actions")
                    ->get();
    }
    public static function ifExistActionForSumMood($dateFrom,$dateTo,$id) {
        $hour = Auth::User()->start_day;
        return self::join("moods","moods.id","moods_actions.id_moods")
                ->selectRaw("( sum(TIMESTAMPDIFF(minute,moods.date_start,moods.date_end))) as minute ")
                ->selectRaw("round(( sum((   if (moods_actions.percent_executing2 is NULL, (     (TIMESTAMPDIFF(minute,moods.date_start,moods.date_end))  ), (   (moods_actions.percent_executing2 / 100) * (TIMESTAMPDIFF(minute,moods.date_start,moods.date_end)) ))     ) ) )) as percent  ")
                //->selectRaw("( sum((  (100 / 100) * (TIMESTAMPDIFF(minute,moods.date_start,moods.date_end)))) ) as percent  ")
                ->selectRaw("  moods_actions.id_actions as action")
                ->selectRaw(DB::Raw("(date(IF(HOUR(moods.date_start) >= '$hour', moods.date_start,Date_add(moods.date_start, INTERVAL - 1 DAY) )) ) as day"))
                ->where("date_start",">=",$dateFrom)
                ->where("date_end","<",$dateTo)
                ->where("moods.id_users",$id)
                //->where("moods_actions.id_actions","!=","")
                
                ->groupBy("moods_actions.id_actions")
                    ->get();
    }
    public static function compareIdActionMood($idAction,$idMood) {
        return self::where("id_actions",$idAction)->where("id_moods",$idMood)->first();
    }
    public static function selectAction($idMood) {
        return self::join("actions","actions.id","moods_actions.id_actions")
                ->selectRaw("actions.name as name")->where("moods_actions.id_moods",$idMood)->get();
    }


}
