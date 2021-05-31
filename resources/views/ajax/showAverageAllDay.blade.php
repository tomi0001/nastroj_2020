

<div class="center" style="width: 100%;">
    <table class="display  cell-border compact stripe row-border" id="tblSort">
   
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