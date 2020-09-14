<?php


namespace App\Http\Controllers\Search;
//namespace App\Http\Controllers\Guest;
//use App\Http\Controllers\User\UserRegisterController;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Validator;
use Illuminate\Http\Request;
use Redirect;
use App\Http\Services\User as ServiceUser;
use App\Http\Services\Calendar;
use App\Http\Services\Mood;
use App\Http\Services\Search;
use App\Mood as AppMood;
use App\Http\Services\AIMood as AI;
use App\Http\Services\Action;
use App\Action_plan;
use Auth;
class SearchController extends Controller  {

    public function main() {
        return View("Search.main");
    }
    
    public function sleepAction(Request $request) {
        $Search  = new Search;
        $Search->checkErrorSleep($request);
        if (count($Search->errors) > 0) {
            return Redirect::back()->with("errors",$Search->errors)->withInput();
        }
        else {
                 $list = $Search->createQuestionForSleep($request,Auth::User()->id);
                 $lista = $Search->sortSleeps($list);


                 return View("Search.SearchSleeps2")->with("list",$list)->with("lista",$Search->arrayList)->with("percent",$Search->listPercent);
        }
                
    }
    
    public function mainAction(Request $request) {
        $Search  = new Search;
        $Search->checkErrorMood($request);
        if (count($Search->errors) > 0) {
            return Redirect::back()->with("errors",$Search->errors)->withInput();
        }
        else {
                 $list = $Search->createQuestion($request,Auth::User()->id);
                 $lista = $Search->sortMoods($list);

                 return View("Search.searchMood")->with("list",$list)->with("lista",$Search->arrayList)->with("percent",$Search->listPercent);
        }
        
       
            //print ("<pre>");
            //print_r ($list);
   
    }
    
    public function searchAI(Request $request) {
        $AI = new AI;

        
        
            $AI->setTime($request->get("timeFrom"), $request->get("timeTo"));
            $AI->setDate($request->get("dateFrom"), $request->get("dateTo"));

            $list = $AI->selectDays($request->get("dateFrom"),
                   $request->get("dateTo"),$request->get("allDay"),$request->get("day"),Auth::User()->id,$request->get("sumDay"));

            return View("ajax.showAverage")->with("days",$AI->days)->with("list",$list)
                   ->with("day",$request->get("sumDay"))->with("harmonyMood",$AI->tableMood)->with("harmonyAnxiety",$AI->tableAnxiety)
                    ->with("harmonyNer",$AI->tableNer)->with("harmonyStimu",$AI->tableStimu)->with("hour","Godzina od " . $request->get("timeFrom") . " do "  .  $request->get("timeTo"))
                    ->with("dateFrom",$request->get("dateFrom"))->with("dateTo",$request->get("dateTo"));
             
             
        
    }
    
    public function searchSumMood(Request $request) {
        $Mood = new Search;
        $sum = $Mood->sumMood($request,Auth::User()->id);
        $sumPercent = $Mood->sumMoodPercent($request,Auth::User()->id);
        if ($sumPercent->sum == 0) {
            return View("ajax.error")->with("error",["Nie było żadnych nastroi"]);
        }
        else {
            return View("ajax.SumMood")->with("hour",round($sum->sum,2))->with("percent",round(($sum->sum / $sumPercent->sum) * 100),2);
        }
        
    }
    
}
