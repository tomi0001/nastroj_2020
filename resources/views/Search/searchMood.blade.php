@extends('Layout.Main')

@section('content')
<body onload='hideDiv({{count($list)}})'>
<br>
@if ($count == 0)
    <div class="searchError">Nie ma żadnych wyników</div>
@else
    <div class="searchCount">Ilośc wyników {{$count}}</div>
@endif
<div class="searchaction">
    <table class="table">
        <thead class="thead-dark titleThead">
        <tr>
            <th class="center" width="150px">
                Data zaczęcia
                
            </th>
            <th class="center" width="150px">
                Data skończenia
                
            </th>
            <th class="center" width="150px">
                Poziom nastroju
                
            </th>
            <th class="center" width="150px">
                Poziom lęku
                
            </th>
            <th class="center" width="150px">
                Poziom zdenerwowania
                
            </th>
            <th class="center" width="150px">
                Poziom pobudzenia
                
            </th>

        </tr>
        </thead>
    
        @for ($i=0;$i < count($list);$i++)
            
        @if ($i == 0 or ($list[$i]->dat != $list[$i-1]->dat ))

        
        <tr>
            <td colspan="6">
                <br>
                <div class="title center">{{$list[$i]->dat}} {{\App\Http\Services\Common::returnDayWeek($list[$i]->dat)}}</div>
                <br>
           
                <table class="table">
                @foreach (\App\Moods_action::ifExistActionForDay($list[$i]->dat,$id) as $action)
                    
                    <tr>
                        @if (\App\Action::selectNameAction($action->action,$id) != null)
                            <td>{{\App\Action::selectNameAction($action->action,$id)->name}} </td><td> {{$action->minute}} minut wykonania </td>
                        @endif
                        
                    </tr>
                   
                @endforeach
                </table>

            </td>
        </tr>
            
        @endif
        
        <tr class="search">
            <td colspan="6">
              <table width="100%" border="0">
            
                    <tr>
                        <td class="center" width="150px">

                        {{$list[$i]->date_start}}

                    </td>
                    <td class="center"  width="16%" width="150px">
                        {{$list[$i]->date_end}}

                    </td>
                    
                        <td class="center"  width="16%" width="150px">
                            @if (!isset($list[$i]->nas))
                            {{$list[$i]->level_mood}}
                            @else
                            {{$list[$i]->nas}}
                            @endif


                        </td>
                        <td class="center"  width="16%" width="150px">

                            @if (!isset($list[$i]->nas))
                            {{$list[$i]->level_anxiety}}
                            @else
                            {{$list[$i]->nas2}}
                            @endif
                        </td>
                        <td class="center"  width="16%" width="150px">
                            @if (!isset($list[$i]->nas))
                            {{$list[$i]->level_nervousness}}
                            @else
                            {{$list[$i]->nas3}}
                            @endif


                        </td>
                        <td class="center"  width="16%" width="150px">
                            @if (!isset($list[$i]->nas))
                            {{$list[$i]->level_stimulation}}
                            @else
                            {{$list[$i]->nas4}}
                            @endif


                        </td>
              
                    
                  </tr>
                     <tr>
                        <td colspan="6">
                            <br>
                         
                            @if (!isset($list->nas))
                            <div class="titlemood{{$lista[$i]['color_mood']}}" style='width: {{$percent[$i]["percent"]}}%';>&nbsp;</div>
                            @else
                            <div class="titlemood{{$lista[$i]['color_nas']}}" style='width: {{$percent[$i]["percent"]}}%';>&nbsp;</div>

                            @endif
                   
                         
                        </td>
                    </tr>
                     <tr>
                        <td>
                            <br>
                            {{$percent[$i]['second']}}
                        </td>
                        
                        <td>
                            <br>
                            
                            @if ($list[$i]->what_work != "")
                            <button onclick="showDescription('{{route('mood.showDescription')}}',{{$list[$i]->id}},{{$i}})" class='btn btn-primary btn-lg'>Co robiłeś</button>
                            @else
                            <button class='btn btn-danger btn-lg' disabled>Nic nie robiłeś</button>
                            @endif
                        </td>
                        <td>
                            <br>
                             @if ($list[$i]->id_actions != "")
                            <button onclick="showAction('{{route('action.show')}}',{{$i}},{{$list[$i]->id}})" class='btn btn-primary btn-lg'>pokaż akcje</button>
                            @else
                            <button class='btn btn-danger btn-lg' disabled>Nie było akcji</button>
                            @endif
                        
                        </td>
                        
                        <td>
                            <br>
             
                           <a href='{{route('main')}}/{{$list[$i]->year}}/{{$list[$i]->month}}/{{$list[$i]->day}}#id_{{$list[$i]->id}}'><button class='btn btn-primary btn-lg'>Idź do dnia</button></a>

                        </td>
                    </tr>
                    <tr>
                        <td colspan="6">
                            <br>
                            <div id='showActions{{$i}}' style="width: 100%;"> </div>
                            <br>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="6">
                            <br>
                            <div id='showDescription{{$i}}'></div>
                            
                            <br>
                        </td>
                    </tr>
                    
                    
        </table>
           </td> 
           
        </tr>
        
        
        @endfor

        <tr>
            <td colspan="6" class="center">
                @php 
                $list->appends(['sort'=>Request::get('sort')])
                ->appends(['moodFrom'=>Request::get("moodFrom")])
                ->appends(['moodTo'=>Request::get("moodTo")])
                ->appends(['anxietyFrom'=>Request::get("anxietyFrom")])
                ->appends(['anxietyTo'=>Request::get("anxietyTo")])
                ->appends(['voltageFrom'=>Request::get("voltageFrom")])
                ->appends(['voltageTo'=>Request::get("voltageTo")])
                ->appends(['stimulationFrom'=>Request::get("stimulationFrom")])
                ->appends(['stimulationTo'=>Request::get("stimulationTo")])
                ->appends(['dateFrom'=>Request::get("dateFrom")])
                ->appends(['dateTo'=>Request::get("dateTo")])
                ->appends(['timeFrom'=>Request::get("timeFrom")])
                ->appends(['timeTo'=>Request::get("timeTo")])
                ->appends(['longMoodFromHour'=>Request::get("longMoodFromHour")])
                ->appends(['longMoodFromMinutes'=>Request::get("longMoodFromMinutes")])
                ->appends(['longMoodToHour'=>Request::get("longMoodToHour")])
                ->appends(['longMoodToMinutes'=>Request::get("longMoodToMinutes")])
                ->appends(["actions" => Request::get("actions")])
                ->appends(["actionsNumberFrom" => Request::get("actionsNumberFrom")])
                ->appends(["actionsNumberTo" => Request::get("actionsNumberTo")])
                ->appends(["descriptions" => Request::get("descriptions")])
                ->appends(['epizodesFrom'=>Request::get("epizodesFrom")])
                ->appends(['epizodesTo'=>Request::get("epizodesTo")])
                ->appends(['valueAllDay'=>Request::get("valueAllDay")])
                ->appends(['ifDescriptions'=>Request::get("ifDescriptions")])
                ->appends(['ifactions'=>Request::get("ifactions")])
                ->appends(['sumMoods'=>Request::get("sumMoods")])
                ->links();
                @endphp
                {{$list}}
     
            </td>
        </tr>
    </table>
</div>

@endsection