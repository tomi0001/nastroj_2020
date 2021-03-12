<?php
/*
 * copyright 2020 Tomasz Leszczyński tomi0001@gmail.com
 * 
 */
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
use App\User;
use App\Group;
use App\Description;
use App\Forwarding_description;
use App\Forwarding_substance;
use App\Forwarding_group;
use App\Substance;
use DB;
use App\Http\Services\Common as common;
use Auth;
use App\Product as appProduct;

class DrugsUses {
    public $list;
    public $date_next;
    public $date;
    public $ifAlcohol;
    public $KG;
    


    public function selectRegistration2(int $id) {
         $use = new usee;
         $this->list = $use->join("products","products.id","usees.id_products")
                 ->where("usees.id",$id)
                 ->where("usees.id_users",Auth::User()->id)
                 ->selectRaw("products.name as name")
                ->selectRaw("products.how_percent as percent")
                ->selectRaw("usees.price as price")
                ->selectRaw("usees.date as date")
                ->selectRaw("usees.portion as portion")
                ->selectRaw("usees.id_products as id")
                ->selectRaw("usees.id as idDrugs")
                ->selectRaw("products.type_of_portion as type")
                 ->get();

    }






    public function sumEquivalent($listDrugs) {
        $forwarding_substances = new Forwarding_substance;
        $equivalent = array();
        $i = 0;
        foreach ($listDrugs as $list) {
            $tmp = $forwarding_substances->join("substances","substances.id","forwarding_substances.id_substances")
                    ->join("usees","usees.id_products","forwarding_substances.id_products")
                    ->selectRaw("substances.equivalent as equivalent")
                    ->selectRaw("usees.date as date")
                    ->selectRaw("usees.portion as portion")
                    ->where("forwarding_substances.id_products",$list->id)
                    ->where("usees.id",$list->idDrugs)->first();
            
               if (isset($tmp) and $tmp->equivalent != 0 ) {
                   
                $equivalent[$i] = $this->calculateEquivalent($tmp->portion, $tmp->equivalent, 10);
               
               }
               else {
                   $equivalent[$i] = 0;
               }
               
            $i++;
        }
        return $equivalent;
    }








    public function selectBenzo($id) {
        $substances = new Substance;
        $list = $substances->where("id_users",$id)
                           ->where("equivalent","!=",0)
                           ->where("equivalent","!=",null)->get();
        return $list;
        
    }




     public function selectProduct(int $id_users) {
        $Product  = new appProduct;
        $list = $Product->where("id_users",$id_users)
                ->orderBy("name")->get();
        return $list;
        
    }
     public function selectRegistration(int $id) {
         $use = new Usee;
         $select = $use->where("id",$id)->where("id_users",Auth::User()->id)->first();
         return $select;
    }     
    public function ifIdIsUsera(string $table,int $id) {
        
        $if = DB::table($table)->where("id",$id)->where("id_users",Auth::User()->id)->first();
        if (empty($if)) {
            return false;
        }
        else {
            return true;
        }
        
    }
    
    
    
    public function checkName(int $id,string $name,string $table) {
        
        $gro = DB::table($table)->where("id","!=",$id)->where("name",$name)->first();
        if (!empty($gro)) {
            return false;
        }
        else {
            return true;
        }
    }
    public function updateSubstance(Request $request,int $id) {
        $Forwarding_group = new Forwarding_group;
        $Forwarding_group->where("id_substances",$id)->delete();
        if (!empty($request->get("id"))) {
            $this->addForwardingSubstance($request,$id);
        }
        $this->updateName2($request,$id,"substances");
    }
    public function updateProduct(Request $request,int $id) {
        $Forwarding_group = new Forwarding_substance;
        $Forwarding_group->where("id_products",$id)->delete();
        if (!empty($request->get("id"))) {
            $this->addForwardingProduct($request,$id);
        }
        $this->updateName3($request,$id,"products");
    }  
   
    public function updateGroups(Request $request, int $id) {
        $group = new Group;
        $group->where("id",$id)->update(["name" => $request->get("name")]);
    }
    
    public function selectDrugs(int $id_users,$date) {
        $Drugs  = new Usee;
        $this->set_hour($id_users,$date);
        $this->list = $Drugs->join("products","products.id","usees.id_products")
                ->where("usees.id_users",$id_users)
                ->where("usees.date",">=",$this->date)
                ->where("usees.date","<",$this->date_next)
                ->selectRaw("products.name as name")
                ->selectRaw("products.how_percent as percent")
                ->selectRaw("usees.price as price")
                ->selectRaw("usees.date as date")
                ->selectRaw("usees.portion as portion")
                ->selectRaw("usees.id_products as id")
                ->selectRaw("usees.id as idDrugs")
                ->selectRaw("products.type_of_portion as type")
                ->orderBy("date")
                ->get();

        
    }
    
    

    
    
    public function changeChar($list) {
        
        foreach ($list as $description) {
            $description->description = $this->charset_utf_fix($description->description);
        }
    }
    public function selectDrugsAjax(int $id_users,$dateStart,$dateEnd) {
        $tmp = strtotime(str_replace("/", " ", $dateStart));
        $dateStart = date("Y-m-d H:i:s",$tmp - 3600);
        $Drugs  = new Usee;
        $listAjax = $Drugs->join("products","products.id","usees.id_products")
                ->where("usees.id_users",$id_users)
                ->where("usees.date",">=",$dateStart)
                ->where("usees.date","<",$dateEnd)
                ->selectRaw("products.name as name")
                ->selectRaw("products.how_percent as percent")
                ->selectRaw("usees.price as price")
                ->selectRaw("usees.date as date")
                ->selectRaw("usees.portion as portion")
                ->selectRaw("usees.id_products as id")
                ->selectRaw("usees.id as idDrugs")
                ->selectRaw("products.type_of_portion as type")
                ->orderBy("date")
                ->get();
        return $listAjax;

        
    }
    
    
    public function processPrice($listDrugs,$price = "") {
        
        foreach ($listDrugs as $list) {
            if ($price == "") {
              $list->price = $this->calculatePrice($list->price);
            }
            else {
                $list->price = $this->calculatePrice($price);
            }
            
        }
    }   
    private function calculatePrice($price) {
        $gr = "";
        $zl = "";
        $price = round($price,2);
        if (strstr($price,".")) {
            $div = explode(".",$price);
                if (strlen($div[1]) == 1) {
                    $gr =  $div[1] . "0 Gr";
                }
                else if  (strlen($div[1]) == 2 and $div[1][0] == 0) {
                    $gr =  $div[1][1] . " Gr";
                    
                }
                else if (strlen($div[1]) == 2) {
                    $gr =  $div[1] . " Gr";
                }
                else {
                    $zl = $div[0] . " zł ";
                }
            if ($div[0] > 0) {
                $zl = $div[0] . " zł ";
            }
        }
        if (!strstr($price,".")) {
            $zl = $price . " zł ";
        }
        return $zl . $gr;
    }
    private function set_hour(int $id_users,$date) {
        $user = new User;
        
        $hour = $user->where("id",$id_users)->first();
        $date_div = explode("-",$date);
        $second = mktime($hour->start_day,0,0,$date_div[1],$date_div[2],$date_div[0]);
        $second_next = $second + (24 * 3600);
        $date_next = date("Y-m-d H:i:s",$second_next);
        $date_back = date("Y-m-d H:i:s",$second);
        $this->date_next = $date_next;
        $this->date = $date_back;
        
    }
 
 


    public function calculateEquivalent($portion,$equivalent,$diazepam) {
        return round(($portion / $equivalent) * $diazepam,2);
    }   
    public function checkIfDescription($DrugsList) {
        $idDescription = array();
        $i = 0;
        $Forwarding_description = new Forwarding_description;
        foreach ($DrugsList as $list) {
            $id = $Forwarding_description->where("id_usees",$list->idDrugs)->count();
            if ($id > 0) {
                $idDescription[$i] = true;
            }
            else {
                $idDescription[$i] = false;
            }
            $i++;
        }
        return $idDescription;
    }
    
    
    
    public function separateDrugs() {
        $array = [];
        $i = 0;
        foreach ($this->list as $list) {
            $array[$i]["second"] = strtotime($list->date);
            $array[$i]["bool"] = false;
            if ($i != 0 and $array[$i-1]["second"] < $array[$i]["second"] - 140) {
                $array[$i-1]["bool"] = true;
                
            }
          
            $i++;
        }
        return $array;
    }
    
    
    

    public function checkDrugs(int $id_users,$idDrugs) {
         $Use = new usee;
         $check = $Use->where("id_users",$id_users)
                    ->where("id",$idDrugs)->first();
         if ($check == "") {
             return false;
         }
         else {
             return true;
         }
    }



    
    public function returnIdProduct($id) {
        $Use = new usee;
        $forwarding_substances = new Forwarding_substance;
        $listIdSub = array();
        $selectIdProduct = $Use->where("id",$id)->first();
        $selectIdSub1 = $forwarding_substances->selectRaw("forwarding_substances.id_substances as id_substances")
                ->selectRaw("products.type_of_portion as type_of_portion")
                ->join("products","products.id","forwarding_substances.id_products")
                ->where("forwarding_substances.id_products",$selectIdProduct->id_products)->get();
        $i = 0;
        foreach ($selectIdSub1 as $selectIdSub2) {
               $listIdSub[$i] = $selectIdSub2->id_substances;
               //print "d";
               if ($selectIdSub2->type_of_portion == 2) {
                   
                   $this->ifAlcohol = true;
               }
               else if ($selectIdSub2->type_of_portion == 4) {
                   $this->KG = true;
                   
               }
               $i++; 
        }
        //var_dump($listIdSub);
        //print ($i);
        $this->countProduct = $i;
         $selectIdSub3 = $forwarding_substances
                            ->wherein("id_substances",$listIdSub)
                            //->where
                            ->groupBy("id_products")
                            ->havingRaw("count(id_products) = $i")
                            //->limit($i)
                            ->get();
         $array = array();
         
         $i = 0;
         //var_dump($selectIdSub3);
         foreach ($selectIdSub3 as $selectIdSub4) {
             $array[$i] = $selectIdSub4->id_products;
             $i++;
         }
         //var_dump($array);
         if ($i == 0) {
             return array($selectIdProduct->id_products);
         }
        
         return $array;
                
    }    

    
    
    public function returnDateDrugs($id ) {
       $Use = new usee;
       $date = $Use->where("id",$id)->first();
       return $date->date;
    }
    
    
    
    public function sumAverage($arrayId,$date,$id,$startDay,$date2 = "") {
        
       $Use = new usee;
       $start = $startDay;
       $listen = usee::query();

       $id_users = $id;
       //if ($ifAlcohol == true) {
              
                    $listen->join("products","products.id","usees.id_products");
        //}


        $listen->selectRaw("DATE(IF(HOUR(usees.date) >= '$start', DATE,Date_add(usees.date, INTERVAL - 1 DAY))) as DAT" );
        $listen->selectRaw("products.type_of_portion as type" );

                if ($this->ifAlcohol == true) {
                    
              
                    $listen->selectRaw("round(SUM((usees.portion * products.how_percent / 100)),2) AS portion");
                }
                else if ($this->KG == true) {
                     $listen->selectRaw("(SUM(usees.portion)  /  count(usees.portion)) AS portion");
                    $listen->selectRaw("count(usees.portion) AS count");
                }
                else {
                    
                   $listen->selectRaw("SUM(usees.portion) AS portion");
                    $listen->selectRaw("count(usees.portion) AS count");
                }
                   $listen->selectRaw("usees.date as date")
                   ->wherein("usees.id_products",$arrayId);


        if ($date2 == "") {
                   $listen->where("usees.date","<=",$date);

        }
        else {
            $listen->where("usees.date",">=",$date)
                    ->where("usees.date","<=",$date2);

        }
                   $listen->where("usees.id_users",$id_users)
                   ->groupBy("DAT")
                   //->havingRaw("")
                   ->orderBy("DAT","DESC");


                
                $list = $listen->get();

        
       //print count($list);
       $array = array();
       $data1 = array();
       $time = array();
       $dose = array();
       $count = array();
        $j = 0;
        $z = 0;
        $i = 0;
        $x = 0;
        $type = "";
        foreach ($list as $rekord2) {
            switch ($rekord2->type) {
                case '3': $type = " ilości";
                    break;
                case '2': $type = " mililitry";
                    break;
                case '4': $type = " KG";
                    break;
                default: $type = " mg";
                    break;
            
            }
            //print $rekord2->date . "<br>";
            $data1[$i] = explode(" ",$rekord2->DAT . " $start:00:00");
            $dose[$i] = $rekord2->portion;
            $count[$i] = $rekord2->count;
            $data = explode("-",$data1[$i][0]);
            $data2 = explode(":",$data1[$i][1]);
            $time[$i] = strToTime($rekord2->DAT . " $start:00:00");
            if ($i == 0) {
                $array[$j][0] = $dose[$i] . $type;
                $array[$j][1] = $data1[$i][0];
                $array[$j][2] = $data1[$i][0];
                $array[$j][3] = 0;
                $array[$j][4] = $count[$i];
              
              
            }
            elseif ($i != 0 and (($time[$i-1]  - 146400) >  $time[$i]))   {
                $array[$j][2] = $data1[$i-1][0];   
                $array[$j][3] = 1;
                $j++;               
                $array[$j][0] = $dose[$i] . $type;
                $array[$j][1] = $data1[$i][0];
                $array[$j][2] = $data1[$i][0];
                $array[$j][3] = 0;
                $array[$j][4] = $count[$i];
                //$x--;
                //break;
            }
            elseif ($i != 0 and $dose[$i] != $dose[$i-1]) {
                $array[$j][2] = $data1[$i-1][0];
                $j++;
                $array[$j][0] = $dose[$i] . $type;
                $array[$j][1] = $data1[$i][0];
                $array[$j][2] = $data1[$i][0];
                $array[$j][3] = 0;
                $array[$j][4] = $count[$i];
                
             
                
                
            }
            else if ($i != 0 and $count[$i] != $count[$i-1]) {
                $array[$j][2] = $data1[$i-1][0];
                $j++;
                $array[$j][0] = $dose[$i] . $type;
                $array[$j][1] = $data1[$i][0];
                $array[$j][2] = $data1[$i][0];
                $array[$j][3] = 0;
                $array[$j][4] = $count[$i];
                 
            }
            elseif ($i == count($list)-1) {
                $array[$j][0] = $dose[$i] . $type;
                $array[$j][2] = $data1[$i][0];
                
                $array[$j][3] = 0;
               
        
            }
            
        
            $i++;
            $x++;
        }
           $this->sumDayAverage = $x;
       return $array;
       
    }
    
    
    
    public function sumDifferentDay($date1,$date2) {
        
        $date11 = StrToTime($date1);
        $date22 = StrToTime($date2);
        $result = $date11  - $date22;
        return (int)($result  / 3600 / 24) + 1;
        
        
    }
    public function selectDescription($id,$idUsers) {
         
         
        $Description = new Forwarding_description;
        
        $list = $Description->join("descriptions","descriptions.id","forwarding_descriptions.id_descriptions")
                ->selectRaw("descriptions.description as description")
                ->selectRaw("descriptions.date as date")
                ->where("forwarding_descriptions.id_usees",$id)
                ->where("descriptions.id_users",$idUsers)->get();
       
        return $list;
           
          
        
    }
    
    private function updateName3(Request $request,int $id,string $table) {
        DB::table($table)->where("id",$id)->update(["name"=>$request->get("name"),"how_percent" => $request->get("percent"),
            "type_of_portion" => $request->get("portion"),"price" => $request->get("price"),"how_much" => $request->get("how")]);
        
    }   
    private function updateName2(Request $request,int $id,string $table) {
        DB::table($table)->where("id",$id)->update(["name"=>$request->get("name"),"equivalent" => $request->get("equivalent")]);
        
    }
    private function addForwardingSubstance(Request $request,int $id) {
        for ($i = 0;$i < count($request->get("id"));$i++) {
            $Forwarding_group = new Forwarding_group;
            $Forwarding_group->id_substances = $id;
            $Forwarding_group->id_groups = $request->get("id")[$i];
            $Forwarding_group->save();
        }
        
    }    
    
    private function addForwardingProduct(Request $request,int $id) {
        for ($i = 0;$i < count($request->get("id"));$i++) {
            $Forwarding_group = new Forwarding_substance;
            $Forwarding_group->id_products = $id;
            $Forwarding_group->id_substances = $request->get("id")[$i];
            $Forwarding_group->save();
        }
        
    }    
    
    
    public function sumPercentAlkohol() {
        $sum = 0;
        foreach ($this->list as $list) {
            if ($list->percent == null) {
                $list->percent = 0;
            }
            else {
                $list->percent = $this->sumAlkohol($list->portion,$list->percent);
                $sum += $list->percent;
            }
        }
        return $sum;
    }
    
    public function sumAllEquivalent($equivalent) {
        $sum = 0;
        for ($i=0;$i < count($equivalent);$i++) {
            $sum += $equivalent[$i];
        }
        return $sum;
    }
    


    public function selectPortion($id) {
        $usee = new Usee;
        $portion = $usee->find($id);
        return $portion;
    }

    public function selectSubstance(int $id_users) {
        $substance = new Substance;
        $list = $substance->where("id_users",$id_users)
                ->orderBy("name")->get();
        return $list;
    }


    public function selectBenzoName($id) {
        $substances = new Substance;
        $list = $substances->find($id);
        return $list;
        
    }
    public function selectEquivalent($id) {
        $substances = new Substance;
        $equivalent = $substances->find($id);
        return $equivalent->equivalent;
        
    }
    private function sumAlkohol($portion,$percent) {
        return  ($portion * $percent) / 100;
        
    }

    
    
}
