<?php
/*
 * copyright 2020 Tomasz Leszczyński tomi0001@gmail.com
 * 
 */

namespace App\Http\Controllers\Dr\Main;
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
use App\Http\Services\Product;
use App\Http\Services\DrugsUses as Drugs;
use App\Action;
use App\Product as appProduct;
use Auth;
class MainController extends Controller  {
    
    public function index($year = "",$month  ="",$day = "",$action = "") {   
       if (Auth::User()->type == "doctor" and Auth::User()->if_true == 1) {
        $Action = Action::selectAction(Auth::User()->id_user);
        $Mood = new Mood;
        $Product = new Product;
        $Drugs = new Drugs;
        $Calendar = new Calendar($year, $month, $day, $action);
        $Mood->downloadMood($Calendar->year,$Calendar->month,$Calendar->day,Auth::User()->id_user);
        $Mood->downloadSleep($Calendar->year,$Calendar->month,$Calendar->day,Auth::User()->id_user);
        if ((count($Mood->listMood) == 0 and count($Mood->listSleep) == 0)) {
            $boolMood = true;
        }
        else {
            $boolMood = false;
        }
        $Mood->sortMoodsSleep($Mood->listMood,$Mood->listSleep,"off",true);
        $dateAction = date("Y-m-d",StrToTime(date("Y-m-d") )+ 86400);

        $Action2 = new Action2;
        $Action2->downloadAction(Auth::User()->id_user,$Calendar->year, $Calendar->month,$Calendar->day);
        $Action2->separateShare($Calendar->year, $Calendar->month,$Calendar->day);

        //if (count($Mood->arrayList) != 0) {
        $Mood->sumColorForMood(Auth::User()->id_user,$Calendar->year,$Calendar->month);
        $Mood->sumColorForMoodDay(Auth::User()->id_user,$Calendar->year,$Calendar->month,$Calendar->day);
        
        //$listProduct = $Product->selectListProduct(Auth::id());
        //$listProduct = appProduct::loadAllProductsIdUsers(Auth::id());
        $Drugs->selectDrugs(Auth::User()->id_user,$Calendar->year . "-" . $Calendar->month . "-" . $Calendar->day);
        $Drugs->processPrice($Drugs->list);
        //if (count($Mood->arrayList) != 0) {
        //xdebug_start_trace('/var/www/html/a ');

        $equivalent = $Drugs->sumEquivalent($Drugs->list);
        $ifDescription = $Drugs->checkIfDescription($Drugs->list);
        $separate = $Drugs->separateDrugs();
        $equivalent = $Drugs->sumEquivalent($Drugs->list);
        $allEquivalent = $Drugs->sumAllEquivalent($equivalent);
        $benzo = $Drugs->selectBenzo(Auth::User()->id_user);
        $sumAlkohol = $Drugs->sumPercentAlkohol();
        $listPlaned = $Product->showPlaned(Auth::User()->id_user);
        //dd($Mood->colorDay);
        //}
        /*
        print ("<pre>");
        print_r ($Action2->listActionMoodSeparate);
        print ("</pre>");
         * 
         */
        return View("Dr.Main.Main")->with("text_month",$Calendar->text_month)
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
                                ->with("count2",count($Mood->listMood))
                                ->with("count",count($Mood->arrayList))
                                ->with("listPercent",$Mood->listPercent)
                                ->with("listActionMood",$Action2->listActionMoodSeparate)
                                ->with("color",$Mood->color)
                                ->with("boolMood",$boolMood)
                                ->with("colorForDay",$Mood->colorDay)
                                ->with("dayList",$Mood->DayList)
                               // ->with("listProduct",$listProduct)
                                ->with("listDrugs",$Drugs->list)
                                ->with("equivalent",$equivalent)
                                ->with("ifDescription",$ifDescription)
                                ->with("separate",$separate)
                                ->with("idUser",Auth::User()->id_user)
                                ->with("sumAlkohol",$sumAlkohol)
                                ->with("equivalent",$equivalent)
                                ->with("allEquivalent",$allEquivalent)
                                ->with("benzo",$benzo);
                                //->with("listActionMood",$Action2->listActionMood);
     }
     else {
         Auth::logout();
         return View("auth.login")->with('errors2',['Nie prawidłowy login lub hasło']);
     }

    }
}
