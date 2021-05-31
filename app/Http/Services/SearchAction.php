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
use App\Actions_day as ActionDay;
use App\Moods_action;
use App\Actions_plan;
use App\Sleep;
use App\Http\Services\Mood;
use DB;
use App\Http\Services\Common;
use App\User;


use Auth;

class SearchAction {
    
    
    public $dateStart;
    public $dateTo;
    public $question;
    public $idUser;
    public $count;
    
    function __construct(Request $request,$dateStart,$dateTo,$bool = 0) {
        if ($bool == 0) {
            $this->idUser = Auth::User()->id;
        }
        else {
            $this->idUser = Auth::User()->id_user;
        }
        if ($dateStart == "") {
            $dateStart = explode(" ",User::firstMood($this->idUser)->date_start);
            $this->dateStart = $dateStart[0];
        }
        else {
            $this->dateStart = $dateStart;
        }
        if ($dateTo == "") {
            $this->dateTo = date("Y-m-d");
        }
        else {
            $this->dateTo = $dateTo;
        }

    }
    
    public function createQuestion(Request $request,$id) {
        $this->question =  ActionDay::query();
        $this->question->join("actions","actions.id","actions_days.id_actions");
        $this->question->selectRaw("actions_days.date as dat");
        $this->question->selectRaw("actions.name as name");
        $this->question->selectRaw("actions.id as id_actions");
        $this->question->selectRaw("YEAR(actions_days.date) as year");
        $this->question->selectRaw("MONTH(actions_days.date) as month");
        $this->question->selectRaw("DAY(actions_days.date) as day");
        $this->question->where("actions_days.date",">=",$this->dateStart)->where("actions_days.date","<=",$this->dateTo);
        if (is_array($request->get("actions"))  ) {
            $this->setHavingAction($request);
        }
        $this->question->orderBy("date","DESC");
        $this->count = $this->question->count();
        return $this->question->paginate(15);
        
        
    }
    private function setHavingAction(Request $request) {

        $this->question->where(function ($query) use ($request) {
        for ($i=0;$i < count($request->get("actions") );$i++) {
            //print $request->get("actions")[$i];
            if ($request->get("actions")[$i] != "") {
                $query->orwhereRaw("actions.name like '%" . $request->get("actions")[$i]  . "%'");

            }
            }});

    }
}