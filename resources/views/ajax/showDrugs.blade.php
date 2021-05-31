<table class="table" style="width: 50%; margin-left: auto; margin-right: auto;">
    @foreach ($list as $list2)
    @if (strtotime(str_replace("/"," ",$list2->date)) < strtotime(str_replace("/"," ",$dateStart)) )
        <tr style="background-color: #81c784;">
    @else
         <tr style="background-color: green;">
    @endif
        <th>Nazwa</th>
        <th>{{$list2->name}}</th>
    </tr>

    <tr>
        <td>Data wzięcia</td>
        <td>{{$list2->date}}</td>
    </tr>
    <tr>
        <td>Porcja</td>
        <td>{{$list2->portion}}   
        
        {!!App\Http\Services\Common::selectPortionInt($list2->type)!!}
            
        </td>
    </tr>    

    <tr>
        <td colspan="2">
             <hr style="height:2px;border-width:0;color:gray;background-color:gray"> 
        </td>
    </tr>
 
        
    @endforeach
</table>