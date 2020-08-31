@extends('Layout.Main')

@section('content')
<body onload='hideDiv({{count($list)}})'>
<br>
<div class="searchaction">
    <table class="table">
        <thead class="thead-dark">
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
             
                           <a href='{{route('main')}}/{{$list[$i]->year}}/{{$list[$i]->month}}/{{$list[$i]->day}}#id_{{$list[$i]->id}}'><button class='btn btn-primary'>Idź do dnia</button></a>

                        </td>
                      @if ($list[$i]["how_wake_up"] != null )
                        
                        <td   class="centerbold boldWarning"  colspan="3" width="100px">
                            <br>
                              Ilość wybudzeń {{$list[$i]["how_wake_up"]}}
                        </td>
                    @else
                    <td    colspan="1">
                        
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
                ->appends(['longMoodFromHour'=>Request::get("longMoodFromHour")])
                ->appends(['longMoodFromMinutes'=>Request::get("longMoodFromMinutes")])
                ->appends(['longMoodToHour'=>Request::get("longMoodToHour")])
                ->appends(['longMoodToMinutes'=>Request::get("longMoodToMinutes")])
                ->links();
                @endphp
                {{$list}}
     
            </td>
        </tr>
    </table>
</div>

@endsection