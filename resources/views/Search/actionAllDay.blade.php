<div id='actionAllDay' style='display: none;'>
        <form method='get' action="{{ route("search.mainActionAllDay")}}">
            <table class='table width'>
                
                
                <tr>
                    <td>
                        DATA od
                    </td>
                    <td>
                        <input type="date" name="dateFrom" class="form-control" value="{{Request::old("dateFrom")}}">
                    </td>
                    <td>
                        Do
                    </td>
                    <td colspan="2">
                        <input type="date" name="dateTo" class="form-control" value="{{Request::old("dateTo")}}">
                    </td>
                </tr>
                <TR>
                

                <tr>
                    <td>
                        Słowa kluczowe akcji
                    </td>
                    <td colspan="3">
                        <div id="actionSearch2" >
                            <div style='float: left; width: 60%;'>
                                <input type="text" name="actions[]" class="form-control" placeholder="nazwa">
                            </div>

                        </div>
                        
                            &nbsp;&nbsp;&nbsp;
                        
                        <a class="btn btn-info btn-lg" onclick="addActionSearchDay()">
                            <span class="glyphicon glyphicon-plus"></span>
                        </a>
                    </td>

                </tr>
                
                
                
                
                <tr>
                    <td>
                        Sortuj wg
                    </td>

                    <td colspan="3">
                        <select name="sort" class="form-control">
                            <option value="date">Daty</option>
                        </select>
                    </td>
                    <td colspan="3">
                    </td>
                </tr>


                <TR>
                    <td colspan='5' class='center'>
                        <input type='submit'  class='btn btn-primary btn-lg' value='Wyszukaj'>
                    </td>

                </TR>

            </table>
        </form>
    </div>
