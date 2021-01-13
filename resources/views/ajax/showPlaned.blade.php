<table class='table table-condensed' style='width: 80%; margin-left: auto;margin-right: auto;'>
   
    @foreach ($planed as $list)
    <tr>
        <td>
            pozycja {{$loop->index+1}}
        </td>
        <td>
            <select name="position[]" class="form-control" id="position_{{$loop->index+1}}">
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
            <input type="text" name="pisitionName[]" id="positionName_{{$loop->index+1}}" class="form-control" value="{{$list->portion}}">
        </td>
        
        <td>
             <a class="btn btn-danger btn-lg" onclick="removeDrugsPlaned('{{ route('setting.loadPosition')}}',{{$loop->index+1}})" id="a_{{$loop->index+1}}">
                            <span class="glyphicon glyphicon-minus" id="span_{{$loop->index+1}}"></span>
            </a>
        </td>
        @php
            $tmp = $loop->index+1;
        @endphp
    </tr>
    @endforeach
    <tr>
        <td colspan="3">
            <table class='table table-condensed background' id="planedDrugs" style="background-color: rgba(0,0,0,0);">
                
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
        <td colspan="2">
            <div class='center'>
                <input type='submit' class='btn btn-default btn-lg'  value='Uaktualnij'>
            </div>
        </td>
        <td colspan="1">
            <div class='center'>
                <a href="{{ route('setting.deletePlaned',Request::get('planedName'))}}"><input type="button"  class='btn btn-danger btn-lg' value='Usuń'></a>
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
