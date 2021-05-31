<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">
  
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script>




<div id='averageMoods' style='display: none;'>
    <form method="get" id="form3">
        <table class="table">
            <tr>
                <td class="center">
                    Data od 
                </td>
                <td class="center">
                    <input type="date" name="dateFrom" class="form-control">
                </td>
                <td class="center">
                    Godzina od
                </td>
                <td>
                    <input type="time" name="timeFrom" class="form-control">
                </td>
                <td class="center" style="width: 6%;">
                    dzień
                </td>
                <td >
                    <select name="day" class="form-control">
                        <option value="" selected>Wszystkie</option>
                        <option value="1">Poniedziałek</option>
                        <option value="2">Wtorek</option>
                        <option value="3">Środa</option>
                        <option value="4">Czwartek</option>
                        <option value="5">Piątek</option>
                        <option value="6">Sobota</option>
                        <option value="7">Niedziela</option>
                        
                        
                    </select>
                </td>
                <td class="center">
                    Pogrupuj według miesiąca <input type="checkbox" class="form-control" name="sumMonth">
                
                </td>
            </tr>
            <tr>
                <td class="center">
                    Data do
                </td>
                <td class="center">
                    <input type="date" name="dateTo" class="form-control">
                </td>
                <td class="center">
                    Godzina do
                </td>
                <td>
                    <input type="time" name="timeTo" class="form-control">
                </td>
                <td class="center" colspan="2">
                    Sumuj wszystkie dni <input type="checkbox" class="form-control" name="sumDay">
                </td>
                <td class="center">
                    Całe tygodnie <input type="checkbox" class="form-control" name="allWeek">
                </td>
                <td colspan="2">
                    
                </td>
            </tr>
        <tr>
            <td colspan="8" class="center">
                <input type="button" onclick="searchAI('{{route('Search.AI')}}')" value="Szukaj" class="btn btn-primary">
            </td>
        </tr>
        <tr>
        <td colspan="8">
            
            
        </td>
        </tr>
        </table>
        
    </form>
    <div id="AI" style="margin-left:  auto;margin-right: auto;"></div>
</div>
