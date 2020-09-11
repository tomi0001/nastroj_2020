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
            
            //print $AI->hourEnd;
            $list = $AI->selectDays($request->get("dateFrom"),
                   $request->get("dateTo"),$request->get("allDay"),$request->get("day"),Auth::User()->id,$request->get("sumDay"));
            //print ("<pre>");
            //print_r ($list);
  //          print ("<pre>");
            
            //var_dump($list);
            
//print_r($list);
            //$a = $AI->sortMood([0.1,1,0.1,1]);
            //var_dump($a);
            return View("ajax.showAverage")->with("days",$AI->days)->with("list",$list)
                   ->with("day",$request->get("sumDay"))->with("harmonyMood",$AI->tableMood)->with("harmonyAnxiety",$AI->tableAnxiety)
                    ->with("harmonyNer",$AI->tableNer)->with("harmonyStimu",$AI->tableStimu)->with("hour","Godzina od " . $request->get("timeFrom") . " do "  .  $request->get("timeTo"))
                    ->with("dateFrom",$request->get("dateFrom"))->with("dateTo",$request->get("dateTo"));
             
             
        
    }
    
}
