<div class='row'>
    <div class='col-md-1 col-lg-2 col-sm-1 col-xs-1'>
        
    </div>
    <div class='col-md-10 col-lg-8 col-sm-10 col-xs-10 '>
        <div class='formAddMood'>
            <div class='title'>
                DODAJ NOWY ZDARZENIE
            </div>
            <div class='row'>
                <div class='col-lg-2 col-md-1 col-xs-1 col-sm-1'>
                </div>    
                <div class='col-lg-8 col-md-10 col-xs-10 col-sm-10'>
                    <form method='get' id="form4">
                        <table class='table table-bordered'>
                            <tr>
                                <td rowspan='2' style='padding-top: 35px; ' class='value'>
                                    Godzina zaczęcia
                                </td>
                                <td class='borderless'>
                                    <input type='date' name='dateStart' class='form-control' value='{{ $dateAction}}' onkeypress="return runScriptAddActionMood(event,'{{ route('Action.Add')}}')">
                                </td>
                            </tr>
                            <tr>
                                <td class='borderless'>
                                     <input type='time' name='timeStart' class='form-control' onkeypress="return runScriptAddActionMood(event,'{{ route('Action.Add')}}')">
                                </td>
                            </tr>
                            <tr>
                                <td rowspan='2' style='padding-top: 35px; ' class='value'>
                                    Godzina zakończenia
                                </td>
                                <td>
                                    <input type='date' name='dateEnd' class='form-control' value='{{ $dateAction}}' onkeypress="return runScriptAddActionMood(event,'{{ route('Action.Add')}}')">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type='time' name='timeEnd' class='form-control' onkeypress="return runScriptAddActionMood(event,'{{ route('Action.Add')}}')" >
                                </td>
                            </tr>
                            <tr>
                                <td class='value'>
                                    Czas trwania (w minutach)
                                </td>
                                <td>
                                    <input type='number' name='long' class='form-control' min='1' onkeypress="return runScriptAddActionMood(event,'{{ route('Action.Add')}}')">
                                </td>
                            </tr>
                             <tr>
                                <td class='value'  style='padding-top: 20%; ' rowspan="2">
                                    Co zamierzam robić
                                </td>
                               
                            </tr>
                            <tr>
                                <td>
                                    <div  style="overflow-y: scroll;  height:250;">
                                        <div id="parentsAction">
                                            @foreach ($Action as $list)
                                                <a class="Action___2" id = "{{$list->id}}">{{$list->name}}</a> |
                                            @endforeach
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" class="center">
                                    <input type="button" onclick="addAction('{{ route('Action.Add')}}')" class="btn btn-success" value="Dodaj zdarzenie" >
                                </td>
                            </tr>    
                            <tr>
                                <td colspan="2" class="center">
                                    <div class="ajax" id="form3"></div>
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