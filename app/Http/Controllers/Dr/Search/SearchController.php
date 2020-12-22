<?php


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
            $Search  = new Search;
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
            else if ($search->bool == true and $search->checkArrayFindPro(count($search->stringPro)) == false and
                    $search->checkArrayFindSub(count($search->stringSub)) == false and $search->checkArrayFindGro(count($search->stringGro)) == false) {
                return back()->with("error","Nic nie wyszukano")->withinput();
            }
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
        $Search  = new Search;
        $Search->checkErrorMood($request);
        if (count($Search->errors) > 0) {
            return Redirect::back()->with("errors",$Search->errors)->withInput();
        }
        else {
                 $list = $Search->createQuestion($request,Auth::User()->id_user);
                 $lista = $Search->sortMoods($list);

                 return View("Dr.Search.searchMood")->with("list",$list)->with("lista",$Search->arrayList)->with("percent",$Search->listPercent);
        }
      }
      else {
         Auth::logout();
         return View("auth.login")->with('errors2',['Nie prawidłowy login lub hasło']);
     }
   
    }
    
    public function searchAI(Request $request) {
      if (Auth::User()->type == "doctor" and Auth::User()->if_true == 1) {
        $AI = new AI;

        print "jakiś";
        
            $AI->setTime($request->get("timeFrom"), $request->get("timeTo"));
            $AI->setDate($request->get("dateFrom"), $request->get("dateTo"));
            $list = $AI->selectDays($request->get("dateFrom"),
                   $request->get("dateTo"),$request->get("allDay"),$request->get("day"),Auth::User()->id_user,$request->get("sumDay"));

            return View("ajax.showAverage")->with("days",$AI->days)->with("list",$list)
                   ->with("day",$request->get("sumDay"))->with("harmonyMood",$AI->tableMood)->with("harmonyAnxiety",$AI->tableAnxiety)
                    ->with("harmonyNer",$AI->tableNer)->with("harmonyStimu",$AI->tableStimu)->with("hour","Godzina od " . $request->get("timeFrom") . " do "  .  $request->get("timeTo"))
            ->with("dateFrom",$request->get("dateFrom"))->with("dateTo",$request->get("dateTo"));
             
      }
      else {
         Auth::logout();
         return View("auth.login")->with('errors2',['Nie prawidłowy login lub hasło']);
     }
        
    }
    public function searchSumMood(Request $request) {
      if (Auth::User()->type == "doctor" and Auth::User()->if_true == 1) {
        $Mood = new Search;
        $sum = $Mood->sumMood($request,Auth::User()->id_user);
        $sumPercent = $Mood->sumMoodPercent($request,Auth::User()->id_user);
        if ($sumPercent->sum == 0) {
            return View("ajax.error")->with("error",["Nie było żadnych nastroi"]);
        }
        else {
            return View("ajax.SumMood")->with("hour",round($sum->sum,2))->with("percent",round(($sum->sum / $sumPercent->sum) * 100),2);
        }
      }  
     else {
         Auth::logout();
         return View("auth.login")->with('errors2',['Nie prawidłowy login lub hasło']);
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
