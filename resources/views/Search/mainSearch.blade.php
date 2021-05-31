<div id='mainSearch' style='display: inline;'>
        <form method='get' action="{{ route("search.mainAction")}}">
            <table class='table width'>
                <TR>
                    <td width='21%'>
                        Poziom nastroju
                    </td>
                    <td width="13%">
                        <input type='text' name='moodFrom' class='form-control'  value="{{Request::old("moodFrom")}}">
                    </td>
                    <td width="5%">
                        Do
                    </td>
                    <td width="13%" colspan="2">
                         <input type='text' name='moodTo' class='form-control' value="{{Request::old("moodTo")}}">
                    </td>
                </TR>
                <TR>
                    <td>
                        Poziom lęku
                    </td>
                    <td>
                        <input type='text' name='anxietyFrom' class='form-control'  value="{{Request::old("anxietyFrom")}}">
                    </td>
                    <td width="5%">
                        Do
                    </td>
                    <td width="13%" colspan="2">
                         <input type='text' name='anxietyTo' class='form-control'  value="{{Request::old("anxietyTo")}}">
                    </td>
                </TR>
                <TR>
                    <td>
                        Poziom napięcia
                    </td>
                    <td>
                        <input type='text' name='voltageFrom' class='form-control' value="{{Request::old("voltageFrom")}}">
                    </td>
                    <td width="5%">
                        Do
                    </td>
                    <td width="13%" colspan="2">
                         <input type='text' name='voltageTo' class='form-control'  value="{{Request::old("voltageTo")}}">
                    </td>
                </TR>
                <TR>
                    <td>
                        Poziom pobudzenia
                    </td>
                    <td>
                        <input type='text' name='stimulationFrom' class='form-control'  value="{{Request::old("stimulationFrom")}}">
                    </td>
                    <td width="5%">
                        Do
                    </td>
                    <td width="13%" colspan="2">
                         <input type='text' name='stimulationTo' class='form-control'  value="{{Request::old("stimulationTo")}}">
                    </td>
                </TR>
                <TR>
                    <td>
                        Wartość dla jednego dnia
                    </td>
                    <td>
                        @if (Request::old("valueAllDay") == "on")
                            <input type='checkbox' name='valueAllDay' class='form-control'  checked>
                        @else
                                 <input type='checkbox' name='valueAllDay' class='form-control' >
                        @endif
                    </td>
                    <td colspan="3">

                    </td>
                </TR>
                <TR>
                    <td >
                       Długośc nastroju od
                    </td>
                    <td>
                        <input type='number' name='longMoodFromHour' class='form-control'  placeholder="Godziny" value="{{Request::old("longMoodFromHour")}}" min="0" max="23">
                    </td>
                    <td width="5%">

                    </td>
                    <td colspan="2">
                        <input type='number' name='longMoodFromMinutes' class='form-control' placeholder="Minuty" value="{{Request::old("longMoodToHour")}}" min="0" max="59">
                    </td>
                </TR>
                <TR>
                    <td>
                        Długośc nastroju do
                    </td>
                    <td>
                        <input type='number' name='longMoodToHour' class='form-control'  placeholder="Godziny" value="{{Request::old("longMoodFromMinutes")}}" min="0" max="23">
                    </td>
                    <td width="5%">

                    </td>
                    <td colspan="2">
                        <input type='number' name='longMoodToMinutes' class='form-control'  placeholder="Minuty" value="{{Request::old("longMoodToMinutes")}}" min="0" max="59">
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
                        Słowa kluczowe co robiłem
                    </td>
                    <td colspan="3">
                        <div id="what_work">
                            <input type="text" name="descriptions[]" class="form-control" >
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
                        <div id="actionSearch" >
                            <div style='float: left; width: 40%;'>
                                <input type="text" name="actions[]" class="form-control" placeholder="nazwa">
                            </div>
                            <div style='float: left; width: 29%; padding-left: 20px;' >
                                <input type="text" name="actionsNumberFrom[]" class="form-control" placeholder="wartość od">
                            </div>
                            <div style='float: right; width: 25%;' >
                                <input type="text" name="actionsNumberTo[]" class="form-control" placeholder="wartość do">
                            </div>
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
                        Ilość epizodów psychotycznych od
                    </td>
                    <td colspan="1">

                            <input type="number" name="epizodesFrom" class="form-control" value="{{Request::old("epizodesFrom")}}" min="0">

                    </td>
                    <td>
                        Do
                    </td>
                    <td width="5%" colspan="2">
                          <input type="number" name="epizodesTo" class="form-control" value="{{Request::old("epizodesTo")}}" min="0">
                    </td>

                </tr>
                <tr>
                    <td>
                        Wyszukja tylko wpisy, które mają jakiś opis
                    </td>

                    <td width="5%">
                         @if (Request::old("ifDescriptions") == "on")
                            <input type="checkbox" name="ifDescriptions" class="form-control" checked>
                         @else
                            <input type="checkbox" name="ifDescriptions" class="form-control" >
                         @endif
                    </td>
                    <td colspan="3">
                    </td>
                </tr>
                <tr>
                    <td>
                        Wyszukaj tylko wpisy, które mają jakiś akcje
                    </td>

                    <td width="5%">
                        @if (Request::old("ifactions") == "on")
                            <input type="checkbox" name="ifactions" class="form-control" checked>
                        @else
                            <input type="checkbox" name="ifactions" class="form-control">
                        @endif
                    </td>
                    <td colspan="3">
                    </td>
                </tr>
                <tr>
                    <td>
                        Sumuj wszystkie nastroje
                    </td>

                    <td width="5%">
                        @if (Request::old("sumMoods") == "on")
                            <input type="checkbox" name="sumMoods" class="form-control" checked>
                        @else
                            <input type="checkbox" name="sumMoods" class="form-control">
                        @endif
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
                    <td colspan='5' class='center'>
                        <input type='submit'  class='btn btn-primary btn-lg' value='Wyszukaj'>
                    </td>

                </TR>

            </table>
        </form>
    </div>
