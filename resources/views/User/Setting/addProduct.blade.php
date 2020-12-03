<div id='addProduct' style='display: none;'>

      <form method="get" id='addProductAction'>
                <table class="table center">
                    <tr>
                        <td>
                            Nazwa produktu
                        </td>
                        <td>
                            <input type="text" name="name" class="form-control">
                        </td>
                        
                    </tr>
                    <tr>
                        <td>
                            Ile ma procent <br> (w przypadku napoju alkholowego)
                        </td>
                        <td>
                                <input type='text' name='percent' class='form-control'>
                        </td>
                        
                    </tr>
                    <tr>
                        <td>
                            Rodzaj porcji
                        </td>
                        <td>
                            <select name="portion" class="form-control form-control-lg">
                                <option value="1" selected>Mg</option>
                                <option value="2">Mililitry</option>
                                <option value="3">ilości</option>
                                
                                
                            </select>
                        </td>
                        
                    </tr>
                    <tr>
                        <td>
                            Cena
                        </td>
                        <td>
                                <input type='text' name='price' class='form-control'>
                        </td>
                        
                    </tr>
                    <tr>
                        <td>
                            Za ile
                        </td>
                        <td>
                                <input type='text' name='how' class='form-control'>
                        </td>
                        
                    </tr>
                     <tr>
                        <td>
                            Substancje, które należą<br> do tego produktu
                        </td>
                        <td>
                            <div style="overflow-y: scroll;  height:150; ">
                                <table width='100%' class='color'>
                                @foreach ($listSubstance as $list)
                                <tr>
                                <td>
                                    <input type='checkbox' name='substance[]' class='form-control' value='{{$list->id}}'>
                                </td>
                                <td>
                                    {{$list->name}}
                                  </td>
                                </tr>
                                @endforeach
         
                                
                                </table>
                                
                            </div>
                        </td>
                        
                    </tr>
                    <tr>

                        <td colspan="2" class="center">
                            <input type="button" class="btn btn-success btn-lg" onclick="addProduct('{{route('setting.addProduct')}}')" value="Dodaj produkt">
                        </td>
                        
                    </tr>
                </table>
                <div id="ajax_add_product" class='ajax'>
                    
                </div>
                
                
      </form>
</div>