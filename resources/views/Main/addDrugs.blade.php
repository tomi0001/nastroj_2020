<div class='row'>
    <div class='col-md-1 col-lg-2 col-sm-1 col-xs-1'>
        
    </div>
    <div class='col-md-10 col-lg-8 col-sm-10 col-xs-10 '>
        <div class='formAddMood'>
            <div class='titleDrugs'>
                DODAJ NOWY LEK
            </div>
            <div class='row'>
                <div class='col-lg-2 col-md-1 col-xs-1 col-sm-1'>
                </div>    
                <div class='col-lg-8 col-md-10 col-xs-10 col-sm-10'>
                    <form method='get' id="form8">
                        <table class='table table-bordered'>
                            <tr>
                                <td  style='padding-top: 15px; ' class='value'>
                                    Nazwa produktu
                                </td>
                                <td class='borderless'>
                                    <select name="name" class="form-control"  onchange="loadPortion('{{ route('Drugs.loadTypePortion')}}')">
                                        <option value=""></option>
                                        @foreach ($listProduct as $list)
                                        <option value="{{$list->id}}">{{$list->name}}</option>
                                            
                                            
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                           
                            <tr>
                                <td rowspan='2' style='padding-top: 35px; ' class='value'>
                                    Godzina wzięcia
                                </td>
                                <td class='borderless'>
                                    <input type='date' name='date' class='form-control' >
                                </td>
                            </tr>
                            <tr>
                                <td class='borderless'>
                                     <input type='time' name='time' class='form-control'>
                                </td>
                            </tr>

                            <tr>
                                <td class='value'>
                                    dawka
                                </td>
                                <td>
                                    <div style="float: left;">
                                    <input type='text' name='dose' class='form-control'  onkeypress="return runScript(event,'{{ route('Mood.Add')}}')">
                                    </div>
                                    <div style="width: 30px; float: left;">&nbsp;</div>
                                    <div id="typePortion"></div>
                                </td>
                            </tr>
                            
                             <tr>
                                <td class='value'>
                                    Opis spożycia
                                </td>
                                <td>
                                    <textarea name='description' class='form-control' rows='7'></textarea>
                                </td>
                            </tr>
                            
                            <tr>
                                <td colspan="2" class="center">
                                    <input type="button" onclick="addDrugs('{{ route('Drugs.Add')}}')" class="btn btn-success btn-lg" value="Dodaj lek" >
                                </td>
                            </tr>    
                            <tr>
                                <td colspan="2" class="center">
                                    <div class="ajax" id="form7"></div>
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