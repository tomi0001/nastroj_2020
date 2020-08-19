<div id='mainSearch' style='display: inline;'>
        <form method='get' action="{{ route("search.mainAction")}}">
            <table class='table width'>
                <TR>
                    <td width='21%'>
                        Poziom nastroju
                    </td>
                    <td width="13%">
                        <input type='text' name='moodFrom' class='form-control' onkeypress="return runScriptSettingAddAction(event,'{{ route('Setting.ActionAdd')}}')">
                    </td>
                    <td width="5%">
                        Do
                    </td>
                    <td width="13%" colspan="2">
                         <input type='text' name='moodTo' class='form-control' onkeypress="return runScriptSettingAddAction(event,'{{ route('Setting.ActionAdd')}}')">
                    </td>
                </TR>
                <TR>
                    <td>
                        Poziom lęku
                    </td>
                    <td>
                        <input type='text' name='anxietyFrom' class='form-control' onkeypress="return runScriptSettingAddAction(event,'{{ route('Setting.ActionAdd')}}')">
                    </td>
                    <td width="5%">
                        Do
                    </td>
                    <td width="13%" colspan="2">
                         <input type='text' name='anxietyTo' class='form-control' onkeypress="return runScriptSettingAddAction(event,'{{ route('Setting.ActionAdd')}}')">
                    </td>
                </TR>
                <TR>
                    <td>
                        Poziom napięcia
                    </td>
                    <td>
                        <input type='text' name='voltageFrom' class='form-control' onkeypress="return runScriptSettingAddAction(event,'{{ route('Setting.ActionAdd')}}')">
                    </td>
                    <td width="5%">
                        Do
                    </td>
                    <td width="13%" colspan="2">
                         <input type='text' name='voltageTo' class='form-control' onkeypress="return runScriptSettingAddAction(event,'{{ route('Setting.ActionAdd')}}')">
                    </td>
                </TR>
                <TR>
                    <td>
                        Poziom pobudzenia
                    </td>
                    <td>
                        <input type='text' name='stimulationFrom' class='form-control' onkeypress="return runScriptSettingAddAction(event,'{{ route('Setting.ActionAdd')}}')">
                    </td>
                    <td width="5%">
                        Do
                    </td>
                    <td width="13%" colspan="2">
                         <input type='text' name='stimulationTo' class='form-control' onkeypress="return runScriptSettingAddAction(event,'{{ route('Setting.ActionAdd')}}')">
                    </td>
                </TR>
                <TR>
                    <td>
                        Wartość dla jednego dnia
                    </td>
                    <td>
                        <input type='checkbox' name='valueAllDay' class='form-control'>
                    </td>
                    <td colspan="3">
                        
                    </td>
                </TR>
                <TR>
                    <td >
                       Długośc nastroju od
                    </td>
                    <td>
                        <input type='text' name='longMoodFromHour' class='form-control' onkeypress="return runScriptSettingAddAction(event,'{{ route('Setting.ActionAdd')}}')" placeholder="Godziny">
                    </td>
                    <td width="5%">
                       
                    </td>
                    <td colspan="2">
                        <input type='text' name='longMoodToHour' class='form-control' onkeypress="return runScriptSettingAddAction(event,'{{ route('Setting.ActionAdd')}}')" placeholder="Minuty">
                    </td>
                </TR>
                <TR>
                    <td>
                        Długośc nastroju do
                    </td>
                    <td>
                        <input type='text' name='longMoodFromMinutes' class='form-control' onkeypress="return runScriptSettingAddAction(event,'{{ route('Setting.ActionAdd')}}')" placeholder="Godziny">
                    </td>
                    <td width="5%">
                        
                    </td>
                    <td colspan="2">
                        <input type='text' name='longMoodToMinutes' class='form-control' onkeypress="return runScriptSettingAddAction(event,'{{ route('Setting.ActionAdd')}}')" placeholder="Minuty">
                    </td>
                </TR>
                <tr>
                    <td>
                        DATA od
                    </td>
                    <td>
                        <input type="date" name="dateFrom" class="form-control">
                    </td>
                    <td>
                        Do
                    </td>
                    <td colspan="2">
                        <input type="date" name="dateTo" class="form-control">
                    </td>
                </tr>
                <TR>
                <tr>
                    <td>
                        Godzina od
                    </td>
                    <td>
                        <input type="time" name="timeFrom" class="form-control">
                    </td>
                    <td>
                        Do
                    </td>
                    <td colspan="2">
                        <input type="time" name="timeTo" class="form-control">
                    </td>
                </tr>
                
                
                <tr>
                    <td>
                        Słowa kluczowe co robiłem
                    </td>
                    <td colspan="3">
                        <div id="what_work">
                            <input type="text" name="descriptions[]" class="form-control">
                        </div>
                    </td>
                    <td width="5%">
                        <a class="btn btn-info btn-lg" onclick="addWorld()">
                            <span class="glyphicon glyphicon-plus"></span>
                        </a>
                    </td>
                    
                </tr>
                <tr>
                    <td>
                        Słowa kluczowe akcji
                    </td>
                    <td colspan="3">
                        <div id="actionSearch">
                            <input type="text" name="actions[]" class="form-control">
                        </div>
                    </td>
                    <td width="5%">
                        <a class="btn btn-info btn-lg" onclick="addActionSearch()">
                            <span class="glyphicon glyphicon-plus"></span>
                        </a>
                    </td>
                    
                </tr>                
                <tr>
                    <td>
                        Wyszukja tylko wpisy, które mają jakiś opis
                    </td>

                    <td width="5%">
                        <input type="checkbox" name="ifDescriptions" class="form-control">
                    </td>
                    <td colspan="3">
                    </td>
                </tr>
                <tr>
                    <td>
                        Wyszukja tylko wpisy, które mają jakiś akcje
                    </td>

                    <td width="5%">
                        <input type="checkbox" name="ifactions" class="form-control">
                    </td>
                    <td colspan="3">
                    </td>
                </tr>
                <tr>
                    <td>
                        Sortuj wg
                    </td>
                    
                    <td colspan="3"> 
                        <select name="sort" class="form-control">
                            <option value="date">Daty</option>
                            <option value="hour">Godziny</option>
                            <option value="mood">Nastroju</option>
                            <option value="anxiety">Lęku</option>
                            <option value="voltage">Napięcia</option>
                            <option value="stimulation">Pobudzenia</option>
                            <option value="longMood">Długości trwania nastroju</option>
                        </select>
                    </td>
                    <td colspan="3">
                    </td>
                </tr>
                
                
                <TR> 
                    <td colspan='2' class='center'>
                        <input type='submit'  class='btn btn-primary' value='Dodaj Akcje'>
                    </td>
                    
                </TR>
                <TR>
                 
                    <td colspan='2' class='center' id="form">
                     
                    </td>
                    
                </TR>
            </table>
        </form>
    </div>
    