<div id='addPlaned' style='display: none;'>

      <form method="get" id='addPlanedAction'>
                <table class="table center">
                    <tr>
                        <td rowspan="2">
                            Nazwa 
                        </td>
                        <td>
                            <input type="text" name="name" class="form-control">
                        </td>
                        
                    </tr>
                    <tr >
                    
                        <td>
                             <select name="planedName" class="form-control" >
                                <option value='' selected></option>
                                @foreach ($listPlaned as $list)
                                    <option value="{{$list->id}}" >{{$list->name}}</option>

                                @endforeach
                            </select>
                            
                        </td>
                        
                    </tr>




                     <tr>
                        <td>
                            Wybierz produkt
                        </td>
                        <td>
                            <select name="productsName" class="form-control" >
                                
                                @foreach ($listProduct as $list)
                                    <option value="{{$list->id}}" >{{$list->name}}</option>

                                @endforeach
                            </select>
                        </td>
                        
                    </tr>
                    <tr>
                        <td>
                            dawka 
                        </td>
                        <td>
                            <input type="text" name="dose" class="form-control">
                        </td>
                        
                    </tr>
                    <tr>

                        <td colspan="2" class="center">
                            <input type="button" class="btn btn-success btn-lg" onclick="addPlaned('{{route('setting.addPlaned')}}')" value="Dodaj plan">
                        </td>
                        
                    </tr>
                </table>
                <div id="ajax_add_planed" class='ajax'>
                    
                </div>
                
                
      </form>
    <form method="get" id='loadPlanedAction' action="{{ route('setting.updatePlaned') }}" >
        <table class="table center">

                        <tr>
                            <td>
                                Wybierz Zaplanową dawkę
                            </td>                    
                            <td>
                                 <select name="planedName" class="form-control" onchange="loadPlaned('{{ route('setting.loadPlaned')}}')">
                                    <option value='' selected></option>
                                    @foreach ($listPlaned as $list)
                                    <option value="{{$list->name}}" >{{$list->name}}</option>

                                    @endforeach
                                </select>

                            </td>

                        </tr>





        </table>
        <div id='Planed'></div>
    </form> 
</div>