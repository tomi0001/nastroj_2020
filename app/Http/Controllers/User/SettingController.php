<?php


namespace App\Http\Controllers\User;
//namespace App\Http\Controllers\Guest;
//use App\Http\Controllers\User\UserRegisterController;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Validator;
use Illuminate\Http\Request;
use App\Http\Services\Action;
use App\Action as ActionApp;
use App\Actions_plan;
use App\Product as ProductApp;
use App\Planned_drug;
use App\Http\Services\Product;
use Auth;
use App\Http\Services\User as ServiceUser;

class SettingController  extends Controller  {
    public $error = [];
    public function Setting() {
        if (Auth::User()->type == "user") {
            $Users = new ServiceUser;
            $Product  = new Product;
            $array = $Users->CheckIfLevelMood();
            $actionName = $Users->selectAction();
            $actionDate = $Users->selectActionPlans();
            $Hash = $Users->selectHash();
            $listSubstance = $Product->showSubstances(Auth::User()->id);
            $listGroup = $Product->showGroup(Auth::User()->id);
            $listProduct = $Product->showProduct(Auth::User()->id);
            $listPlaned = $Product->showPlaned(Auth::User()->id);
            return View("User.Setting.index")
                    ->with("levelMood",$array)->with("actionName",$actionName)
                    ->with("actionDate",$actionDate)->with("hash",$Hash)
                    ->with("listGroup",$listGroup)
                    ->with("listSubstance",$listSubstance)
                    ->with("listProduct",$listProduct)
                    ->with("listPlaned",$listPlaned);
        }
    }
    public function SettingupdateHash(Request $request) {
        if (Auth::User()->type == "user") {
            $Users = new ServiceUser;
            $Users->checkErrorHash($request);
            if (count($Users->errors) > 0) {
                return View("ajax.error")->with("error",$Users->errors);
            }
            else {
                $Users->updateHash($request);
                return View("ajax.succes")->with("succes","Pomyslnie zmodyfikowano hash");
            }
        }
    }
    public function SettingActionAdd(Request $request) {
        if (Auth::User()->type == "user") {
            $Action = new Action;
            $Action->checkSettingAction($request);
            if (count($Action->errors) != 0) {
                return View("ajax.error")->with("error",$Action->errors);
            }
            else {
                $Action->saveSettingAction($request);
            }
        }
    }
    public function SettingaChangeActionDateName2(Request $request) {
       if (Auth::User()->type == "user") { 
        $Action = new Action;
        $Action->checkAddActionDate($request);
        $Action->checkAddActionName($request);
        //$Action->checkAddAction($request);
        //$Action->checkAddMood($request);
        
        if (count($Action->errors) != 0) {
            return View("ajax.error")->with("error",$Action->errors);
            
        }
        else {
            if (!empty($request->get("idAction"))) {
                $id = $Action->updateActions($request);
                return View("ajax.succes")->with("succes","Pomyślnie zmodyfikowano");
                
            }
            
        }
       }  

         
    }
    public function SettingdeleteActionPlans(Request $request) {
        if (Auth::User()->type == "user") {
            $Action = new Action;
            $Action->checkAddActionDatePlan($request);
            if (count($Action->errors) == 0) {
              $Action->deleteActionPlan($request);
              return Redirect()->back();  
            }

            print $request->get("actionNameDate");
        }
    }
    public function SettingaChangeActionDateName(Request $request) {
        if (Auth::User()->type == "user") {
        //$actionArray = Actions_plan::selectAction($request->get("actionNameDate"));
            if (!empty($request->get("actionNameDate"))) {
                $actionArray = Actions_plan::selectAction($request->get("actionNameDate"));
                $actionArray2 = ActionApp::selectActionName();
                $array = [];
                $longer  =[];
                $start = [];
                $array = array_merge(json_decode($actionArray,true),json_decode($actionArray2,true));
                $array2 = array_merge($array,array("count" => count($actionArray2)));
                if ($actionArray->longer == "") {
                    $longer["longer"] = "";
                }
                else if ($actionArray->datediff == 0 and $actionArray->longer != "") {
                    $longer["longer"] = $actionArray->longer;

                }
                else if ($actionArray->datediff == 0) {
                    $longer["longer"] = $actionArray->longer;
                }
                else {
                    $longer["longer"] = round($actionArray->longer);
                }
                if (strtoTime($actionArray->start) < strtoTime(date("Y-m-d H:i:s"))) {
                    $start["date_start2"] = 1;
                }
                else {
                    $start["date_start2"] = 0;
                }
                $array3 = array_merge($array2,$longer);
                $array4 = array_merge($array3,$start);
                print json_encode($array4, true);
            }
        }
    }
    public function SettingaChangeActionName2(Request $request) {
        if (Auth::User()->type == "user") {
            if ($request->get("actionName") == "") {
                return View("ajax.error")->with("error",["Uzupełnij akcje"]);
            }
            else {
                $Users = new ServiceUser;
                $Users->changeNameAction($request);
                return View("ajax.succes")->with("succes","Pomyślnie zmieniono nazwę");
            }
        }
    }
    public function SettingaChangeActionName(Request $request) {
        if (Auth::User()->type == "user") {
            $name = ActionApp::selectNameAction($request->get("actionName"));
            print $name->name;
            //print $request->get("actionName");
            //var_dump($request);
            //$Action->selectNameAction($request->get("id"));
        }
    }
    public function SettingchengeMood(Request $request) {
        if (Auth::User()->type == "user") {
            $Users = new ServiceUser;
            $Users->CheckIfLevelMoodForm($request);
            if (count($Users->errors) != 0) {
                return View("ajax.error")->with("error",$Users->errors);
            }
            else {
                $Users->updateSettingMood($request);
            }
        }
    }
    public function passwordReset()  {
        return View("User.Login.resetPassword");
        
    }
    public function passwordResetSubmit(Request $request) {
        $User = new ServiceUser;
        $User->checkEmail($request);
        if (count($User->errors) != 0) {
            return Redirect()->back()->with("errors",$User->errors);
        }
        else {
            $User->sendMail($request);
            return Redirect()->back()->with("succes","Link aktywacyjny został wysłany na adres email");
        }
    }
    public function passwordConfirm($hash) {
        $User = new ServiceUser;
        $select = $User->selectHashes($hash);
        if (count($User->errors) != 0) {
            return View("emails.reset2")->with("errors",$User->errors);
        }
        else {
            return View("emails.reset3")->with("hash",$hash);
        }
    }
    public function passwordConfirm2(Request $request) {
        $User = new ServiceUser;
        $select = $User->checkErrors($request);
        if ($select == false) {
            return redirect()->back()->withInput()->withErrors($User->errors);
        }
        else {
            return redirect()->route('login')->withSuccess("Rejestracja zakończona możesz się zalogować");
        }
    }
    public function addGroupAction(Request $request) {
        if (Auth::User()->type == "user") {
            $Drugs = new Product;
            if ($request->get("name") == "") {
                return View("ajax.error")->with("error",["Wpisz nazwę"]);
            }
            $bool = $Drugs->addGroup($request);
            if ($bool == true) {
                return View("ajax.succes")->with("succes","Grupa dodana pomyslnie");
            }
            else {
                return View("ajax.error")->with("error",["Już jest Grupa o takiej nazwie wybierz inną"]);
                
            }
            
        }
        
    }
    public function addPlanedAction(Request $request) {
        if (Auth::User()->type == "user") {
            $Drugs = new Product;
            print $request->get("planedName");
            if ($request->get("name") == "" and $request->get("planedName") == "") {
                array_push($this->error, "Wpisz nazwę");
            }
            else if ($request->get("name") == "") {
                $tmp = Planned_drug::showName($request->get("planedName"));
                $name = $tmp->name;
            }
            else {
                $name = $request->get("name");
            }
            if ($request->get("dose") == "") {
                array_push($this->error, "Uzupełnij pole dawka");
            }
            else if (!is_numeric($request->get("dose"))) {
                array_push($this->error, "Pole dawka musi być numeryczne");
            }
            else {
                $bool = $Drugs->addPlaned($request,Auth::User()->id,$name);
            }
            //print $name;
            if (count($this->error) == 0) {
                return View("ajax.succes")->with("succes","Grupa dodana pomyslnie");
            }
            else {
                return View("ajax.error")->with("error",$this->error);
            }

            
        }
    }
    public function addSubstancesAction(Request $request) {
        if (Auth::User()->type == "user") {
            $Drugs = new Product;
            if (empty($request->get("group")) ) {
                 return View("ajax.error")->with("error",["Uzupełnij grupę"]);
            }
            $check = $Drugs->checkSubstances($request->get("name"),Auth::User()->id);
            $bool = $Drugs->checkGroupArray($request->get("group"),Auth::User()->id);
            if ($request->get("name") == "") {
                 return View("ajax.error")->with("error",["Wpisz nazwę"]);
            }

            if ($bool == false){
                return View("ajax.error")->with("error",["Coś poszło nie tak"]);
            }
            else if($check == false) {
                return View("ajax.error")->with("error",["Już jest substancja o takiej nazwie"]);
            }
            else {
                $Drugs->addSubstances($request->get("group"),$request->get("equivalent"),$request->get("name"),Auth::User()->id);
                return View("ajax.succes")->with("succes","Pomyslnie dodano substancje");
            }
            
            
        }
        
    }
 
    public function addProductAction(Request $request) {
        if (Auth::User()->type == "user") {
            
            
            $Drugs = new Product;
            //$Product = new ;
            if (empty($request->get("substance")) ) {
                 return View("ajax.error")->with("error",["Uzupełnij substancję"]);
            }
            $bool  = $Drugs->checkIfHow($request->get("price"),$request->get("how"));
            $bool2 = $Drugs->checkProduct($request->get("name"),Auth::User()->id);
            $bool3 = $Drugs->checkSubstanceArray( $request->get("substance"),Auth::User()->id);
            if ($request->get("name") == "") {
                array_push($this->error, "Wpisz nazwę");
            }
            if ($request->get("percent") !=  "" and !is_numeric($request->get("percent"))) {
                array_push($this->error, "Pole procent musi być numeryczne");
            }
            
            if ($bool2 == false) {
                array_push($this->error, "Juz jest substancja o takiej nazwie");
            }
            if ($bool3 == false) {
                array_push($this->error, "Coś poszło nie tak");
            }
            if ($bool == -2) {
                array_push($this->error, "Musisz wpisać dwa pola czyli cena i za ile");
            }
            else if ($bool == -1) {
                array_push($this->error, "Pole cena musi być numeryczna, a pole za ile całkowita");
            }
            if (count($this->error) != 0) {
                return View("ajax.error")->with("error",$this->error);
                
            }
             
             
            else {
                $id = $Drugs->saveProduct($request->get("name"),Auth::User()->id,$request->get("percent"),$request->get("portion"),$request->get("price"),$request->get("how"));
                $Drugs->addForwadindSubstance($id,$request->get("substance"));
                return View("ajax.succes")->with("succes","Dodano pomyslnie produkt");
            }
                
             
        }
        
        
    }
    
    public function loadPlanedAction(Request $request) {
        if (Auth::User()->type == "user") {
            $listProduct = ProductApp::loadAllProducts();
            $planed = Planned_drug::showPlaned($request->get("planedName"));
            return View("ajax.showPlaned")->with("planed",$planed)->with("listProduct",$listProduct);
        }
        
    }
    public function loadPosition(Request $request) {
        if (Auth::User()->type == "user") {
            $Users = new Product;
            $text = $Users->loadDrugsPlaned($request);
            print $text;
        }
    }
    public function updatePlaned(Request $request) {
        if (Auth::User()->type == "user") {
            $Users = new Product;
            $Users->updatePlaned($request);
            return  $this->Setting();
        }
    }
    public function deletePlaned($name) {
        if (Auth::User()->type == "user") {
            $Users = new Product;
            $if = $Users->selectPlaned($name);
            if (count($if) != 0) {
                $Users->deletePlaned($name);
            }
            return  $this->Setting();
        }
    }
}
