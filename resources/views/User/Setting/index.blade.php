@extends('Layout.Main')
@section('content')
<br>
@section ('title') 
 Ustawienia
@endsection

<div class='setting'>
   
        <table class="table login">
            <tr>
                <td colspan="2">
                    <span class="hight">USTAWIENIA UŻYTKOWNIKA</span>
                </td>

            </tr>

        </table>
    
    <div class='menuSetting'>
        <div class='settingPosition'>
            <a class='settingPosition' id='settingPosition_1' onclick="switchSetting('settingAction','settingPosition_1')">DODAJ NOWĄ AKCJE</a>
        </div>
        <div class='settingPosition' >
            <a class='settingPosition' id='settingPosition_2'  onclick="switchSetting('levelMood','settingPosition_2')">POZIOMY NASTROJU</a>
        </div>
        <div class='settingPosition' >
            <a class='settingPosition' id='settingPosition_3'  onclick="switchSetting('changeNameAction','settingPosition_3')">ZMIEŃ NAZWY AKCJI</a>
        </div>
        <div class='settingPosition' >
            <a class='settingPosition' id='settingPosition_4'  onclick="switchSetting('changeDateAction','settingPosition_4')">ZMIEŃ DATY AKCJI</a>
        </div>
        <div class='settingPosition' >
            <a class='settingPosition' id='settingPosition_5'  onclick="switchSetting('addHashDr','settingPosition_5')">NADAJ HASH LEKARZOWI</a>
        </div>
        <div class='settingPosition' >
            <a class='settingPosition' id='settingPosition_6'  onclick="switchSetting('addGroup','settingPosition_6')">DODAJ NOWĄ GRUPĘ</a>
        </div>
        <div class='settingPosition' >
            <a class='settingPosition' id='settingPosition_7'  onclick="switchSetting('addSubstances','settingPosition_7')">DODAJ NOWĄ SUBSTANCJE</a>
        </div>
        <div class='settingPosition' >
            <a class='settingPosition' id='settingPosition_8'  onclick="switchSetting('addProduct','settingPosition_8')">DODAJ NOWY PRODUKT</a>
        </div>
        <div class='settingPosition' >
            <a class='settingPosition' id='settingPosition_9'  onclick="switchSetting('addPlaned','settingPosition_9')">ZAPLANUJ DAWKĘ</a>
        </div>
        <hr class='hrMenu'>
    </div>
    @include ('User.Setting.addActionSetting')
    @include ('User.Setting.levelMoodChange')
    @include ('User.Setting.changeNameAction')
    @include ('User.Setting.changeDateAction')
    @include ('User.Setting.addHashDr')
    @include ('User.Setting.addGroup')
    @include ('User.Setting.addSubstances')
    @include ('User.Setting.addProduct')
    @include ('User.Setting.addPlaned')
    
    
    
    
    <div id="error">
        @if (!empty(session('errors')))
        @foreach ($errors->all() as $error)
        {{$error}}<br>
       @endforeach
       @endif
    </div>
</div>
    <script>
    window.onload=switchSetting();

    </script>
@endsection