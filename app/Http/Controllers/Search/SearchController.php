<?php
/*
 * copyright 2020 Tomasz Leszczyński tomi0001@gmail.com
 * 
 */

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
use App\Http\Services\SearchDrugs;
use App\Http\Services\SearchAction;
use App\Http\Services\DrugsUses as drugs;
use App\Action_plan;
use DateTime;
use PDF;
use Auth;
class SearchController extends Controller  {


    public function main() {
        return View("Search.main");
    }
    
    public function sleepAction(Request $request) {
        $Search  = new Search($request,$request->get("dateFrom"),$request->get("dateTo"));
        $Search->checkErrorSleep($request);
        if (count($Search->errors) > 0) {
                    return Redirect::back()->with("errors",$Search->errors)->withInput();
        }
        if ($request->get("search") == "Wyszukaj") {



                
           $list = $Search->createQuestionForSleep($request,Auth::User()->id);
           $lista = $Search->sortSleeps($list);


           return View("Search.SearchSleeps2")->with("list",$list)
                   ->with("lista",$Search->arrayList)
                   ->with("count",$Search->count)
                   ->with("percent",$Search->listPercent);
                
        }
        else {
               $datetime1 = new DateTime($Search->dateStart);
        $datetime2 = new DateTime($Search->dateTo);
        $interval = $datetime1->diff($datetime2);
            $list = $Search->createQuestionForSleepMoods($request,Auth::User()->id);
            //$lista = $Search->sortMoods($list);
            if (($list) == null) {
                 return View("Search.error")->with("error","Nic nie wyszukano");
            }
            else {
                return View("Search.SearchSleepdMoods")->with("list",$list)->with("dateFrom",$Search->dateStart)
                        ->with("dateTo",$Search->dateTo)
                        ->with("percent",$Search->listPercent)->with("id",Auth::User()->id)
                        ->with("howDay",$interval->days);
          
            }
        }
        

                
    }
    
    public function mainActionAllDay(Request $request) {
        $Search  = new SearchAction($request,$request->get("dateFrom"),$request->get("dateTo"));
        $list = $Search->createQuestion($request, Auth::User()->id);
        if (($list) == null) {
            return View("Search.error")->with("error","Nic nie wyszukano");
        }
        else {
            return View("Search.SearchActionDaySubmit")->with("list",$list)->with("count",$Search->count)
                    ->with("id",Auth::User()->id);
        }
    }

    public function searchDrugs(Request $request) {
            //session(['searchType' => 'SearchDrugs']);
            $search = new SearchDrugs;
            $drugs = new drugs;
            $bool = $search->find($request,Auth::User()->id);
            //$search->findNot();
            $error = "";

            if ($search->bool == false) {
               
                $list = $search->createQuestions($request,$search->bool,Auth::User()->id);
                if (count($list) == 0) {
                    $error = "Nic nie wyszukano";
                }
                $day = $search->changeArray($list);
                //$drugs->selectColor($list);
                return View("Search.SearchDrugsAction")->with("listSearch",$list)->with("i",0)
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
                 
                $list = $search->createQuestions($request,$search->bool,Auth::User()->id);
                if (count($list) == 0) {
                    $error = "Nic nie wyszukano";
                }
                $day = $search->changeArray($list);
                //$drugs->selectColor($list);
                //var_dump($search->id_product);
                return View("Search.SearchDrugsAction")->with("listSearch",$list)->with("i",0)
                        ->with("day",$day)->with("inDay",$request->get("day"))
                        ->with("error",$error);
            }
    }
    public function mainAction(Request $request) {
        //session(['searchType' => 'mainSearch']);
        $Search  = new Search($request,$request->get("dateFrom"),$request->get("dateTo"));
        $Search->checkErrorMood($request);
        
        $datetime1 = new DateTime($Search->dateStart);
        $datetime2 = new DateTime($Search->dateTo);
        $interval = $datetime1->diff($datetime2);
        //var_dump($interval);
        if (count($Search->errors) > 0) {
            return Redirect::back()->with("errors",$Search->errors)->withInput();
        }
        else {

                 if ($request->get("valueAllDay") == "on") {
                    $list = $Search->createQuestionForAllDay($request,Auth::User()->id);
                    $lista = $Search->sortMoodsAllDay($list);
                    return View("Search.searchMoodAllDay")->with("list",$list)->with("lista",$Search->arrayList)
                             ->with("percent",$Search->listPercent)->with("count",$Search->count)
                             ->with("id",Auth::User()->id);                     
                 }
                 else if ($Search->bool == false) {
                    $list = $Search->createQuestion($request,Auth::User()->id);
                    $lista = $Search->sortMoods($list);
                    return View("Search.searchMood")->with("list",$list)->with("lista",$Search->arrayList)
                             ->with("percent",$Search->listPercent)->with("count",$Search->count)
                             ->with("id",Auth::User()->id);
                 }
                 else {
                     
                     $list = $Search->createQuestion($request,Auth::User()->id);
                     
                        $lista = $Search->sortMoods($list);
                     
                     return View("Search.searchMoodAll")->with("list",$list)->with("lista",$Search->arrayList)
                             ->with("percent",$Search->listPercent)->with("count",$Search->count)->with("dateFrom",$Search->dateStart)->with("dateTo",$Search->dateTo)
                             ->with("howDay",$interval->days)
                             ->with("id",Auth::User()->id);
                      
                      
                 }
        }
        
       
            //print ("<pre>");
            //print_r ($list);
   
    }
    public function selectDifference(Request $request) {
        $Search = new Search($request,$request->get("dateFrom"),$request->get("dateTo"));
        $Search->selectDifferenceMoods($request,Auth::User()->id);
        $Search->selectDifferenceSleeps($request,Auth::User()->id);
        //print ("<pre>");
        //print_r ($Search->sleepsDiff["moods"]);
        //print $Search->sleepsDiff["moods"][1];
        $Search->sumDifference($request,Auth::User()->id);
        //var_dump($Search->sleepsDiff);
        
    }
    public function searchAI(Request $request) {
        $AI = new AI(Auth::User()->id);

        
        
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
    
    public function searchSumMood(Request $request) {
        $Mood = new Search($request,$request->get("dateFrom"),$request->get("dateTo"));
        $sum = $Mood->sumMood($request,Auth::User()->id);
        $sumPercent = $Mood->sumMoodPercent($request,Auth::User()->id);
        if ($sumPercent->sum == 0) {
            return View("ajax.error")->with("error",["Nie było żadnych nastroi"]);
        }
        else {
            return View("ajax.SumMood")->with("hour",round($sum->sum,2))
                    ->with("percent",round(($sum->sum / $sumPercent->sum) * 100),2)
                    ->with("request",$request);
        }
        
    }
    

    
    public function selectDrugs(Request $request) {
        //if ( (Auth::check()) ) {
            $search = new SearchDrugs;
            
            if ($request->get("dateStart") == "" or $request->get("dateEnd") == "") {
                return Redirect::back()->with("errorSelect","Musisz uzupełnić daty");
            }
            
            $list = $search->selectDrugs($request->get("dateStart"),$request->get("dateEnd"),Auth::User()->id);

            //$daySum = $this->sumAverage();
            return View("Search.selectDrugs")->with("listSearch",$list)
                    ->with("i",0);
            //$Drugs->returnIdProduct()
        //}
    }
    
    
    public function generationPDF(Request $request) {
       $Mood = new Mood;
       $Mood->downloadMoodPDF($request->get("dateFrom"),$request->get("dateTo"),Auth::User()->id);
       $Mood->downloadSleepPDF($request->get("dateFrom"),$request->get("dateTo"),Auth::User()->id);
       $Mood->sortMoodsSleep($Mood->listMoodPDF,$Mood->listSleepPDF,"on",true);
       $data = $Mood->arrayList;

       //var_dump($data);
       //print $data[0]["date_start"];
       $pdf = PDF::loadView('PDF.main', ["data" => $data,"id" => Auth::User()->id]);
       return $pdf->download("PDF.main");
       //print ("<pre>");
       //print_r($Mood->arrayList);
    }
    
    
}
