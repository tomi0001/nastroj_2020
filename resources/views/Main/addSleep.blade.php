<div class='row'>
    <div class='col-md-1 col-lg-2 col-sm-1 col-xs-1'>
        
    </div>
    <div class='col-md-10 col-lg-8 col-sm-10 col-xs-10 '>
        <div class='formAddMood'>
            <div class='title'>
                DODAJ NOWY SEN
            </div>
            <div class='row'>
                <div class='col-lg-2 col-md-1 col-xs-1 col-sm-1'>
                </div>    
                <div class='col-lg-8 col-md-10 col-xs-10 col-sm-10'>
                    <form method='get' id="form6">
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
                                    Ilośc wybudzeń
                                </td>
                                <td>
                                    <input type='number' name='wakeUp' class='form-control' min='0' value="0" onkeypress="return runScriptSleepAdd(event,'{{ route('Sleep.Add')}}')">
                                </td>
                            </tr>
                            
                            <tr>
                                <td colspan="2" class="center">
                                    <input type="button" onclick="addSleep('{{ route('Sleep.Add')}}')" class="btn btn-success btn-lg" value="Dodaj sen" >
                                </td>
                            </tr>    
                            <tr>
                                <td colspan="2" class="center">
                                    <div class="ajax" id="form5"></div>
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