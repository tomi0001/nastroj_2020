@extends('Layout.Main')

@section('content')
@section ('title') 
 Wyszukaj
@endsection
<script data-ad-client="ca-pub-9009102811248163" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
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
            <a class='settingPosition' id='settingPosition_3'  onclick="switchSettingSearch('averageMoods','settingPosition_3')">OBLICZ ŚREDNIĄ TRWANIA NASTROJU</a>
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
   @include ('Search.SearchSleep')
   @include ('Search.averageMoods')
   @include ('Search.howHourMood')
    
    
    
    
    <div id="error">
        @if (!empty(session('errors')))
        @foreach ($errors as $error)
        {{$error}}<br>
       @endforeach
       @endif
    </div>
</div>
    <script>
    window.onload=switchSettingSearch();

    </script>
@endsection