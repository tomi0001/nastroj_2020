<?php

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
    public static function ifExistActionForDay($data) {
        $hour = Auth::User()->start_day;
        return self::join("moods","moods.id","moods_actions.id_moods")
                ->selectRaw("( sum(TIMESTAMPDIFF(minute,moods.date_start,moods.date_end))) as minute ")
                ->selectRaw("  moods_actions.id_actions as action")
                ->selectRaw(DB::Raw("(date(IF(HOUR(moods.date_start) >= '$hour', moods.date_start,Date_add(moods.date_start, INTERVAL - 1 DAY) )) ) as day"))
                ->where(DB::Raw("(date(IF(HOUR(moods.date_start) >= '$hour', moods.date_start,Date_add(moods.date_start, INTERVAL - 1 DAY) )) )"),   $data)
                ->where("moods.id_users",Auth::User()->id)
                //->where("moods_actions.id_actions","!=","")
                //->groupBy(DB::Raw("(DATE(IF(HOUR(moods.date_start) >= '$hour', moods.date_start,Date_add(moods.date_start, INTERVAL - 1 DAY) )) ) "))
                ->groupBy("moods_actions.id_actions")
                    ->get();
    }
}
