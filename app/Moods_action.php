<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Moods_action extends Model
{
    public static function selectPercent($id,$dateStart,$dateEnd,$hour,$timeFrom,$timeTo) {
        return self::selectRaw("round(sum(moods_actions.percent_executing),2) as percent")->join("moods","moods.id","moods_actions.id_moods")->where("date_start","<=",$dateEnd)->where("date_end",">=",$dateStart)
                ->where("moods_actions.id_actions",$id)->whereRaw("(time(date_add(date_start,INTERVAL - $hour hour))) <= '$timeTo'")->whereRaw("(time(date_add(date_end,INTERVAL - $hour hour))) >= '$timeFrom'")->first();
    }
}
