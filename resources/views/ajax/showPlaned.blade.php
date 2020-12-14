<table class='table' style='width: 80%; margin-left: auto;margin-right: auto;'>
    @foreach ($planed as $list)
    <tr>
        <td>
            pozycja {{$loop->index+1}}
        </td>
        <td>
            {{App\Product::loadNameProducts($list->id_products)->name}}
        </td>
    </tr>
    @endforeach
</table>