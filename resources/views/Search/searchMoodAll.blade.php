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
                            <td>{{\App\Action::selectNameAction($action->action,$id)->name}} </td><td> {{\App\Http\Services\Common::sumHour($action->percent)}} średnio  {{\App\Http\Services\Common::sumHour(round($action->percent / $howDay))}} na dzień </td>
                            
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

                            {{$list[$i]->nas}}
                 


                        </td>
                        <td class="center"  width="16%" width="150px">

  
                            {{$list[$i]->nas2}}
                      
                        </td>
                        <td class="center"  width="16%" width="150px">
     
                            {{$list[$i]->nas3}}
                           


                        </td>
                        <td class="center"  width="16%" width="150px">
          
                            {{$list[$i]->nas4}}
                           


                        </td>
              
                    
                  </tr>
                     <tr>
                        <td colspan="6">
                            <br>
                         
                            
                            
                            
                            <div class="titlemood{{\App\Http\Services\Common::setColor($list[$i]->nas)}}" style='width: {{$percent[$i]["percent"]}}%';>&nbsp;</div>

                   
                         
                        </td>
                    </tr>
                     
                    
                    
        </table>
           </td> 
           
        </tr>
        
        
        @endfor

        
    </table>
</div>

@endsection