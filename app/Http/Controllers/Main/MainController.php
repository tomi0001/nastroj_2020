<?php


namespace App\Http\Controllers\Main;
//namespace App\Http\Controllers\Guest;
//use App\Http\Controllers\User\UserRegisterController;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Validator;
use Illuminate\Http\Request;
use App\Http\Services\User as ServiceUser;
use App\Http\Services\Calendar;
use App\Http\Services\Mood;
use App\Http\Services\Action as Action2;
use App\Http\Services\Common;
use App\Action;
use Auth;
class MainController extends Controller  {
    
    public function index($year = "",$month  ="",$day = "",$action = "") {
       $Action = Action::selectAction(Auth::id());
       $Mood = new Mood;
       $Mood->downloadMood($year,$month,$day);
       $Mood->downloadSleep($year,$month,$day);
       $Mood->sortMoodsSleep($Mood->listMood,$Mood->listSleep,"off",true);
       $dateAction = date("Y-m-d",StrToTime(date("Y-m-d") )+ 86400);
       $Calendar = new Calendar($year, $month, $day, $action);
       $Action2 = new Action2;
       $Action2->downloadAction(Auth::id(),$year, $month,$day);
       $Action2->separateShare($year, $month,$day);
      
       //if (count($Mood->arrayList) != 0) {
       $Mood->sumColorForMood(Auth::User()->id,$Calendar->year,$Calendar->month);
       //}
       /*
       print ("<pre>");
       print_r ($Action2->listActionMoodSeparate);
       print ("</pre>");
        * 
        */
       return View("Main.Main")->with("text_month",$Calendar->text_month)
                               ->with("year",$Calendar->year)
                               ->with("day2",1)
                               ->with("day1",1)
                               ->with("how_day_month",$Calendar->how_day_month)
                               ->with("day_week",$Calendar->day_week)
                               ->with("day3",$Calendar->day)
                               ->with("color",1)
                               ->with("month",$Calendar->month)
                               ->with("back",$Calendar->back_month)
                               ->with("next",$Calendar->next_month)
                               ->with("back_year",$Calendar->back_year)
                               ->with("next_year",$Calendar->next_year)
                               ->with("Action",$Action)
                               ->with("dateAction",$dateAction)
                               ->with("listMood",$Mood->arrayList)
                               ->with("count",count($Mood->arrayList))
                               ->with("listPercent",$Mood->listPercent)
                               ->with("listActionMood",$Action2->listActionMoodSeparate)
                               ->with("color",$Mood->color);
                               //->with("listActionMood",$Action2->listActionMood);
    }
}
