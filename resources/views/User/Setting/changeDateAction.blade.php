
<div id='changeDateAction' style='display: none;'>
    <table class="table">
        <form method="get" id="form4">
        <tr>
            <td>
                Wybierz akcje
            </td>
            <td colspan="3">
                <select name="actionNameDate" class="form-control" onchange="loadActionDateChange('{{ route("user.changeActionDateName")}}','{{ route("user.deleteActionPlans")}}')">
                    <option value='' selected></option>
                    @foreach ($actionDate as $list)
                        <option value="{{$list->id}}" >{{$list->name}} -  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{$list->created_at}}</option>
                        @php
                            $tmp = $list->id;
                        @endphp
                    @endforeach
                </select>
                
                    <a id='link'><input type="button" id="disabled2"  value="Usuń akcję" class="btn btn-danger"></a>
                
               
            </td>
        <tr>
            <td>
               Zmień akcje
            </td>
            <td colspan="3">
                
                <select name="idAction" id="idAction" class="form-control">
                    
                </select>
                
            </td>
        </tr>
        <tr>
            <td>
              Data zaczęcia
            </td>
            <td>
                
                <input type="date" class="form-control" id="dateStart" name="dateStart">
                
            </td>
            <td class="center">
                Czas zaczęcia
            </td>
            <td>
                <input type="time" class="form-control"  id="timeStart" name="timeStart">
            </td>
        </tr>
        <tr>
            <td>
              Data zakończenia
            </td>
            <td>
                
                <input type="date" class="form-control"  id="dateEnd" name="dateEnd">
                
            </td>
            <td class="center">
                Czas zakończenia
            </td>
            <td>
                <input type="time" class="form-control"  id="timeEnd" name="timeEnd">
            </td>
        </tr>
        <tr>
            <td colspan="1">
              Czas akcji
            </td>
            <td colspan="1">
                
                <input type="number" class="form-control"  id="longer" name="long">
                
            </td>

        </tr>
        <tr>
            <td colspan="1">
              Czy całodniowa
            </td>

            <td colspan="1">
                <input type="checkbox" class="form-control"  id="if_all_day" name="allDay">
            </td>
        </tr>
        <tr>
            <td colspan='4' class='center'>
              
                    <input type="button" id="disabled" onclick="changeNameDateAction('{{ route('user.changeActionDateName2')}}')" value='Zmień datę' class='btn btn-primary'>
                    
                
                
            </td>
        </tr>
        <tr>
            <td colspan='4' class='center'>
                <div id='changeNameDateActionForm2'>
                    
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="4">
                <div id="form3" class="center">
                    
                </div>
            </td>
        </tr>
        </form>
    </table>
</div>

<script>
    window.onload=loadActionDateChange('{{ route("user.changeActionDateName")}}');

    </script>