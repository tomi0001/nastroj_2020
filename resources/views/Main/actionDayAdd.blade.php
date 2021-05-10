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
                    <form method='get' id="form20">
                        <table class='table table-bordered'>
                            <tr>
                                <td style='padding-top: 35px; ' class='value'>
                                    Dzień
                                </td>
                                <td class='borderless'>
                                    <input type='date' name='date' class='form-control' value='{{ date("Y-m-d")}}'>
                                </td>
                            </tr>
                            
                            <tr>
                                <td style='padding-top: 35px; ' class='value'>
                                    Nazwa akcji
                                </td>
                                <td class='borderless'>
                                    <select name="nameAction" class="form-control">
                                        <option value=""></option>
                                            @foreach ($Action as $listActionDay)
                                                <option value="{{$listActionDay->id}}">{{$listActionDay->name}}</option>
                                            @endforeach
                                        
                                        
                                    
                                    </select>
                                </td>
                            </tr>
                            
                            <tr>
                                <td colspan="2" class="center">
                                    <input type="button" onclick="addActionDay('{{ route('ActionDay.Add')}}')" class="btn btn-success btn-lg" value="Dodaj akcje" >
                                </td>
                            </tr>    
                            <tr>
                                <td colspan="2" class="center">
                                    <div class="ajax" id="form21"></div>
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