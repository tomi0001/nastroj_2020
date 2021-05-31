

<div class="center" style="width: 100%;">
    <table class="display  cell-border compact stripe row-border" id="tblSort">
 
      
      <thead>
      
      <tr>
            <th style="width:17%; text-align: center;">
                <br><span style="font-size: 13px;font-weight: bold;">{{$hour}}</span>
            </th>

                <th>
                    Dzień tygodnia
                </th>

            <th>
                Poziom nastroju
            </th>
            <th>
                odchylenie nastroju
                
            </th>
            <th>
                różnica nastroju (min/max)
                
            </th>
            <th>
                Poziom lęku
            </th>
            <th>
                odchylenie lęku
                
            </th>
            <th>
                Poziom zdenerowania
            </th>
            <th>
                odchylenie zdenerowania
                
            </th>
            <th>
                Poziom pobudzenia
            </th>
            <th>
                odchylenie pobudzenia
                
            </th>
      </tr>
       </thead>
       <tbody>
     
        @for ($i=0;$i < count($days);$i++)
        <tr>
            <td>
                {{$days[$i]}} 
            </td>
            @if ($allWeek != "on")
                <td>
                    {{\App\Http\Services\Common::returnDayWeek($days[$i])}}
                </td>
            @endif
            <td>
                {{round($list[0][$i],2)}}
            </td>
            <td>
                {{$harmonyMood[$i]}}
                
            </td>
            <td>
                {{$list[4][$i]}} / {{$list[5][$i]}}
                
            </td>
            <td>
                {{round($list[1][$i],2)}}
            </td>
            <td>
                {{$harmonyAnxiety[$i]}}
                
            </td>
            
            <td>
                {{round($list[2][$i],2)}}
            </td>
            <td>
                {{$harmonyNer[$i]}}
                
            </td>
            
            <td>
                {{round($list[3][$i],2)}}
            </td>
            <td>
                {{$harmonyStimu[$i]}}
                
            </td>
        </tr>
        
        @endfor
        </tbody>

    </table>
</div>
<script>
$(document).ready( function () {
    
    $('#tblSort').DataTable({
        columnDefs: [
    {
        targets: -1,
        className: 'dt-body-right'
    }
  ],
        "bPaginate": false,

    });
} );
</script>