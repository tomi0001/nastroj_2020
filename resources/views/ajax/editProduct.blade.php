<form method='get' id="changeSubstance">
<table class='table'>
    <tr>
        <td  class="center">
            Nazwa Produktu
            
        </td>
        <td  class="center">
            <input type="text" name="name" value="{{$name->name}}" class="form-control">
            
        </td>
    </tr>

<tr>
                        <td>
                            Ile ma procent <br> (w przypadku napoju alkholowego)
                        </td>
                        <td>
                                <input type='text' name='percent' class='form-control' value="{{$name->how_percent}}">
                        </td>
                        
                    </tr>
                    <tr>
                        <td>
                            Rodzaj porcji
                        </td>
                        <td>
                            <select name="portion" class="form-control form-control-lg">
            
                                {!!App\Http\Services\Common::selectPortion($name->type_of_portion)!!}
                                
                                
                            </select>
                        </td>
                        
                    </tr>
                    <tr>
                        <td>
                            Cena
                        </td>
                        <td>
                                <input type='text' name='price' class='form-control' value="{{$name->price}}">
                        </td>
                        
                    </tr>
                    <tr>
                        <td>
                            Za ile
                        </td>
                        <td>
                                <input type='text' name='how' class='form-control' value="{{$name->how_much}}">
                        </td>
                        
                    </tr>
    <tr>
        <td colspan="2" class="center">
            <b>Substancje należące do tego produktu</b>
            
        </td>
    </tr>
    @for ($i=0;$i < count($list);$i++)
    <tr>
        <td class='center'>{{$list[$i][1]}}</td>
        
        @if ($list[$i][2] == true)
        <td class='center'><input type='checkbox' class='form-control' value='{{$list[$i][0]}}' name="id[]"  checked ></td>
        @else
        <td class='center'><input type='checkbox' class='form-control' value='{{$list[$i][0]}}' name="id[]" ></td>
        @endif
        
    </tr>
    @endfor
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <tr>
        <td colspan="2" class="center">
            <input type="button" class="btn btn-success" value="Zmień" onclick="changeProduct('{{route('setting.changeProduct')}}',{{$id}})">
        </td>
    </tr>
    <tr>
        <td colspan="2" class="center">
            <div id="productResult"></div>
        </td>
    </tr>
    
</table>
</form>
