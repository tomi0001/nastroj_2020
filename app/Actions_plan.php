<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
class Actions_plan extends Model
{
    public static function checkTimeExist($dateStart,$dateEnd) {
        return Actions_plan::where("date_start","<=",$dateEnd)->where("date_end",">=",$dateStart)->where("id_users",Auth::User()->id)->first();
    }

    public static function checkTimeExistActionAllDay($dateStart,$dateEnd,$id) {
        return Actions_plan::where("date_start","<=",$dateEnd)->where("date_end",">=",$dateStart)->where("id_actions",$id)
                ->where("id_users",Auth::User()->id)->whereRaw("Time(date_start) <= Time('$dateEnd')")->whereRaw("Time(date_end) >= Time('$dateStart')")->first();
    }
    
    public static function checkTimeExistAction($dateStart,$dateEnd,$id) {
        return Actions_plan::where("date_start","<=",$dateEnd)->where("date_end",">=",$dateStart)->where("id_users",Auth::User()->id)->where("id_actions",$id)->first();
    }
    public static function checkTimeExist2($dateStart,$dateEnd,$idActions,$hour,$timeFrom,$timeTo) {
        return Actions_plan::where("date_start","<=",$dateEnd)->where("date_end",">=",$dateStart)->where("id_users",Auth::User()->id)->where("id_actions",$idActions)
                ->whereRaw("(time(date_add(date_start,INTERVAL - $hour hour))) <= '$timeTo'")->whereRaw("(time(date_add(date_end,INTERVAL - $hour hour))) >= '$timeFrom'")->first();
    }
    public static function checkTimeExist3($dateStart,$dateEnd,$idActions,$hour,$timeFrom,$timeTo) {
    

            //$this->question->whereRaw("(time(date_add(date_start,INTERVAL - $hour hour))) <= '$hourTo'");
            //$this->question->whereRaw("(time(date_add(date_end,INTERVAL - $hour hour))) >= '$hourFrom'");   
        return Actions_plan::where("date_start","<=",$dateEnd)->where("date_end",">=",$dateStart)->where("id_actions",$idActions)
                ->where("id_users",Auth::User()->id)->whereRaw("(time(date_add(date_start,INTERVAL - $hour hour))) <= '$timeTo'")->whereRaw("(time(date_add(date_end,INTERVAL - $hour hour))) >= '$timeFrom'")->first();
    }
    public static function selectAction($id) {
        return Actions_plan::selectRaw("actions.name as name")->selectRaw("SUBSTRING_INDEX(actions_plans.date_start,' ',1) as date_start")
                ->selectRaw("left(SUBSTRING_INDEX(actions_plans.date_start,' ',-1),5) as time_start")
                ->selectRaw("SUBSTRING_INDEX(actions_plans.date_end,' ',1) as date_end")
                ->selectRaw("left(SUBSTRING_INDEX(actions_plans.date_end,' ',-1),5) as time_end")
                ->selectRaw("DATEDIFF(actions_plans.date_end,actions_plans.date_start) as datediff")
                ->selectRaw("actions_plans.long as longer")
                ->selectRaw("actions_plans.date_start as start")
                ->selectRaw("actions_plans.if_all_day as if_all_day")
                ->selectRaw("actions_plans.id as id")
                ->selectRaw("actions_plans.id_actions as id_actions")
                ->join("actions","actions.id","actions_plans.id_actions")
                ->where("actions_plans.id",$id)->where("actions_plans.id_users",Auth::User()->id)->first();
    }
    public static function checkNameIfExist($idActionPlan,$idAction) {
        return Actions_plan::where("id_actions",$idAction)->where("id",$idActionPlan)->first();
    }
    public static function setAllDay($id) {
        return Actions_plan::select("if_all_day")
                ->selectRaw("DATEDIFF(actions_plans.date_end,actions_plans.date_start)    as datediff")
                ->where("id_actions",$id)->first();
    }

}

