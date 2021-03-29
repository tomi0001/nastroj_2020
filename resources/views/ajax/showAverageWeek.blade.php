

<div class="center" style="width: 100%;">
    <table class="display  cell-border compact stripe row-border" id="tblSort">
 
      
      <thead>
      
      <tr>
            <th style="width:10%; text-align: center;">
                <br><span style="font-size: 13px;font-weight: bold;">{{$hour}}</span>
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



            <td>
                {{round($list[0][$i],2)}}
            </td>
            <td>
                {{$list[6][$i]}}
                
            </td>
            <td>
                {{$list[4][$i]}} / {{$list[5][$i]}}
                
            </td>
            <td>
                {{round($list[1][$i],2)}}
            </td>
            <td>
                {{$list[7][$i]}}
                
            </td>
            
            <td>
                {{round($list[2][$i],2)}}
            </td>
            <td>
               {{$list[8][$i]}}
                
            </td>
            
            <td>
                {{round($list[3][$i],2)}}
            </td>
            <td>
                {{$list[9][$i]}}
                
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