<div class='row'>
    <div class='col-md-1 col-lg-2 col-sm-1 col-xs-1'>
        
    </div>
    <div class='col-md-10 col-lg-8 col-sm-10 col-xs-10 '>
        <div class='formAddMood'>
            <div class='title'>
                DODAJ NOWY NASTRÓJ
            </div>
            <div class='row'>
                <div class='col-lg-2 col-md-1 col-xs-1 col-sm-1'>
                </div>    
                <div class='col-lg-8 col-md-10 col-xs-10 col-sm-10'>
                    <form method='get' id="form2">
                        <table class='table table-bordered'>
                            <tr>
                                <td rowspan='2' style='padding-top: 35px; ' class='value'>
                                    Godzina zaczęcia
                                </td>
                                <td class='borderless'>
                                    <input type='date' name='dateStart' class='form-control' value='{{ date("Y-m-d")}}'>
                                </td>
                            </tr>
                            <tr>
                                <td class='borderless'>
                                     <input type='time' name='timeStart' class='form-control'>
                                </td>
                            </tr>
                            <tr>
                                <td rowspan='2' style='padding-top: 35px; ' class='value'>
                                    Godzina zakończenia
                                </td>
                                <td>
                                    <input type='date' name='dateEnd' class='form-control' value='{{ date("Y-m-d")}}'>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type='time' name='timeEnd' class='form-control' >
                                </td>
                            </tr>
                            <tr>
                                <td class='value'>
                                    Poziom nastroju
                                </td>
                                <td>
                                    <input type='text' name='moodLevel' class='form-control'  onkeypress="return runScript(event,'{{ route('Mood.Add')}}')">
                                </td>
                            </tr>
                            <tr>
                                <td class='value'>
                                    Poziom lęku
                                </td>
                                <td>
                                    <input type='text' name='anxietyLevel' class='form-control' onkeypress="return runScript(event,'{{ route('Mood.Add')}}')">
                                </td>
                            </tr>
                            <tr>
                                <td class='value'>
                                    Poziom napięcia
                                </td>
                                <td>
                                    <input type='text' name='voltageLevel' class='form-control' onkeypress="return runScript(event,'{{ route('Mood.Add')}}')">
                                </td>
                            </tr>
                            <tr>
                                <td class='value'>
                                    Poziom pobudzenia
                                </td>
                                <td>
                                    <input type='text' name='stimulationLevel' class='form-control' onkeypress="return runScript(event,'{{ route('Mood.Add')}}')">
                                </td>
                            </tr>
                            <tr>
                                <td class='value'>
                                    Ilośc epizodów psychotycznych
                                </td>
                                <td>
                                    <input type='number' name='epizodesPsychotic' class='form-control' value='0' min='0' onkeypress="return runScript(event,'{{ route('Mood.Add')}}')">
                                </td>
                            </tr>
                             <tr>
                                <td class='value'  style='padding-top: 30%; ' rowspan="2">
                                    Co robiłem
                                </td>
                                <td>
                                    <textarea name='whatWork' class='form-control' rows='7'></textarea>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div  style="overflow-y: scroll;  height:250;">
                                        <div id="parentsAction">
                                            @foreach ($Action as $list)
                                                <a class="Action___" id = "{{$list->id}}">{{$list->name}}</a> |
                                            @endforeach
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" class="center">
                                    <input type="button" onclick="addMood('{{ route('Mood.Add')}}')" class="btn btn-success" value="Dodaj nastrój" >
                                </td>
                            </tr>    
                            <tr>
                                <td colspan="2" class="center">
                                    <div class="ajax" id="form"></div>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
            
        </div>
    </div>
    <div class='col-md-1 col-lg-2'>
        
    </div>
</div>