@extends('Layout.Main')
@section('content')
<body onload='hide_description(10)'>
<br><br>

    <div id="addDrugs">

    @foreach ($listSearch as  $list)
        
   
            
            
        
        <div class='show_drugs' id='titleDrugs{{$i}}'>
            
        <div class='titleDrugs' >
            
            {{$i+1}}
        </div>
           
        <table class='table center'>
            <tr>
                <td class="centerDrugs">
                    Nazwa produktu
                </td>
                <td class="centerDrugs">
                    {{$list->products}}
                    
                    
                    
                </td>
            </tr>
            <tr>
                <td class="center" colspan='2'>
                    <input type="button" class="btn btn-success" onclick="sum_average2('{{route('Drugs.sumAverage2')}}',{{$list->id2}},{{$i}},'{{Request::get('dateStart')}}','{{Request::get('dateEnd')}}')" value="Oblicz średnią">
                </td>
                
            </tr>

            <tr>
                <td colspan='2'>
                    <div id='sum_average{{$i}}' style="overflow-y: scroll;  height:300; display: none;">
                       
                    </div>
                </td>
            </tr>
        </table>
        </div>
    <br>
    @php
        $i++;
    @endphp
    @endforeach
    
    </div>
    
<div class="paginate center">
{{$listSearch->appends(['dateStart'=>Request::get('dateStart')])
                ->appends(['dateEnd'=>Request::get("dateEnd")])
                ->links()}}
                
</div>
@endsection