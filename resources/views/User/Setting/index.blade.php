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
        <hr class='hrMenu'>
    </div>
    @include ('User.Setting.addActionSetting')
    @include ('User.Setting.levelMoodChange')
    @include ('User.Setting.changeNameAction')
    
    
    
    
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