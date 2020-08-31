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
                 $list = $Search->createQuestionForSleep($request);
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
                 $list = $Search->createQuestion($request);
                 $lista = $Search->sortMoods($list);

                 return View("Search.searchMood")->with("list",$list)->with("lista",$Search->arrayList)->with("percent",$Search->listPercent);
        }
        
       
            //print ("<pre>");
            //print_r ($list);
   
    }
}
