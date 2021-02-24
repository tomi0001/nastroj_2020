

<div class="center" style="width: 100%;">
    <table class="display  cell-border compact stripe row-border" id="tblSort">
      @if ($day == "on")
      <thead>
            <tr>
      
            <th style="width: 18%;">
                Data <br>{{$hour}}
            </th>
            <th style="width: 12%;">
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
      <tr>
            <td>
                Dla tego czasu
                {{$dateFrom}} <br> {{$dateTo}}
            </td>
            <td>
                {{$list[0]}}
            </td>
            <td>
                {{$list[1]}}
            </td>
            <td>
                {{$list[8]}} / {{$list[9]}}
            </td>
            <td>
                {{$list[2]}}
            </td>
            <td>
                {{$list[3]}}
            </td>
            <td>
                {{$list[4]}}
            </td>
            <td>
                {{$list[5]}}
            </td>
            <td>
                {{$list[6]}}
            </td>
            <td>
                {{$list[7]}}
            </td>
        </tr>
      
      </tbody>
      
      @else
      <thead>
      
      <tr>
            <th style="width:17%; text-align: center;">
                <br><span style="font-size: 13px;font-weight: bold;">{{$hour}}</span>
            </th>
             @if ($allWeek != "on")
                <th>
                    Dzień tygodnia
                </th>
            @endif
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
      @endif
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