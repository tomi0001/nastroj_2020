@extends('Layout.Main')
@section('content')
<br>
@section ('title') 
 Ustawienia
@endsection
<body onload='switchSetting()'>
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
        <hr class='hrMenu'>
    </div>
    <div id='settingAction' style='display: inline;'>
        <form method='get'>
            <table class='table'>
                <TR>
                    <td width='35%'>
                        Nazwa akcji
                    </td>
                    <td>
                        <input type='text' name='name' class='form-control' onkeypress="return runScriptSettingAddAction(event,'{{ route('Setting.ActionAdd')}}')">
                    </td>
                    
                </TR>
                <TR>
                    <td>
                        poziom przyjemności od -20 do +20
                    </td>
                    <td>
                        <input type='text' name='pleasure' class='form-control' onkeypress="return runScriptSettingAddAction(event,'{{ route('Setting.ActionAdd')}}')">
                    </td>
                    
                </TR>
                <TR>
                 
                    <td colspan='2' class='center'>
                        <input type='button' onclick="addActionSetting('{{ route('Setting.ActionAdd')}}')" class='btn btn-primary' value='Dodaj Akcje'>
                    </td>
                    
                </TR>
                <TR>
                 
                    <td colspan='2' class='center' id="form">
                     
                    </td>
                    
                </TR>
            </table>
        </form>
    </div>
    
    <div id='levelMood' style='display: none;'>
        <form method='get'>
            <table class='table'>
                <TR>
                    <td width='60%'>
                        Wartośc nastroju od do przy której czujesz myśli samobójcze i totalną depresję
                    </td>
                    <td>
                        <div class="row">
                            <div class="col-md-5 col-lg-5 col-xs-5 col-sn-5">
                                <input type='text' name='valueMood-10From'  class='form-control' onkeypress="return runScriptSettingchangeLecelMood(event,'{{ route('Setting.levelMoodChange')}}')"> 
                            </div>
                            <div class="col-md-2 col-lg-2 col-xs-2 col-sn-2">
                                Do 
                            </div>
                            <div class="col-md-5 col-lg-5 col-xs-5 col-sn-5">
                                <input type='text' name='valueMood-10To' class='form-control' onkeypress="return runScriptSettingchangeLecelMood(event,'{{ route('Setting.levelMoodChange')}}')">
                            </div>
                        </div>
                    </td>
                    
                </TR>
                
            </table>
        </form>
    </div>
    
    
    
    <div id="error">
        @if (!empty(session('errors')))
        @foreach ($errors->all() as $error)
        {{$error}}<br>
       @endforeach
       @endif
    </div>
</div>
@endsection