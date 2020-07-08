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
use App\Action;
use Auth;
class MainController extends Controller  {
    public function index($year = "",$month  ="",$day = "",$action = "") {
       $Action = Action::selectAction(Auth::id());
       $Calendar = new Calendar($year, $month, $day, $action);
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
                               ->with("Action",$Action);
    }
}
