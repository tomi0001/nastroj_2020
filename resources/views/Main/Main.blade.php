@extends('Layout.Main')

@section('content')
<script>
    window.onload = switchVisibleMood;
</script>
    
    @include('Layout.Calendar')<br>
    <div class='row'>
        <div class='col-md-3 col-lg-4 col-sm-1 col-xs-1'></div>
        <div class='col-md-6 col-lg-4 col-sm-10 col-xs-10'>
            <form method='get'>
                <select name='type' class='form-control' onchange='switchVisibleMood()'>
                    <option value='mood' selected>Dodaj nowy nastrój</option>
                    <option value='Sleep'>Dodaj nowy Sen</option>
                    <option value='action'>Dodaj nowe zdarzenie</option>
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
@endsection