@extends('Layout.Main')

@section('content')
@section ('title') 
 Wyszukaj
@endsection

<div class='setting'>
   
        <table class="table login">
            <tr>
                <td colspan="2">
                    <span class="hight">OPCJE WYSZUKIWANIA</span>
                </td>

            </tr>

        </table>
    
    <div class='menuSetting'>
        <div class='settingPosition'>
            <a class='settingPosition' id='settingPosition_1' onclick="switchSettingSearch('mainSearch','settingPosition_1')">WYSZUKAJ NASTRÓJ</a>
        </div>
        <div class='settingPosition' >
            <a class='settingPosition' id='settingPosition_2'  onclick="switchSettingSearch('SearchSleep','settingPosition_2')">WYSZUKAJ SEN</a>
        </div>
        <div class='settingPosition' >
            <a class='settingPosition' id='settingPosition_3'  onclick="switchSettingSearch('averageMood','settingPosition_3')">OBLICZ ŚREDNIĄ TRWANIA NASTROJU</a>
        </div>
        <div class='settingPosition' >
            <a class='settingPosition' id='settingPosition_4'  onclick="switchSettingSearch('howHourMood','settingPosition_4')">OBLICZ ILE H TRWAŁY NASTROJE</a>
        </div>
        <div class='settingPosition' >
            <a class='settingPosition' id='settingPosition_5'  onclick="switchSettingSearch('PDF','settingPosition_5')">WYGENERUJ PDF DLA NASTROJI</a>
        </div>
        <hr class='hrMenu'>
    </div>
   @include ('Search.mainSearch')
    
    
    
    
    <div id="error">
        @if (!empty(session('errors')))
        @foreach ($errors->all() as $error)
        {{$error}}<br>
       @endforeach
       @endif
    </div>
</div>
    <script>
    window.onload=switchSettingSearch();

    </script>
@endsection