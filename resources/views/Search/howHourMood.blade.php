<div id='howHourMood' style='display: none;'>
    <form method="get">
        <table class="table" style="width: 70%; margin-left: auto;margin-right: auto;">
            <tr>
                <td>
                    Pozmior nastroju od 
                </td>
                <td>
                    <input type="text" name="moodFrom" class="form-control">
                </td>
                <td>
                    Pozmior nastroju do
                </td>
                <td>
                    <input type="text" name="moodTo" class="form-control">
                </td>
            </tr>
            <tr>
                <td>
                    Pozmior lęku od 
                </td>
                <td>
                    <input type="text" name="anxietyFrom" class="form-control">
                </td>
                <td>
                    Pozmior lęku do
                </td>
                <td>
                    <input type="text" name="anxietyTo" class="form-control">
                </td>
            </tr>
            <tr>
                <td>
                    Pozmior rozdrażnienia od 
                </td>
                <td>
                    <input type="text" name="voltageFrom" class="form-control">
                </td>
                <td>
                    Pozmior rozdrażnienia do
                </td>
                <td>
                    <input type="text" name="voltageTo" class="form-control">
                </td>
            </tr>
            <tr>
                <td>
                    Pozmior pobudzenia od 
                </td>
                <td>
                    <input type="text" name="stimulationFrom" class="form-control">
                </td>
                <td>
                    Pozmior pobudzenia do
                </td>
                <td>
                    <input type="text" name="stimulationTo" class="form-control">
                </td>
            </tr>
            <tr>
                <td>
                    Data od 
                </td>
                <td>
                    <input type="date" name="dateFrom" class="form-control">
                </td>
                <td>
                    Data do
                </td>
                <td>
                    <input type="date" name="dateTo" class="form-control">
                </td>
            </tr>
            <tr>
                <td colspan="4" class="center">
                    <input type="button" class="btn btn-primary btn-lg" onclick="sumMood('{{ route('Search.SumMood')}}')" value="Oblicz">
                </td>
            </tr>
        </table>
    </form>
    <div id="SumMoodSearch">
        
    </div>
   
</div>