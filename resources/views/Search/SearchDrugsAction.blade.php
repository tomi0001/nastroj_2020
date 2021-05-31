@extends('Layout.Main')
@section('content')
<body onload='hide_description(10)'>
    <div id="addDrugs">
        @if ($error != "")
        <div class="center">
            <span class="error">{{$error}}</span><br>
            <button class="btn btn-success" onclick="javascript:history.back()">Wstecz</button>
        </div>
        @endif
    @foreach ($listSearch as  $list)
        
            @if ($i == 0)
            <div class="title_search_drugs">{{$day[$i][0]}}  {{\App\Http\Services\Common::returnDayWeek($day[$i][0])}}</div>
            
            @elseif ($day[$i-1][0] != $day[$i][0])
            <div class="title_search_drugs">{{$day[$i][0]}}  {{\App\Http\Services\Common::returnDayWeek($day[$i][0])}}</div>
            @else
            <div class="empty"></div>
            @endif
            
            
        
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
                    {{$list->name}}
                    
                    
                    
                </td>
            </tr>
            <tr>
                <td class="centerDrugs">
                    Data
                </td>
                <td class="centerDrugs">
                    {{$list->date}} 
                    
                </td>
            </tr>
            <tr>
                <td class="centerDrugs">
                    Dawka
                </td>
                <td class="centerDrugs">
                    {{$list->portion}} {!!App\Http\Services\Common::selectPortionInt($list->type)!!}
                    
                </td>
            </tr>
            @if ($inDay != "")
            <tr>
                <td class="centerDrugs">
                    Dawka dobowa
                </td>
                <td class="centerDrugs">
                    {{$list->por}} {{$day[$i][4]}}
                    
                </td>
            </tr>
            @endif
            <tr>
                <td class="centerDrugs">
                    <a href="{{route('main')}}/{{$day[$i][1]}}/{{$day[$i][2]}}/{{$day[$i][3]}}"><input type='button' value="Idź do dnia" class="btn btn-success"></a>
                </td>
                <td class="centerDrugs">
                    
                    @if ($list->description != "")
                    <input type='button' value="Pokaż opis" class="btn btn-success" onclick="showDescriptionDrugs({{$i}},'{{route('Drugs.showDescription')}}',{{$list->id_usees}})">
                    @else
                    <input type='button' value="Nie było opisu"  disabled class="btn btn-danger">
                    @endif
                    
                </td>
            </tr>
            <tr>
                <td class="centerDrugs" colspan="2">
                    <div id="show_descriptionDrugs{{$i}}" style='display: none;'></div>
                    
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
{{$listSearch->appends(['sort'=>Request::get('sort')])
                ->appends(['product'=>Request::get("product")])
                ->appends(['substances'=>Request::get("substances")])
                ->appends(['group'=>Request::get("group")])
                ->appends(['search'=>Request::get("search")])
                ->appends(['dose1'=>Request::get("dose1")])
                ->appends(['dose2'=>Request::get("dose2")])
                ->appends(['inDay'=>Request::get("inDay")])
                ->appends(['day'=>Request::get("day")])
                ->appends(['data1'=>Request::get("data1")])
                ->appends(['data2'=>Request::get("data2")])
                ->appends(['hour1'=>Request::get("hour1")])
                ->appends(['hour2'=>Request::get("hour2")])
                ->links()}}
                
</div>
@endsection