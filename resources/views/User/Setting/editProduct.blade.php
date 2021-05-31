<div id="editProduct" style='display: none;'>

     <form method="get" id='editProductAction'>
                <table class="table center">
                    <tr>
                        <td>
                            Nazwa Produktu
                        </td>
                       
                    
                    
                    

                        <td  class="center">
                            <select name="product" class="form-control form-control-lg" onChange="EditProduct('{{route('setting.editProduct')}}')">
                                <option value="" selected></option>
                                @foreach ($listProduct as $listPro)
                                    <option value="{{$listPro->id}}">{{$listPro->name}}</option>
                                @endforeach
                            </select>
                        </td>
                        
                    </tr>
                </table>
                <div id="ajax_editProduct" class='ajax' style="overflow-y: scroll;  height:300;  width: 60%; margin-left: auto; margin-right: auto;">
                    
                </div>
                
                
      </form>
</div>