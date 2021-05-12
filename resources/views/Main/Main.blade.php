@extends('Layout.Main')

@section('content')

@if (Session("setAction") == true)

    <body onload="switchVisibleMoodDobule([1,2],1)">   
@else
    <body onload="switchVisibleMoodDobule([1,2],'{{$boolMood}}')">
@endif



    
    @include('Layout.Calendar')<br>
    <div class='row'>
        <div class='col-md-3 col-lg-4 col-sm-1 col-xs-1'></div>
        <div class='col-md-6 col-lg-4 col-sm-10 col-xs-10'>
            <form method='get'>
                <select name='typeMood' class='form-control' onchange='switchVisibleMoodShow()'>
                    @if (Session("setAction") == true or $boolMood == true)
                        <option value='action' selected>Wyswielt akcje</option>
                        <option value='mood'>Wyswietl nastroje</option>
                        <option value='drugs'>Wyswietl leki</option>
                    @else
                        <option value='mood' seelected>Wyswietl nastroje</option>
                        <option value='action'>Wyswielt akcje</option>
                        <option value='drugs'>Wyswietl leki</option>
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
                @include ('Main.showMood')
            @endif
        
    </div>
    <div id='actionShow' style='display: none;'>
        @if (count($listActionMood) == 0 and count($ActionDay) == 0 )
            <div class="titleError">
                    Nie ma żadnych akcji dla tego dnia
            </div>
        @else
            @include ('Main.showAction')
        
        @endif
    </div>
    <div id='drugsShow' style='display: none;'>
        @if (count($listDrugs) == 0)
            <div class="titleError">
                    Nie ma żadnych leków dla tego dnia
            </div>
        @else
            @include ('Main.showDrugs')
        
        @endif
    </div>    
    
    <div class='row'>
        <div class='col-md-3 col-lg-4 col-sm-1 col-xs-1'></div>
        <div class='col-md-6 col-lg-4 col-sm-10 col-xs-10'>
            <form method='get'>
                <select name='type' class='form-control' onchange='switchVisibleMood()'>
                    <option value='mood' selected>Dodaj nowy nastrój</option>
                    <option value='Sleep'>Dodaj nowy Sen</option>
                    <option value='action'>Dodaj nowe zdarzenie</option>
                    <option value='drugs'>Dodaj nowy lek</option>
                    <option value='actionDay'>Dodaj nową akcję całodniową</option>
                </select>
                
            </form>
        </div>
    </div>
    
    

    
    <div id='moodAdd' style='display: inline;'>
        @include('Main.addMood')
    </div>
    <div id='moodAction' style='display: none;'>
        @include('Main.addAction')
    </div>
    <div id='SleepAdd' style='display: none;'>
        @include('Main.addSleep')
    </div>
    <div id="drugsAdd" style="display: none;">
        @include('Main.addDrugs')
    </div>
    <div id="actionDayAdd" style="display: none;">
        @include('Main.actionDayAdd')
    </div>
@endsection