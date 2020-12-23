<?php


namespace App\Http\Controllers\Dr\Drugs;
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
use App\Mood as AppMood;
use App\Sleep;
use App\Http\Services\Action;
use App\Action_plan;
use App\Http\Services\Product;
use App\Http\Services\Common;
use App\Http\Services\DrugsUses;
use App\Product as appProduct;
use Auth;
class DrugsController extends Controller  {
    
    
    public $error = [];
    
    
    
    public function sumAverage(Request $request) {
         $Drugs = new DrugsUses;
         //$Hash = new Hashs();
         //$user = new user();
         if (Auth::User()->type == "doctor" and Auth::User()->if_true == 1) {
             $id = Auth::User()->id_user;
             $startDay = Auth::User()->start_day;
         
         /*
         else if ($Hash->checkHashLogin() == true) {
             $user->updateHash();
             $id = $Hash->id;
             $startDay = $Hash->start;
         }
          * 
          */
        
            $bool = $Drugs->checkDrugs($id,$request->get("id"));
            if ($bool == true) {
                $list = $Drugs->returnIdProduct($request->get("id"));
                $date = $Drugs->returnDateDrugs($request->get("id"));
                $hourDrugs = $Drugs->sumAverage($list,$date,$Drugs->ifAlcohol,$id,$startDay);
                $array = array();
                for ($i=0;$i < count($hourDrugs);$i++) {
                   $array[$i] = $Drugs->sumDifferentDay($hourDrugs[$i][1],$hourDrugs[$i][2]);

                }
                return View("ajax.sumAverage")->with("arrayDay",$array)->with("hourDrugs",$hourDrugs)->with("sumDay",$Drugs->sumDayAverage);
            }
         }
    }   
    
    public function sumAverage2(Request $request) {
         $Drugs = new DrugsUses;
         //$Hash = new Hashs();
         //$user = new user();
         if (Auth::User()->type == "doctor" and Auth::User()->if_true == 1) {
             $id = Auth::User()->id_user;
             $startDay = Auth::User()->start_day;

         $bool = $Drugs->checkDrugs($id,$request->get("id"));
         if ($bool == true) {
             $list = $Drugs->returnIdProduct($request->get("id"));
             //$date = $Drugs->returnDateDrugs(Input::get("id"));
             
             $hourDrugs = $Drugs->sumAverage($list,$request->get("date1"),$Drugs->ifAlcohol,$id,$startDay,$request->get("date2"));
             
             $array = array();
             for ($i=0;$i < count($hourDrugs);$i++) {
                $array[$i] = $Drugs->sumDifferentDay($hourDrugs[$i][1],$hourDrugs[$i][2]);
                 
             }
             return View("ajax.sumAverage")->with("arrayDay",$array)->with("hourDrugs",$hourDrugs)->with("sumDay",$Drugs->sumDayAverage);
              
              
         }
        }
    }
    public function showDescriptionsAction(Request $request) {
         $Drugs = new DrugsUses;

        if (Auth::User()->type == "doctor" and Auth::User()->if_true == 1) {
             $id = Auth::User()->id_user;
             //$startDay = Auth::User()->start_day;



         $Drugs->description = $Drugs->selectDescription($request->get("id"),$id);
         //$Drugs->changeChar($Drugs->description);
         return View("ajax.showDescriptionDrugs")->with("list",$Drugs->description);
        }
     }
    
    public function show(Request $request) {
        if (Auth::User()->type == "doctor" and Auth::User()->if_true == 1) {
            $DrugsUses = new DrugsUses;
            $list = $DrugsUses->selectDrugsAjax(Auth::User()->id_user,$request->get("dateStart"),$request->get("dateEnd"));
            return View("ajax.showDrugs")->with("list",$list);
        }
    }
    
    public function loadPortion(Request $request) {
        if (Auth::User()->type == "doctor" and Auth::User()->if_true == 1) {
            $portion = appProduct::loadTypePortion($request->get("name"));
            switch ($portion->type_of_portion) {
                case '0': print "Mg";
                    break;
                case '1': print "Mg";
                    break;
                case '2': print "Mililtry";
                    break;
                case '3': print "ilości";
                    break;
                default: print "Nieznane";
                    break;
            }
            
        }
    }
    
}
