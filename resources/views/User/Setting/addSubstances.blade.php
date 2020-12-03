<div id='addSubstances' style='display: none;'>

     <form method="get" id='addSubstancesAction'>
                <table class="table center">
                    <tr>
                        <td>
                            Nazwa substancji
                        </td>
                        <td>
                            <input type="text" name="name" class="form-control">
                        </td>
                        
                    </tr>
                    <tr>
                        <td>
                            Grupy, które należą<br> do tej substancji
                        </td>
                        <td>
                            <div style="overflow-y: scroll;  height:150; ">
                                <table width='100%' class='color'>
                                @foreach ($listGroup as $list)
                                <tr>
                                <td>
                                    <input type='checkbox' name='group[]' class='form-control' value='{{$list->id}}'>
                                </td>
                                <td>
                                    {{$list->name}}
                                  </td>
                                </tr>
                                @endforeach
         
                                
                                </table>
                                
                            </div>
                        </td>
                        
                    </tr>
                    <tr>
                                
                                <td>
                                    Równoważnik jeżeli jest <br> to benzodiazepina
                                  </td>
                                  <td>
                                    <input type='text' name='equivalent' class='form-control'>
                                </td>
                    </tr>
                    <tr>

                        <td colspan="2" class="center">
                            <input type="button" class="btn btn-success btn-lg" onclick="addSubstances('{{route('setting.addSubstances')}}')" value="Dodaj substancje">
                        </td>
                        
                    </tr>

                </table>
                <div id="ajax_add_substances" class='ajax'>
                    
                </div>
                
                
      </form>
</div>