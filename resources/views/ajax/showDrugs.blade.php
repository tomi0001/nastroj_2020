<table class="table" style="width: 50%; margin-left: auto; margin-right: auto;">
    @foreach ($list as $list2)

    <tr style="background-color: #6DA8D5;">
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
        
            @switch ($list2->type)
                @case (1) 
                Mg
                @break;
                @case (2)
                ilości
                @break;
                @case (3) 
                mililitry
                @break;
                @default
                mg
                @break;
                
                
            @endswitch
            
        </td>
    </tr>    

    <tr>
        <td colspan="2">
             <hr style="height:2px;border-width:0;color:gray;background-color:gray"> 
        </td>
    </tr>
 
        
    @endforeach
</table>