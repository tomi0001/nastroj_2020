<form method='get' id="FormEditGroupAction">
<table class='table' style=" width: 80%; text-align: center; margin-left: auto; margin-right: auto;">
    <tr>
        <td class='center'>Nazwa</td>
        
    
        <td class='center'><input type='text' class='form-control' value='{{$list->name}}' name="name"></td>
        
    </tr>

    <tr>
        <td colspan="2" class="center">
            <input type="button" class="btn btn-success btn-lg"  value="Zmień" onclick="changeGroup('{{route('setting.changeGroup')}}',{{$list->id}})">
        </td>
    </tr>
    <tr>
        <td colspan="2" class="center">
            <div id="groupResult"></div>
        </td>
    </tr>
    
</table>
</form>
