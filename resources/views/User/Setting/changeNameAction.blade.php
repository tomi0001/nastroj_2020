
<div id='changeNameAction' style='display: none;'>
    <table class="table">
        <form method="get">
        <tr>
            <td>
                Wybierz akcje
            </td>
            <td>
                <select name="actionName" class="form-control" onchange="loadActionChange('{{ route("user.changeActionName")}}')">
                    <option value='' selected></option>
                    @foreach ($actionName as $list)
                        <option value="{{$list->id}}" >{{$list->name}}</option>
                        
                    @endforeach
                </select>
               
            </td>
        <tr>
            <td>
               Zmień nazwę 
            </td>
            <td>
                
                    <textarea name="nameActionChange" rows="4" class="form-control" id='changeNameActionForm'></textarea>
                
            </td>
        </tr>
        <tr>
            <td colspan='2' class='center'>
                
                <input type="button" onclick="changeNameAction('{{ route('user.changeActionName2')}}')" value='Zmień nazwę' class='btn btn-primary'>
                
            </td>
        </tr>
        <tr>
            <td colspan='2' class='center'>
                <div id='changeNameActionForm2'>
                    
                </div>
            </td>
        </tr>
        </form>
    </table>
</div>

<script>
    window.onload=loadActionChange('{{ route("user.changeActionName")}}');

    </script>