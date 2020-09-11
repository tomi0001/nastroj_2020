<div id='SearchSleep' style='display: none;'>
        <form method='get' action="{{ route("search.sleepAction")}}">
            <table class='table width'>
                
                <TR>
                    <td >
                       Długośc snu od
                    </td>
                    <td width="15%">
                        <input type='number' name='longSleepFromHour' class='form-control'  placeholder="Godziny" value="{{Request::old("longSleepFromHour")}}" min="0" max="23">
                    </td>
                    <td width="5%">
                       
                    </td>
                    <td colspan="2">
                        <input type='number' name='longSleepFromMinutes' class='form-control' placeholder="Minuty" value="{{Request::old("longSleepFromMinutes")}}" min="0" max="59">
                    </td>
                </TR>
                <TR>
                    <td>
                        Długośc snu do
                    </td>
                    <td>
                        <input type='number' name='longSleepToHour' class='form-control'  placeholder="Godziny" value="{{Request::old("longSleepToHour")}}" min="0" max="23">
                    </td>
                    <td width="5%">
                        
                    </td>
                    <td colspan="2">
                        <input type='number' name='longSleepToMinutes' class='form-control'  placeholder="Minuty" value="{{Request::old("longSleepToMinutes")}}" min="0" max="59">
                    </td>
                </TR>
                <tr>
                    <td>
                        DATA od
                    </td>
                    <td>
                        <input type="date" name="dateFrom" class="form-control" value="{{Request::old("dateFrom")}}">
                    </td>
                    <td>
                        Do
                    </td>
                    <td colspan="2">
                        <input type="date" name="dateTo" class="form-control" value="{{Request::old("dateTo")}}">
                    </td>
                </tr>
                <TR>
                <tr>
                    <td>
                        Godzina od
                    </td>
                    <td>
                        <input type="time" name="timeFrom" class="form-control" value="{{Request::old("timeFrom")}}">
                    </td>
                    <td>
                        Do
                    </td>
                    <td colspan="2">
                        <input type="time" name="timeTo" class="form-control" value="{{Request::old("timeTo")}}">
                    </td>
                </tr>
                
                
    
                <tr>
                    <td>
                        Ilość wybudzeń od
                    </td>
                    <td colspan="1">
                        
                            <input type="number" name="wakeUpFrom" class="form-control" value="{{Request::old("wakeUpFrom")}}" min="0">
                        
                    </td>
                    <td>
                        Do
                    </td>
                    <td width="5%" colspan="2">
                          <input type="number" name="wakeUpTo" class="form-control" value="{{Request::old("wakeUpTo")}}" min="0">
                    </td>
                    
                </tr>   
                
                <tr>
                    <td>
                        Sortuj wg
                    </td>
                    
                    <td colspan="4"> 
                        <select name="sort" class="form-control">
                            <option value="date">Daty</option>
                            <option value="hour">Godziny</option>
                            <option value="longMood">Długości trwania snu</option>
                        </select>
                    </td>
                    <td colspan="3">
                    </td>
                </tr>
                
                
                <TR> 
                    <td colspan='5' class='center'>
                        <input type='submit'  class='btn btn-primary btn-lg' value='Wyszukaj'>
                    </td>
                    
                </TR>
      
            </table>
        </form>
    </div>
    