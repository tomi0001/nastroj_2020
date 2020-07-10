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
            <a class='settingPosition' id='settingPosition_2'  onclick="switchSetting('settingUser','settingPosition_2')">DODAJ NOWĄ AKCJE2</a>
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
    
    
    
    
    
    <div id="error">
        @if (!empty(session('errors')))
        @foreach ($errors->all() as $error)
        {{$error}}<br>
       @endforeach
       @endif
    </div>
</div>
@endsection