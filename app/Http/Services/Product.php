<?php

namespace App\Http\Services;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use App\Action as ActionApp;
use App\Actions_plan;
use App\Moods_action;
use App\Usee;
use App\Description;
use App\Group;
use App\Substance as Substances;
use App\Forwarding_description;
use App\Forwarding_substance;
use App\Forwarding_group;
use App\Planned_drug;
use App\Http\Services\Common as common;
use Auth;
use App\Product as appProduct;

class Product {
    
    
 
    public function addSubstances( $arrayGroup, $equivalent, $name,int $id_users) {
        $Substances = new Substances;
        $Substances->name = $name;
        $Substances->id_users = $id_users;
        $Substances->equivalent = $equivalent;
        $Substances->save();
        
        $last_id = $Substances->orderby("id","DESC")->first();
        $this->addForwadingGroup($last_id->id,$arrayGroup);
        
    }
    public function addPlanedDose(Request $request,$date) {
       
        $list = $this->selectPlaned(Planned_drug::showName($request->get("namePlaned"))->name);
        foreach ($list as $list2) {
            $price = $this->sumPrice($list2->portion,$list2->id_products);
            $this->addDrugs2($list2->id_products,$list2->portion,$date,$price);
        }
    }
    private function addDrugs2($name,$dose,$date,$price) {
        $use = new Usee;
        $use->id_users = Auth::User()->id;
        $use->id_products = $name;
        $use->date = $date;
        $use->price = $price;
        $use->portion = $dose;
        $use->save();
        //$id = $use->orderBy("id","DESC")->first();
   
        
    }
    public function addPlaned(Request $request,int $idUsers,string $name) {
        $Planed = new Planned_drug;
        $Planed->name = $name;
        $Planed->id_users = $idUsers;
        $Planed->id_products = $request->get("productsName");
        $Planed->portion = $request->get("dose");
        $Planed->save();

    }
    private function addForwadingGroup(int $idSubstances, $arrayGroup) {
        
        for ($i  =0;$i < count($arrayGroup);$i++) {
            $Forwading = new Forwarding_group;
            $Forwading->id_substances = (int)$idSubstances;
            $Forwading->id_groups = (int)$arrayGroup[$i];
            $Forwading->save();
        }
        
    }

    public function selectPlaned(string $namePlaned) {
         $Planned_drug = new Planned_drug;
         $list = $Planned_drug->where("id_users",Auth::User()->id)
                    ->where("name",$namePlaned)->get();
         return $list;
    }
    
    public function checkSubstances( $name,int $id_users) :bool {
         $Substance = new Substances;
         $check = $Substance->where("id_users",$id_users)
                    ->where("name",$name)->first();
         if ($check == "") {
             return true;
         }
         else {
             return false;
         }
        
        
    }



    public function checkGroupArray( $arrayGroup,int $id_users) :bool {
        $Group = new Group; 

        for ($i=0;$i < count($arrayGroup);$i++)  {
            $check = $Group->where("id_users",$id_users)
                    ->where("id",$arrayGroup[$i])->get();
            if ($check == "") {
                return false;
            }
        }

            return true;

        
    }

    
    
    
    
    
    public function checkDrugs(int $id_users,$idDrugs) {
         $Use = new Usee;
         $check = $Use->where("id_users",$id_users)
                    ->where("id",$idDrugs)->first();
         if ($check == "") {
             return false;
         }
         else {
             return true;
         }
    }
    
    
    
    
     public function deleteDescription($idDrugs) {
         $Description = new Forwarding_description;
         $Description->where("id_usees",$idDrugs)->delete();
     }
      
    
    
    
    public function deleteDrugs($idDrugs,$id_users) {
        $Use = new Usee;
        $Use->where("id_users",$id_users)
                ->where("id",$idDrugs)->delete();
    }   
    
    
    
    public function selectListProduct(int $idUsers) {
        $product = new appProduct;
        return $product->where("id_users",$idUsers)->orderBy("name")->get();
    }
    
    public function checkDate($date,$time) {
        if ($time == "" and $date != "") {
            if ($this->ifHourIsGreaterNow("00:00:00",$date) == false ) {
                $this->date = date("Y-m-d") . " " . $time;
                return -1;
            }
        }
        if ($time == "" and $date == "") {
            $this->date = date("Y-m-d H:i:s");
            return 0;
        }
        if ($time != "" and $date == "") {
            if ($this->ifHourIsGreaterNow($time) == false ) {
                $this->date = date("Y-m-d") . " " . $time;
                return -1;
            }
        }
        if ($time != "" and $date != "") {
            if ($this->ifHourIsGreaterNow($time,$date) == false ) {
                $this->date = $date . " " . $time;
                return -2;
            }
        }
        $this->date = $date . " " . $time;
        return 1;
    }
    public function selectIdProduct(int $id) {
        $Use = new usee;
        $list = $Use->where("id",$id)->first();
        return $list->id_products;
        
    }
    
    public function editRegistration(Request $request,$date,int $idUse,$price) {
        $Use = new usee;
        $Use->where("id",$idUse)->update(["id_products"=>$request->get("nameProduct"),"portion"=>$request->get("portion"),"date"=>$date,"price" => $price]);
    }    
        
    public function sumPrice($dose,$name) {
        $product = new appProduct;
        $select = $product->where("id",$name)->first();
        if (($select->price  == "" and $select->how_much == "") or $select->how_much == 0) {
            return 0;
        }
        else {
            return ($dose / $select->how_much) * $select->price;
        }
    }
    
    public function addDrugs(Request $request,$date,$price) {
        $use = new Usee;
        $use->id_users = Auth::User()->id;
        $use->id_products = $request->get("name");
        $use->date = $date;
        $use->price = $price;
        $use->portion = $request->get("dose");
        $use->save();
        //$id = $use->orderBy("id","DESC")->first();
        if ($request->get("description") != "") {
            $this->addDescription($request,$use->id,$date);
        }
        
    }
    public function addDescription(Request $request,$idUse,$date) {
        $Description = new Description;
        $Description->date = $date;
        $Description->description = $request->get("description");
        $Description->id_users = Auth::User()->id;
        $Description->save();
        //$id = $Description->orderBy("id","DESC")->first();
        $Forwarding_description = new Forwarding_description;
        $Forwarding_description->id_usees = $idUse;
        $Forwarding_description->id_descriptions = $Description->id;
        $Forwarding_description->save();

        
    }
    public function showGroup(int $id_users)  {
        $Group = new Group;
        $list = $Group->where("id_users",$id_users)->get();
        return $list;
        
    }   
    public function showProduct(int $id_users)  {
        $Product = new appProduct;
        $list = $Product->where("id_users",$id_users)->orderBy("name")->get();
        return $list;
        
    }   
    public function showPlaned(int $id_users)  {
        $Planed = new Planned_drug;
        $list = $Planed->where("id_users",$id_users)->groupBy("name")->get();
        return $list;
        
    }  
    
    public function showSubstances(int $id_users)  {
        $Substance = new Substances;
        $list = $Substance->where("id_users",$id_users)->get();
        return $list;
        
    }   
    private function ifHourIsGreaterNow($time,$date = "") {
        if ($date == "") {
            $date = date("Y-m-d");
        }
        $date2 = $date . " " . $time;
        $second = strtotime($date2);
        $second2 = strtotime(date("Y-m-d H:i:s"));
        if ($second < $second2) {
            return true;
        }
        else {
            return false;
        }
    }
    public function addGroup(Request $request) :bool {
        if ($this->checkGroupName($request->get("name"),Auth::User()->id) == "" ) {
            $Group = new Group;
            $Group->name = $request->get("name");
            $Group->color = $request->get("color");
            $Group->id_users = Auth::User()->id;
            $Group->save();

            return true;
        }
        return false;
        
    }
    private function checkGroupName(string $name,int $id_users) {
        $Group = new Group;
        $check = $Group->where("name",$name)
                ->where("id_users",$id_users)->first();
        return $check;
        
    }
    
    
        
    public function checkIfHow($price,$how) :int {

        if (($price != "" and !is_numeric($price)) or ($how != "" and (!is_numeric($how) or strstr($how,".") ) )) {
            return -1;
        }
        if (($price == "" xor $how == "")) {
            return -2;
        }
        else {
            return 0;
        }
        
    }
    
    
    
    
    public function checkProduct( $name,int $id_users) :bool {
         $Product = new appProduct;
         $check = $Product->where("id_users",$id_users)
                    ->where("name",$name)->first();
         if ($check == "") {
             return true;
         }
         else {
             return false;
         }
        
        
    }
    
    
    public function checkSubstanceArray( $arraySubstance,int $id_users) :bool {
        $Substance = new Substances; 

        for ($i=0;$i < count($arraySubstance);$i++)  {
            $check = $Substance->where("id_users",$id_users)
                    ->where("id",$arraySubstance[$i])->get();
            if ($check == "") {
                return false;
            }
        }

            return true;

        
    }
    
    
    public function saveProduct($name,$id_users,$percent,$portion,$price,$how) {
        $Product = new appProduct;
        $Product->name = $name;
        $Product->id_users = $id_users;
        $Product->how_percent = $percent;
        $Product->type_of_portion = $portion;
        $Product->price = $price;
        $Product->how_much = $how;
        $Product->save();
        $id = $Product->where("id_users",$id_users)->orderBy("id","DESC")->first();
        return $id->id;
       }


    public function addForwadindSubstance(int $idProduct, $arraySubstance) {
        
        for ($i  =0;$i < count($arraySubstance);$i++) {
            $Forwading = new Forwarding_substance;
            $Forwading->id_products = (int)$idProduct;
            $Forwading->id_substances = (int)$arraySubstance[$i];
            $Forwading->save();
        }
    }
    
    public function loadDrugsPlaned(Request $request) {
        $Product = new appProduct;
        $text = "<tr> <td> Pozycja " . $request->get("tmp") . "</td><td> <select name=position[] class=form-control><option value= ></option>";
        
        $list = $Product->where("id_users",Auth::User()->id)->orderBy("name")->get();
        foreach ($list as $list2) {
            $text .= "<option value=" . $list2->id  ." >" . $list2->name . "</option>";
        }
        $text .= "</select></td>        <td>
            <input type='text' name='pisitionName[]' class='form-control' value=''>
        </td></tr>";
        return $text;
        
    }
    
    public function updatePlaned(Request $request) {
        $this->deletePlaned($request->get("namePlaned"));
        if (!empty($request->get("position"))) {
            $this->createPlaned($request);
        }
    }
    public function deletePlaned($name) {
        $Planed = new Planned_drug;
        $Planed->where("id_users",Auth::User()->id)->where("name",$name)->delete();
    }
    private function createPlaned(Request $request) {
        for($i = 0;$i < count($request->get("position"));$i++) {
            $Planned_drug = new Planned_drug;
            $Planned_drug->name = $request->get("namePlaned");
            $Planned_drug->id_users = Auth::User()->id;
            $Planned_drug->id_products = $request->get("position")[$i];
            $Planned_drug->portion = $request->get("pisitionName")[$i];
            $Planned_drug->save();
        }
    }
    
}