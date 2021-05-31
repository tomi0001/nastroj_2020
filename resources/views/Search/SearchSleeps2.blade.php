@extends('Layout.Main')

@section('content')
<body onload='hideDiv({{count($list)}})'>
<br>
<div class="searchaction">
    <table class="table">
        <thead class="thead-dark titleThead">
        <tr>
            <th class="center" width="250px">
                Data zaczęcia
                
            </th>
            <th class="center" width="250px">
                Data skończenia
                
            </th>
            <th class="center"  colspan="3">
            
                
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
           
        

            </td>
        </tr>
            
        @endif
        
        <tr class="search">
            <td colspan="6">
              <table width="100%" border="0">
            
                    <tr>
                        <td class="center" width="300px">

                        {{$list[$i]->date_start}}

                    </td>
                    <td class="center"  width="16%" width="300px">
                        {{$list[$i]->date_end}}

                    </td>
                    

                        
                    
      

              
                    
                  </tr>
                     <tr>
                        <td colspan="6">
                            <br>
                         
                            <div class="titleSleep2" style='width: {{$percent[$i]["percent"]}}%';>&nbsp;</div>
            
                   
                         
                        </td>
                    </tr>
                     <tr>
                        <td>
                            <br>
                            {{$percent[$i]['second']}}
                        </td>
                        
                        
                        
                        <td>
                            <br>
             
                           <a href='{{route('main')}}/{{$list[$i]->year}}/{{$list[$i]->month}}/{{$list[$i]->day}}#id_{{$list[$i]->id}}'><button class='btn btn-primary btn-lg'>Idź do dnia</button></a>

                        </td>
                      @if ($list[$i]["how_wake_up"] != null )
                        
                        <td   class="centerbold boldWarning"  colspan="3" width="100px">
                            <br>
                              Ilość wybudzeń {{$list[$i]["how_wake_up"]}}
                        </td>
                    @else
                    <td    colspan="3">
                        
                    </td>
                    @endif
                    <td colspan="2" width="200px">
                        
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
                ->appends(['timeFrom'=>Request::get("timeFrom")])
                ->appends(['timeTo'=>Request::get("timeTo")])
                ->appends(['longSleepFromHour'=>Request::get("longSleepFromHour")])
                ->appends(['longSleepFromMinutes'=>Request::get("longSleepFromMinutes")])
                ->appends(['longSleepToHour'=>Request::get("longSleepToHour")])
                ->appends(['longSleepToMinutes'=>Request::get("longSleepToMinutes")])
                ->appends(['wakeUpFrom'=>Request::get("wakeUpFrom")])
                ->appends(['wakeUpTo'=>Request::get("wakeUpTo")])
                ->links();
                @endphp
                {{$list}}
     
            </td>
        </tr>
    </table>
</div>

@endsection