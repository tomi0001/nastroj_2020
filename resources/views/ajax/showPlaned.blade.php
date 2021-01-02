<table class='table' style='width: 80%; margin-left: auto;margin-right: auto;'>
    <form method="get">
    @foreach ($planed as $list)
    <tr>
        <td>
            pozycja {{$loop->index+1}}
        </td>
        <td>
            <select name="position{{$loop->index}}" class="form-control">
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
            <input type="text" name="pisitionName{{$loop->index}}" class="form-control" value="{{$list->portion}}">
        </td>
    </tr>
    @endforeach
    </form>
</table>