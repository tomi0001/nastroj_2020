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
use App\Action;
use App\Mood as AppMood;
use App\Moods_action;
use App\Actions_plan;
use App\Sleep;
use App\Usee;
use App\Product as Product;
use App\Group as Group;
use App\Substance as Substances;
use App\Forwarding_substance as Forwarding_substance;
use App\Forwarding_group as Forwarding_group;
use App\Http\Services\Mood;
use DB;
use App\Http\Services\Common;

use Auth;

class SearchDrugs {
    
    public $arrayFindPro = [array(),0,0];
    public $arrayFindSub = [array(),0,0];
    public $arrayFindGro = [array(),0,0];
    public $type;
    public $stringPro = [];
    public $stringSub = [];
    public $stringGro = [];
    private $sort = "date";
    private $string2 = [];
    private $string3 = [];
    public $id_product =array();
    public $question;
    public $bool = false;
    public function checkField() {

        
    }
    
    private function divSearchString($string,$type) {
        $array = [];
        if (strstr($string,",")) {
            $array = explode(",",$string);
            for ($i=0;$i < count($array);$i++) {
                switch ($type) {
                    case "products":
                        array_push($this->stringPro, $array[$i]);
                        break;
                    case "substances":
                        array_push($this->stringSub, $array[$i]);
                        break;
                    case "group":
                        array_push($this->stringGro, $array[$i]);
                        break;
                }
            }
        }
        else {
            switch ($type) {
                case "products":
                    array_push($this->stringPro, $string);
                    break;
                case "substances":
                     array_push($this->stringSub, $string);
                    break;
                case "group": 
                    array_push($this->stringGro, $string);
                    break;
            }
        }
    }
    /*
    public function findNot() {
        $array = array();
        //$bool = false;
        
        if (Input::get("productNot") != "") {
            $this->divSearchString(Input::get("productNot"),"products");
            for ($i=0;$i < count($this->stringPro);$i++) {
                $this->arrayFindPro[$i] = $this->findString($this->stringPro[$i],"products");
            }
            $this->type = "products";
            if (count($this->arrayFindPro) != 0) {
                for ($i=0;$i < count($this->stringPro);$i++) {
                    $this->string2[$i] = $this->arrayFindPro[$i][0][1];
                }
            }
            $this->selectIdProduct();
            $this->bool = true;
        }
        
        if (Input::get("substancesNot") != "") {
            //print "dos";
            $this->divSearchString(Input::get("substancesNot"),"substances");
                        for ($i=0;$i < count($this->stringSub);$i++) {

                                $this->arrayFindSub[$i] = $this->findString($this->stringSub[$i],"substances");
                        }
            $this->type = "substances";
            if (count($this->arrayFindSub) != 0) {
                for ($i=0;$i < count($this->stringSub);$i++) {
                    $this->string2[$i] = $this->arrayFindSub[$i][0][1];
                }
            }
            $this->selectIdSubstances(true);
            $this->bool = true;
        }
        if (Input::get("groupNot") != "") {
            //print "dd";
            $this->divSearchString(Input::get("groupNot"),"group");
            for ($i=0;$i < count($this->stringGro);$i++) {
                $this->arrayFindGro[$i] = $this->findString($this->stringGro[$i],"groups");
            }
            $this->type = "groups";
            if (count($this->arrayFindGro) != 0) {
                for ($i=0;$i < count($this->stringGro);$i++) {
                    $this->string3[$i] = $this->arrayFindGro[$i][0][1];
                }
            }
            $this->selectIdGroups(true);
            $this->bool = true;
        }
        //return $bool;
    }
     * 
     */
    public function find(Request $request,$id) {
        $array = array();
        //$bool = false;
        //print "s";
        if ($request->get("product") != "") {
            $this->divSearchString($request->get("product"),"products");
            for ($i=0;$i < count($this->stringPro);$i++) {
                
                $tmp = $this->findString($this->stringPro[$i],"products",$id);
                if ($tmp != 0) {
                    for ($j=0;$j < count($tmp);$j++) {
                        $this->arrayFindPro[$j+$i] = $tmp[$j];
                    }
                }

            }
            $this->type = "products";
            //print ("<pre>");
            //print_r($this->arrayFindPro);
            //print ("</pre>");
            //print $this->arrayFindPro[1][0][1];
            
            //$z = 0;
            //for ($j=0;$j < count($this->stringPro);$j++) {
                //if (count($this->arrayFindPro[$j]) ) {
                //var_dump($this->arrayFindPro);
            /*
                    for ($i=0;$i < count($this->arrayFindPro);$i++) {
                        
                        if (isset($this->arrayFindPro[$i]) ) {
                            //print $this->arrayFindPro[$i]->name;
                            $this->string2[$z] = $this->arrayFindPro[$i]->name;
                        }
                        $z++;
                    }
                //}
            //}
             
             * 
             */
            
            if (is_int(($this->arrayFindPro[0]))) {
                $this->selectIdProduct();
            }
            $this->bool = true;
        }
        
        if ($request->get("substances") != "") {
            $this->divSearchString($request->get("substances"),"substances");
                        for ($i=0;$i < count($this->stringSub);$i++) {

                                $this->arrayFindSub[$i] = $this->findString($this->stringSub[$i],"substances",$id);
                        }
            $this->type = "substances";
            
            $this->selectIdSubstances();
            $this->bool = true;
        }
        if ($request->get("group") != "") {
            $this->divSearchString($request->get("group"),"group");
            for ($i=0;$i < count($this->stringGro);$i++) {
                $this->arrayFindGro[$i] = $this->findString($this->stringGro[$i],"groups",$id);
            }
            $this->type = "groups";

            $this->selectIdGroups();
            $this->bool = true;
        }
        //$this-findNot();
        //return $bool;
    }
    
    public function checkArrayFindPro($count) {
        $z = 0;
        for ($i=0;$i < $count;$i++) {
            if (!isset($this->arrayFindPro[$i]) and (count($this->arrayFindPro[$i]) == 0) or 
                    (!isset($this->arrayFindPro[$i][0][0]) or $this->arrayFindPro[$i][0][0] <= 0.5) 
                    ) {
                //return false;
                $z++;
            }
        
            //return true;
        }
        if ($z == $i) {
            return false;
        }
        else {
            return true;
        }
    }
    public function checkArrayFindSub($count) {
        $z = 0;
        for ($i=0;$i < $count;$i++) {
            if (!isset($this->arrayFindSub[$i]) and (count($this->arrayFindSub[$i]) == 0) or 
                    (!isset($this->arrayFindSub[$i][0][0]) or $this->arrayFindSub[$i][0][0] <= 0.5) 
                    ) {
                $z++;
            }
        
            //return true;
        }
        if ($z == $i) {
            return false;
        }
        else {
            return true;
        }
    }
    public function checkArrayFindGro($count) {
        $z = 0;
        for ($i=0;$i < $count;$i++) {
            if (!isset($this->arrayFindGro[$i]) and (count($this->arrayFindGro[$i]) == 0) or 
                    (!isset($this->arrayFindGro[$i][0][0]) or $this->arrayFindGro[$i][0][0] <= 0.5) 
                    ) {
                $z++;
            }
        
            //return true;
        }
        if ($z == $i) {
            return false;
        }
        else {
            return true;
        }
    }
     
    public function selectIdProduct() {
        $product = new product;
        $id = $product->whereIn("id",$this->arrayFindPro)->get();
        if (isset($id) ) {
            foreach ($id as $id2) {
                array_push($this->id_product, $id2->id);
            }
        }
        
    }
    public function selectIdSubstances($not = false) {
        $substance = substances::query();
       $substance->selectRaw("products.id as id")
                ->join("forwarding_substances","forwarding_substances.id_substances","substances.id")
                ->join("products","products.id","forwarding_substances.id_products");
                if ($not == false) {
                    $substance->whereIn("substances.id",$this->arrayFindSub);
                }
                /*
                else {
                    $substance->whereNotIn("substances.id",$this->string3);
                }
                 * 
                 */
                //->whereIn("substances.name",$this->string2)->get();
       
        $id = $substance->get();
        $i = 0;
        foreach ($id as $id_product) {
            array_push($this->id_product,$id_product->id);
            $i++;
        }
        
    }
    public function selectIdGroups($not = false) {
        //$group = new group;
        $group = group::query();
         $group->selectRaw("products.id as id")
                ->selectRaw("products.name as name")
                ->join("forwarding_groups","groups.id","forwarding_groups.id_groups")
                ->join("substances","substances.id","forwarding_groups.id_substances")
                ->join("forwarding_substances","substances.id","forwarding_substances.id_substances")
                ->join("products","products.id","forwarding_substances.id_products");
                if ($not == false) {
                    $group->whereIn("groups.id",$this->arrayFindGro);
                }
                else {
                    $group->whereNotIn("groups.name",$this->string3);
                }
               $id =  $group->get();
        $i = 0;
        foreach ($id as $id_product) {
            array_push($this->id_product,$id_product->id);
            $i++;
        }
        
    }
    private function selectHourStart(int $id_users) {
        $user = new User;       
        $hour = $user->where("id",$id_users)->first();
        return $hour->start_day;
        
    }
    private function setSort(Request $request) {
        if ($request->get("sort") == "portion" and $request->get("day") != "") {
            $this->sort = "por";
        }
        else if ($request->get("sort") == "portion") {
            $this->sort = "portion";
        }
        else if ($request->get("sort") == "product") {
            $this->sort = "product";
        }
        else if ($request->get("sort") == "hour") {
            $this->sort = "hour2";
        }
    }
    private function setWhere(Request $request,$bool,$search) {
        if (count($this->id_product) == 0 and ($request->get("data1") == "" or $request->get("data2") == "")) {
            
            $data2 = date("Y-m-d");
            $data1 = date("Y-m-d", time() - 2592000);
        }
        else {
            $data1 = $request->get("data1");
            $data2 = $request->get("data2");
        }
        if ($data1 != "") {
            $this->question->where("usees.date",">=",$data1);
        }
        if ($data2 != "") {
            $this->question->where("usees.date","<=",$data2);
        }
        if ($request->get("dose1") != "" and $request->get("day") == "") {
            $this->question->where("usees.portion",">=",$request->get("dose1"));
        }
        if ($request->get("dose2") != "" and $request->get("day") == "") {
            $this->question->where("usees.portion","<=",$request->get("dose2"));
        }
        if ($request->get("hour1") != "") {
            $this->question->whereRaw("hour(usees.date) >=  " . $request->get("hour1"));
        }
        if ($request->get("hour2") != "")  {
            $this->question->whereRaw("hour(usees.date)<=" . $request->get("hour2"));
        }
        if ($request->get("search") != "") {
            $this->question->where("descriptions.description","like","%" . $search . "%");
        }
        if ($request->get("inDay") != "") {
            $this->question->where("descriptions.description","!=", "");
        }
        
        if ($bool == true) {
                $this->question->whereIn("products.id",$this->id_product);
        }
        
        
    }
    private function setGroup(Request $request,$hour) {
               if ($request->get("day") != "") {
                    $this->question->groupBy(DB::Raw("(DATE(IF(HOUR(usees.date) >= '$hour', usees.date,Date_add(usees.date, INTERVAL - 1 DAY) )) )"));
                    if ($request->get("dose1") != "" ) {
                      $this->question->havingRaw("sum(usees.portion) >= " . $request->get("dose1"));
                    }
                    if ($request->get("dose2") != "" ) {
                      $this->question->havingRaw("sum(usees.portion) <= " . $request->get("dose2"));
                    }
                }
                else {
                    $this->question->groupBy("usees.id");
                }
        
    }
 
    public function selectDrugs($dateStart,$dateEnd,$id) {
        //$drugs = new drugs;
        //$drugs
        $this->question =  usee::query();
        $product = $this->question
                        ->selectRaw("products.name as products")
                        ->selectRaw("usees.id as id2")
                        ->selectRaw("usees.id_products as id")
                        ->join("products","usees.id_products","products.id")
                        ->where("date",">=",$dateStart)
                        ->where("date","<=",$dateEnd)
                        ->where("usees.id_users",$id)
                        ->groupBy("usees.id_products")
                ->paginate(10);
        
        return $product;
        //return $product;
        /*
        
        foreach ($product as $list) {
            //print ("<pre>");
            $array = $drugs->returnIdProduct($list->id);
            $hourDrugs = $drugs->sumAverage($list,$dateStart,$dateEnd);
               $array = array();
             for ($i=0;$i < count($hourDrugs);$i++) {
                $array[$i] = $drugs->sumDifferentDay($hourDrugs[$i][1],$hourDrugs[$i][2]);
                print $array[$i];
                 
             }
            //print($a->products) . "<br>";
        }
         
         
         * 
         */
    }
    

    

    public function createQuestions(Request $request,$bool,$id) {
        //$drugs = new drugs;
        $this->question =  usee::query();
        $hour = Auth::User()->start_day;
        $search = Common::charset_utf_fix2($request->get("search"));
        $this->question
                ->select( DB::Raw("(DATE(IF(HOUR(usees.date) >= '$hour', usees.date,Date_add(usees.date, INTERVAL - 1 DAY) )) ) as dat  "))   
                ->selectRaw("hour(usees.date) as hour")
                ->selectRaw("round(sum(usees.portion),2) as por")
                ->selectRaw("day(usees.date) as day")
                ->selectRaw("month(usees.date) as month")
                ->selectRaw("year(usees.date) as year")                
                ->selectRaw("usees.portion as portion")
                ->selectRaw("usees.date as date")
                ->selectRaw("usees.id_products as id")
                ->selectRaw("usees.id as id_usees")
                ->selectRaw("time(usees.date) as hour2")
                ->selectRaw("descriptions.description as description")
                ->selectRaw("descriptions.date as date_description")
                ->selectRaw("usees.id_products as product")
                ->selectRaw("products.name as name")
                ->selectRaw("products.type_of_portion as type")
                ->leftjoin("forwarding_descriptions","usees.id","forwarding_descriptions.id_usees")
                ->leftjoin("descriptions","descriptions.id","forwarding_descriptions.id_descriptions")
                ->leftjoin("products","products.id","usees.id_products")
                ->where("usees.id_users",$id);

        $this->setWhere($request,$bool,$search);
        $this->setGroup($request,$hour);
         
             $this->setSort($request);
   
            $this->question->orderBy($this->sort,"DESC");
            $list = $this->question->paginate(10);
            
        return $list;
        
    }


    public function changeArray($list) {
        $day = array();
        $i = 0;
        $tmp = array();
        foreach ($list as $list2) {
            
            $day[$i][0] = $list2->dat;
            //print $list2->dat;
            //if ($list2->dat == "") {
              //  print "dd";
                //$day[$i][1] = 0;
                //$day[$i][2] = 0;
                //$day[$i][3] = 0;
                
            //}
            //else {
            if (strstr($list2->dat,"-") ) {
                $tmp = explode("-",$list2->dat);
                $day[$i][1] = $tmp[0];
                $day[$i][2] = $tmp[1];
                $day[$i][3] = $tmp[2];
            }
            else {
                $day[$i][1] = "";
                $day[$i][2] = "";
                $day[$i][3] = "";
            }
            //}
            switch ($list2->type) {
                case 1: 
                    $day[$i][4] = "Mg";
                break;
                case 2: 
                    $day[$i][4] = "militry";
                break;
                default:
                    $day[$i][4] = "ilości";
                
            }
            $i++;
        }
        return $day;
    }
    
    private function findString($search,$table,$id) {
        
        $array = array();
        $find = DB::table($table)->where("name","like","%$search%")->where("id_users",$id)->get();
        //var_dump($find);
        /*
        $i = 0;
        foreach ($find as $find2) {
             $find3 = DB::table($table)->get();

                $result = $this->findSuchString($search,$find2->name);
                if ($result >= 0.5) {
                   $array[$i][0] =  $result;
                   $array[$i][1] =  $find2->name;
                 
                   $i++;
                }

        }
         * 
         */

        //rsort($array);

        
        $array = [];
        $i = 0;
        foreach ($find as $find2) {

            $array[] = $find2->id;
            $i++;
        }
        if ($i == 0) {
            return 0;
        }
        return $array;
        
    }
    private function findSuchString($text1,$text2) {
  
        $how1 = strlen($text1);
        $how2 = strlen($text2);

        if ($how1 > $how2) $how = $how1;
        else $how = $how2;
        $correct = 0;
        for ($i=0;$i< $how;$i++) {

            if (isset($text1[$i]) and isset($text2[$i]) and $text1[$i] != $text2[$i] ) $correct--;
            else if (isset($text1[$i]) and isset($text2[$i]) and  $text1[$i] == $text2[$i]) $correct++;
        }
        $result = ($how1 + $how2) / 2;
        if ($result == 0) {
            $result = 1;
        }
        return $correct / $result;
      }
    
}
