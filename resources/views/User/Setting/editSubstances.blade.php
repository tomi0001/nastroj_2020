<div id="editSubstances" style='display: none;'>

     <form method="get" id='editSubstancesAction'>
                <table class="table center">
                    <tr>
                        <td>
                            Nazwa Substancji
                        </td>
                       
                    
                    
                    

                        <td  class="center">
                            <select name="substance" class="form-control form-control-lg" onChange="EditSubstance('{{route('setting.editSubstances')}}')">
                                <option value="" selected></option>
                                @foreach ($listSubstance as $listSub)
                                    <option value="{{$listSub->id}}">{{$listSub->name}}</option>
                                @endforeach
                            </select>
                        </td>
                        
                    </tr>
                </table>
                <div id="ajax_editSubstance" class='ajax' style="overflow-y: scroll;  height:300; width: 60%; margin-left: auto; margin-right: auto;">
                    
                </div>
                
                
      </form>
</div>