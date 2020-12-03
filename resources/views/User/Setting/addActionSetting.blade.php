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
                        <input type='button' onclick="addActionSetting('{{ route('Setting.ActionAdd')}}')" class='btn btn-primary btn-lg' value='Dodaj Akcje'>
                    </td>
                    
                </TR>
                <TR>
                 
                    <td colspan='2' class='center' id="form">
                     
                    </td>
                    
                </TR>
            </table>
        </form>
    </div>
    