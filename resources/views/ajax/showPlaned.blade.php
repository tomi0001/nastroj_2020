<table class='table' style='width: 80%; margin-left: auto;margin-right: auto;'>
   
    @foreach ($planed as $list)
    <tr>
        <td>
            pozycja {{$loop->index+1}}
        </td>
        <td>
            <select name="position[]" class="form-control">
            @foreach ($listProduct as $list2)
                @if ($list->id_products == $list2->id)
                    <option value="{{$list2->id}}" selected>{{$list2->name}}</option>
                @else
                    <option value="{{$list2->id}}" >{{$list2->name}}</option>
                @endif
            @endforeach
            </select>
        </td>
        <td>
            <input type="text" name="pisitionName[]" class="form-control" value="{{$list->portion}}">
        </td>
        @php
            $tmp = $loop->index+1;
        @endphp
    </tr>
    @endforeach
    <tr>
        <td colspan="3">
            <table class='table' id="planedDrugs">
                
            </table>
        </td>
    </tr>

    <tr>
        <td colspan="3">
            <a class="btn btn-info btn-lg" onclick="addDrugsPlaned('{{ route('setting.loadPosition')}}',{{$tmp+1}})">
                            <span class="glyphicon glyphicon-plus"></span>
            </a>
        </td>
    </tr>
    <input type="hidden" name="namePlaned" value="{{Request::get('planedName')}}"
    <tr>
        <td colspan="3">
            <div class='center'>
                <input type='submit' class='btn btn-default btn-lg'  value='Uaktualnij'>
            </div>
        </td>
    </tr>
    <tr>
        <td colspan="3">
            <div id="PlanedResult">
                
            </div>
        </td>
    </tr>
    </form>
</table>