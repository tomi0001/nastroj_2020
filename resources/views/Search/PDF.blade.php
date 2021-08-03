<div id='PDF' style='display: none;'>
    <form method='get' action="{{ route("search.generationPDF")}}">
            <table class='table width' style="width: 60%;">
                <tr>
                    <td>
                        Data od
                    </td>
                    <td>
                        <input type="date" name="dateFrom" class="form-control">
                    </td>
                </tr>
                <tr>
                    <td>
                        Data do
                    </td>
                    <td>
                        <input type="date" name="dateTo" class="form-control">
                    </td>
                </tr>
                <tr>
                    <td>
                        Wybierz sam nastrój
                    </td>
                    <td>
                        <div style="width: 15%;">
                            <input type='checkbox' name='onlyMood' class='form-control' >
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        Wybierz też leki
                    </td>
                    <td>
                        <div style="width: 15%;">
                            <input type='checkbox' name='selectDrugs' class='form-control' >
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        Wybierz też akcje
                    </td>
                    <td>
                        <div style="width: 15%;">
                            <input type='checkbox' name='selectAction' class='form-control' >
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        Wybierz też opis
                    </td>
                    <td>
                        <div style="width: 15%;">
                            <input type='checkbox' name='selectDescription' class='form-control' >
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="center">
                        <input type="submit" class="btn btn-primary btn-lg" value="Wygeneruj PDF">
                    </td>
                </tr>
                
            </table>
        
    </form>
</div>

