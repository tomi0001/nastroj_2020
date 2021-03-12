<?php
/*
 * copyright 2020 Tomasz Leszczyński tomi0001@gmail.com
 * 
 */

namespace App\Http\Controllers\Drugs;
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
    
    public function add(Request $request) {
        if (Auth::User()->type == "user") {
            $Drugs = new Product;
            $date = $Drugs->checkDate($request->get("date"),$request->get("time"));
            if ($request->get("name") == "" and $request->get("namePlaned") == "") {
                array_push($this->error, "Wpisz nazwę");
            }
            if ($date == -1 or $date == -2) {
                array_push($this->error, "Błędna data");
            }
            if ($request->get("dose") == "" and $request->get("namePlaned") == "") {
                array_push($this->error, "Uzupełnij pole dawka");
            }
            else if (!is_numeric($request->get("dose")) and $request->get("namePlaned") == "") {
                array_push($this->error, "Pole dawka musi być numeryczne");
            }
            if (count($this->error) != 0) {
                return View("ajax.error")->with("error",$this->error);
            }
            else {
                if ($request->get("name") != "") {
                    $price = $Drugs->sumPrice($request->get("dose"),$request->get("name"));
                    $Drugs->addDrugs($request,$Drugs->date,$price);
                }
                else  {
                    $Drugs->addPlanedDose($request,$Drugs->date);
                }
      
                
            }
            
        }
    }
    
    public function sumAverage(Request $request) {
         $Drugs = new DrugsUses;
         //$Hash = new Hashs();
         //$user = new user();
         if (Auth::User()->type == "user") {
             $id = Auth::User()->id;
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
                $hourDrugs = $Drugs->sumAverage($list,$date,$id,$startDay);
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
         if (Auth::User()->type == "user") {
             $id = Auth::User()->id;
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

        if (Auth::User()->type == "user") {
             $id = Auth::User()->id;
             //$startDay = Auth::User()->start_day;



         $Drugs->description = $Drugs->selectDescription($request->get("id"),$id);
         //$Drugs->changeChar($Drugs->description);
         return View("ajax.showDescriptionDrugs")->with("list",$Drugs->description);
        }
     }
    public function deleteDrugs(Request $request) {
         $Drugs = new Product;
         $bool = $Drugs->checkDrugs(Auth::User()->id,$request->get("id"));
         if ($bool == true) {
             $Drugs->deleteDescription($request->get("id"));
             $Drugs->deleteDrugs($request->get("id"),Auth::User()->id);
         }
     }     
     
    public function addDescriptionsAction(Request $request) {
      if (Auth::User()->type == "user") {
         $Drugs = new Product;
         if ($request->get("description") == "") {
             return View("ajax.error")->with("error","Musisz coś wpisać");
         }
         else {
             $Drugs->addDescription($request,$request->get("id_use"),date("Y-m-d H:i:s"));
             return View("ajax.succes")->with("succes","Pomyslnie dodano");
         }
         
     }
    }
     
    public function EditDrugs(Request $request) {
        if (Auth::User()->type == "user") {
            $drugs = new DrugsUses;
         //if ( (Auth::check()) ) {
             $listProduct = $drugs->selectProduct(Auth::User()->id);
             $info = $drugs->selectRegistration($request->get("idDrugs"));
             $date = explode(" ",$info->date);
             return View("ajax.changeRegistration")->with("listProduct",$listProduct)
                     ->with("date1",$date[0])->with("date2",$date[1])->with("portion",$info->portion)
                     ->with("id",$info->id_products)->with("i",$request->get("i"))
                     ->with("idDrugs",$request->get("idDrugs"));
         }
        
        //}
    
    }
    public function closeForm(Request $request) {
        if (Auth::User()->type == "user") {
           $drugs = new DrugsUses;
           //if ( (Auth::check()) ) {
               $drugs->selectRegistration2($request->get("id"));
               $equivalent = $drugs->sumEquivalent($drugs->list);
               $benzo = $drugs->selectBenzo(Auth::User()->id);
               $drugs->processPrice($drugs->list);
               return View("ajax.showUpdatesDrugs")->with("listDrugs",$drugs->list)
                       ->with("equivalent",$equivalent)->with("benzo",$benzo)->with("i",$request->get("i"));

        }
    }
    public function updateRegistration(Request $request) {
        if (Auth::User()->type == "user") {
            
            $Product = new Product;
            
                $date = $Product->checkDate($request->get("date"),$request->get("time"));
                if ($request->get("nameProduct") == "") {
                    array_push($this->error, "Wpisz nazwę");
                }
                if ($date == -1 or $date == -2) {
                    array_push($this->error, "Błędna data");
                }
                if ($request->get("portion") == "") {
                    array_push($this->error, "Uzupełnij pole dawka");
                }
                else if (!is_numeric($request->get("portion"))) {
                    array_push($this->error, "Pole dawka musi być numeryczne");
                }
                if (($request->get("date") == "" or  $request->get("time") == "")) {
                    array_push($this->error, "Uzupełnij pole data i czas");
                }
                if (count($this->error) != 0) {
                    return View("ajax.error")->with("error",$this->error);
                }

                else {
                    $idProduct = $Product->selectIdProduct($request->get("id"));
                    
                    $price = $Product->sumPrice($request->get("portion"),$idProduct);
                    $price = $Product->sumPrice($request->get("portion"),$request->get("nameProduct"));
                    $Product->editRegistration($request,$Product->date,$request->get("id"),$price);
                    return View("ajax.succes")->with("succes","Pomyslnie dodano");
                     
                     
                }
        }    //}
    }    
    public function show(Request $request) {
        if (Auth::User()->type == "user") {
            $DrugsUses = new DrugsUses;
            $list = $DrugsUses->selectDrugsAjax(Auth::id(),$request->get("dateStart"),$request->get("dateEnd"));
            return View("ajax.showDrugs")->with("list",$list)->with("dateStart",$request->get("dateStart"))->with("dateEnd",$request->get("dateEnd"));
        }
    }
    
    public function loadPortion(Request $request) {
        if (Auth::User()->type == "user") {
            $portion = appProduct::loadTypePortion($request->get("name"));
            /*
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
             * 
             */
            print Common::selectPortionInt($portion->type_of_portion);
            
        }
    }
    public function calculateBenzo(Request $request) {
         $Drugs = new DrugsUses;
         $equivalent = $Drugs->selectEquivalent($request->get("id"));
         $name = $Drugs->selectBenzoName($request->get("id"));
         //$substances->find($id);
         $result = $Drugs->calculateEquivalent($request->get("equivalent"),10,$equivalent);
         //print ("<body onload=\"alert('Przykładowy tekst');\">");
         if ($request->get("i") == "all") {
             return View("ajax.equivalentBenzo2")->with("result",$result)->with("i",$request->get("i"))->with("name",$name);
         }
         else {
             return View("ajax.equivalentBenzo")->with("result",$result)->with("i",$request->get("i"))->with("name",$name);
         }
     }
}
