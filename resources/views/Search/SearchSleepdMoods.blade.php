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
                         
                            <div class="titlemood{{\App\Http\Services\Common::setColor($list[$i]->nas)}}" >&nbsp;</div>
                           
                  
                   
                         
                        </td>
                    </tr>
                     
                    
                    
        </table>
           </td> 
           
        </tr>
        
        
        @endfor

        
    </table>
</div>

@endsection