<table class="table">
    <form  method="get">
    <tr>
        <td>
            Ilość wybudzeń
        </td>
        <td>
            <input type="text" id="sleep{{$i}}" class="form-control" min='0' value="{{$awek}}"  onkeypress="return runScriptEditSleep(event,'{{ route('Sleep.editAction')}}',{{$id}},{{$i}})">
        </td>
    </tr>
    
    <tr>

        <td colspan="2" class="center">
            <input type="button" value="Edytuj" class="btn btn-primary"  onclick="editSleepAction('{{ route('Sleep.editAction')}}',{{$id}},{{$i}})">
        </td>
    </tr>

    </form>
    
</table>

<div id="viewEditSleep2{{$i}}"></div>