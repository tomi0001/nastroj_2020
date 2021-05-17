<div id='difference' style='display: inline;'>
        <form method='get' action="{{ route("search.difference")}}">
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
                
                <tr>
                    <td>
                        Sortuj wg
                    </td>

                    <td colspan="4">
                        <select name="sort" class="form-control">
                            <option value="date">Daty</option>
                            <option value="longMood">Długości </option>
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
