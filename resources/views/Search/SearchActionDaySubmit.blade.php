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
                Data 
                
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
                    <tr>
                        @foreach (App\Http\Services\Common::sumMoods($list[$i]->dat,$id) as $day)
                    <tr>
                        <th>
                            Poziom nastroju dla całego dnia
                        </th>
                        <th>
                            Poziom lęku dla całego dnia
                        </th>
                        <th>
                            Poziom napięcia dla całego dnia
                        </th>
                        <th>
                            Poziom pobudzenia dla całego dnia
                        </th>
                    </tr>
                        <td class="center">
                            {{round($day["average_mood"],2)}} 
                        </td>
                        <td class="center">
                            {{round($day["average_anxiety"],2)}} 
                        </td>
                        <td class="center">
                            {{round($day["average_nervousness"],2)}} 
                        </td>
                        <td class="center">
                            {{round($day["average_stimulation"],2)}} 
                        </td>
                        @endforeach
                    </tr>
                </table>
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

                                    <div class='namePleasure level_pleasure_{{\App\Http\Services\Action::setColorPleasure(\App\Action::selectNameAction2($list[$i]->id_actions,$id)->level_pleasure)}}'>
             
                                         <span class="level_pleasure"> {{$list[$i]->name}}</span> <br>

                                    </div>

                    </td>

                    
                       
                    
                  </tr>

                     <tr>

                        

                        <td>
                            <br>
             
                           <a href='{{route('main')}}/{{$list[$i]->year}}/{{$list[$i]->month}}/{{$list[$i]->day}}'><button class='btn btn-primary btn-lg'>Idź do dnia</button></a>

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
                ->appends(['dateFrom'=>Request::get("dateFrom")])
                ->appends(['dateTo'=>Request::get("dateTo")])
                ->appends(["actions" => Request::get("actions")])
                ->links();
                @endphp
                {{$list}}
     
            </td>
        </tr>
    </table>
</div>

@endsection