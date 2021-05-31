<div id="editGroup" style='display: none;'>
     <form method="get" id='editGroupAction'>
                <table class="table center">
                    <tr>
                        <td>
                            Nazwa grupy
                        </td>
                       
                    
                    
                    

                        <td  class="center">
                            <select name="group" class="form-control form-control-lg" onChange="EditGroup('{{route('setting.editGroup')}}')">
                                <option value="" selected></option>
                                @foreach ($listGroup as $listGro)
                                    <option value="{{$listGro->id}}">{{$listGro->name}}</option>
                                @endforeach
                            </select>
                        </td>
                        
                    </tr>
                </table>
                <div id="ajax_editGroup" class='ajax'>
                    
                </div>
                
                
      </form>
</div>