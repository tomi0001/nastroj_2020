<?php

/*
 * copyright 2020 Tomasz Leszczyński tomi0001@gmail.com
 * 
 */
namespace App\Http\Controllers\Dr\Search;
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
use App\Http\Services\SearchDrugs;
use App\Http\Services\DrugsUses as drugs;
use App\Action_plan;
use DateTime;
use Auth;
class SearchController extends Controller  {

    public function main() {
        if (Auth::User()->type == "doctor" and Auth::User()->if_true == 1) {
            return View("Dr.Search.main");
        }
        else {
         Auth::logout();
         return View("auth.login")->with('errors2',['Nie prawidłowy login lub hasło']);
     }
    }
    
    public function sleepAction(Request $request) {
        if (Auth::User()->type == "doctor" and Auth::User()->if_true == 1) {
            $Search  = new Search($request->get("dateFrom"),$request->get("dateTo"),1);
            $Search->checkErrorSleep($request);
            if (count($Search->errors) > 0) {
                return Redirect::back()->with("errors",$Search->errors)->withInput();
            }
            else {
                     $list = $Search->createQuestionForSleep($request,Auth::User()->id_user);
                     $lista = $Search->sortSleeps($list);


                     return View("Dr.Search.SearchSleeps2")->with("list",$list)->with("lista",$Search->arrayList)->with("percent",$Search->listPercent);
            }
        }
       else {
         Auth::logout();
         return View("auth.login")->with('errors2',['Nie prawidłowy login lub hasło']);
     }
    }
    public function searchDrugs(Request $request) {
        if (Auth::User()->type == "doctor" and Auth::User()->if_true == 1) {
            
            $search = new SearchDrugs;
            $drugs = new drugs;
            $bool = $search->find($request,Auth::User()->id_user);
            //$search->findNot();
            
            $error = "";
            
            if ($search->bool == false) {
                
                $list = $search->createQuestions($request,$search->bool,Auth::User()->id_user);
                if (count($list) == 0) {
                    $error = "Nic nie wyszukano";
                }
                $day = $search->changeArray($list);
                
                //$drugs->selectColor($list);
                return View("Dr.Search.SearchDrugsAction")->with("listSearch",$list)->with("i",0)
                        ->with("day",$day)->with("inDay",$request->get("day"))
                        ->with("error",$error);
            }
            /*
            else if ($search->bool == true ) {
                return back()->with("error","Nic nie wyszukano")->withinput();
            }
             * 
             */
            else if ( $search->bool == true ) {
                
                $list = $search->createQuestions($request,$search->bool,Auth::User()->id_user);
                if (count($list) == 0) {
                    $error = "Nic nie wyszukano";
                }
                $day = $search->changeArray($list);
                //$drugs->selectColor($list);
                //var_dump($search->id_product);
                
                return View("Dr.Search.SearchDrugsAction")->with("listSearch",$list)->with("i",0)
                        ->with("day",$day)->with("inDay",$request->get("day"))
                        ->with("error",$error);
            }
        }
    }
    public function mainAction(Request $request) {
      if (Auth::User()->type == "doctor" and Auth::User()->if_true == 1) {
        $Search  = new Search($request->get("dateFrom"),$request->get("dateTo"),1);
        $Search->checkErrorMood($request);
        
        $datetime1 = new DateTime($Search->dateStart);
        $datetime2 = new DateTime($Search->dateTo);
        $interval = $datetime1->diff($datetime2);
        //var_dump($interval);
        if (count($Search->errors) > 0) {
            return Redirect::back()->with("errors",$Search->errors)->withInput();
        }
        else {
                 
                 $list = $Search->createQuestion($request,Auth::User()->id_user);
                 $lista = $Search->sortMoods($list);
                 if ($Search->bool == false) {
                    return View("Dr.Search.searchMood")->with("list",$list)->with("lista",$Search->arrayList)
                             ->with("percent",$Search->listPercent)->with("count",$Search->count)
                             ->with("id",Auth::User()->id_user);
                 }
                 else {
                     return View("Dr.Search.searchMoodAll")->with("list",$list)->with("lista",$Search->arrayList)
                             ->with("percent",$Search->listPercent)->with("count",$Search->count)->with("dateFrom",$Search->dateStart)->with("dateTo",$Search->dateTo)
                             ->with("howDay",$interval->days)
                             ->with("id",Auth::User()->id_user);
                 }
        }
        
   
    }
    }
    
    public function searchAI(Request $request) {
      if (Auth::User()->type == "doctor" and Auth::User()->if_true == 1) {

        $AI = new AI(Auth::User()->id_user);
        
            $AI->setTime($request->get("timeFrom"), $request->get("timeTo"));
            $AI->setDate($request->get("dateFrom"), $request->get("dateTo"));

            $timeFrom = $AI->returnTime($request->get("timeFrom"),0);
            $timeTo = $AI->returnTime($request->get("timeTo"),1);
            
            if ($request->get("allWeek") == "on") {
                $list = $AI->selectWeek();
                return View("ajax.showAverageWeek")->with("days",$AI->days)->with("list",$list)
                   ->with("day",$request->get("sumDay"))->with("harmonyMood",$AI->tableMood)->with("harmonyAnxiety",$AI->tableAnxiety)
                    ->with("harmonyNer",$AI->tableNer)->with("harmonyStimu",$AI->tableStimu)->with("hour","Godzina od " . $timeFrom . " do "  .  $timeTo)
                    ->with("dateFrom",$request->get("dateFrom"))->with("dateTo",$request->get("dateTo"))->with("allWeek",$request->get("allWeek"));
            }
            else if ($request->get("sumDay") == "on") {
                $list = $AI->selectDaysAll($request->get("day"));
                return View("ajax.showAverageAllDay")->with("list",$list)->with("hour","Godzina od " . $timeFrom . " do "  .  $timeTo)
                    ->with("dateFrom",$request->get("dateFrom"))->with("dateTo",$request->get("dateTo"));
            }
            else if ($request->get("sumMonth") == "on") {
                
                $list = $AI->selectMonth($request->get("day"));
                //var_dump ($list);
                return View("ajax.showAverageMonth")->with("days",$AI->days)->with("list",$list)
                   ->with("day",$request->get("sumDay"))->with("harmonyMood",$AI->tableMood)->with("harmonyAnxiety",$AI->tableAnxiety)
                    ->with("harmonyNer",$AI->tableNer)->with("harmonyStimu",$AI->tableStimu)->with("hour","Godzina od " . $timeFrom . " do "  .  $timeTo)
                    ->with("dateFrom",$request->get("dateFrom"))->with("dateTo",$request->get("dateTo"))->with("allWeek",$request->get("allWeek"));
            }
            else {
                $list = $AI->selectDays($request->get("day"));
                return View("ajax.showAverage")->with("days",$AI->days)->with("list",$list)
                   ->with("day",$request->get("sumDay"))->with("harmonyMood",$AI->tableMood)->with("harmonyAnxiety",$AI->tableAnxiety)
                    ->with("harmonyNer",$AI->tableNer)->with("harmonyStimu",$AI->tableStimu)->with("hour","Godzina od " . $timeFrom . " do "  .  $timeTo)
                    ->with("dateFrom",$request->get("dateFrom"))->with("dateTo",$request->get("dateTo"))->with("allWeek",$request->get("allWeek"));
            }

      }
        
    }
    public function searchSumMood(Request $request) {
      if (Auth::User()->type == "doctor" and Auth::User()->if_true == 1) {
        $Mood = new Search($request->get("dateFrom"),$request->get("dateTo"),1);
        $sum = $Mood->sumMood($request,Auth::User()->id_user);
        $sumPercent = $Mood->sumMoodPercent($request,Auth::User()->id_user);
        if ($sumPercent->sum == 0) {
            return View("ajax.error")->with("error",["Nie było żadnych nastroi"]);
        }
        else {
            return View("ajax.SumMood")->with("hour",round($sum->sum,2))
                    ->with("percent",round(($sum->sum / $sumPercent->sum) * 100),2)
                    ->with("request",$request);
        }
      }
    }
    public function selectDrugs(Request $request) {
        //if ( (Auth::check()) ) {
            $search = new SearchDrugs;
            
            if ($request->get("dateStart") == "" or $request->get("dateEnd") == "") {
                return Redirect::back()->with("errorSelect","Musisz uzupełnić daty");
            }
            
            $list = $search->selectDrugs($request->get("dateStart"),$request->get("dateEnd"),Auth::User()->id_user);

            //$daySum = $this->sumAverage();
            return View("Dr.Search.selectDrugs")->with("listSearch",$list)
                    ->with("i",0);
            //$Drugs->returnIdProduct()
        //}
    }
}
