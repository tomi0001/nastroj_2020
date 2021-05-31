<div id='addGroup' style='display: none;'>

     <form method="get" id='addGroupAction'>
                <table class="table center">
                    <tr>
                        <td>
                            Nazwa grupy
                        </td>
                        <td>
                            <input type="text" name="name" class="form-control">
                        </td>
                        
                    </tr>

                    <tr>

                        <td colspan="2" class="center">
                            <input type="button" class="btn btn-success btn-lg" onclick="addGroup('{{route('setting.addGroup')}}')" value="Dodaj grupę">
                        </td>
                        
                    </tr>
                </table>
                <div id="ajax_add_group" class='ajax'>
                    
                </div>
                
                
      </form>
</div>