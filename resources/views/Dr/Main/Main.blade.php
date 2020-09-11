@extends('Dr.Layout.Main')

@section('content')

@if (Session("setAction") == true)

    <body onload="switchVisibleMoodDobule([1,2],1)">   
@else
    <body onload="switchVisibleMoodDobule([1,2],'{{$boolMood}}')">
@endif



    
    @include('Dr.Layout.Calendar')<br>
    <div class='row'>
        <div class='col-md-3 col-lg-4 col-sm-1 col-xs-1'></div>
        <div class='col-md-6 col-lg-4 col-sm-10 col-xs-10'>
            <form method='get'>
                <select name='typeMood' class='form-control' onchange='switchVisibleMoodShow()'>
                    @if (Session("setAction") == true or $boolMood == true)
                        <option value='action' selected>Wyswielt akcje</option>
                        <option value='mood'>Wyswietl nastroje</option>
                    @else
                        <option value='mood' seelected>Wyswietl nastroje</option>
                        <option value='action'>Wyswielt akcje</option>
                    @endif
                    
                </select>
                
            </form>
        </div>
    </div>
    <div id='moodShow' style='display: inline;'>
            @if (count($listMood) == 0)
                <div class="titleError">
                    Nie ma żadnych nastrojów dla tego dnia
                </div>
            @else
                @include ('Dr.Main.showMood')
            @endif
        
    </div>
    <div id='actionShow' style='display: none;'>
        @if (count($listActionMood) == 0)
            <div class="titleError">
                    Nie ma żadnych akcji dla tego dnia
            </div>
        @else
            @include ('Dr.Main.showAction')
        
        @endif
    </div>
    

    
    

    

@endsection