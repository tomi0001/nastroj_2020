@extends('Layout.Main')

@section('content')
<body onload='hideDiv({{count($list)}})'>
<br>

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
                    <tr>
            <td colspan="6">
                <br>
                
                <br>
           
                <table class="table">
                @foreach (\App\Moods_action::ifExistActionForSumMood($dateFrom,$dateTo,$id) as $action)
                    
                    <tr>
                        @if (\App\Action::selectNameAction($action->action,$id) != null)
                            <td>{{\App\Action::selectNameAction($action->action,$id)->name}} </td><td> {{\App\Http\Services\Common::sumHour($action->minute)}} średnio  {{\App\Http\Services\Common::sumHour(round($action->minute / $howDay))}} na dzień </td>
                            
                        @endif
                        
                    </tr>
                   
                @endforeach
                </table>

            </td>
        </tr>
        @if ($i == 0 or ($list[$i]->dat != $list[$i-1]->dat ))

        

            
        @endif
        
        <tr class="search">
            <td colspan="6">
              <table width="100%" border="0">
            
                    <tr>
                        <td class="center" width="150px">

                        {{$dateFrom}}

                    </td>
                    <td class="center"  width="16%" width="150px">
                        {{$dateTo}}

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
                     
                    
                    
        </table>
           </td> 
           
        </tr>
        
        
        @endfor

        
    </table>
</div>

@endsection