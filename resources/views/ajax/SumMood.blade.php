<div style="margin-left: auto;margin-right: auto; background-color: #6EA7A4; width: 70%; border-radius: 20px; text-align: center;">
    
    <table class="table table-dark">
        <tr>
            <td>
                Nastrój od
            </td>

            <td>
                Nastrój do
            </td>

            <td>
                lęk od
            </td>

            <td>
                lęk do
            </td>

            <td>
                Napięcie od
            </td>

            <td>
                Napięcie do
            </td>

            <td>
                Pobudzenie od
            </td>

            <td>
                Pobudzenie do
            </td>

            <td>
                data od
            </td>

            <td>
                data do
            </td>
 </tr>
        <tr>
            <td>
                
                {{$request->get('moodFrom')}}
            </td>

            <td>
                {{$request->get('moodTo')}}
            </td>

            <td>
                {{$request->get('anxietyFrom')}}
            </td>

            <td>
                {{$request->get('anxietyTo')}}
            </td>

            <td>
                {{$request->get('voltageFrom')}}
            </td>

            <td>
               {{$request->get('voltageTo')}}
            </td>

            <td>
                {{$request->get('stimulationFrom')}}
            </td>

            <td>
                {{$request->get('stimulationTo')}}
            </td>
       
            <td>
                {{$request->get('dateFrom')}}
            </td>

            <td>
                {{$request->get('dateTo')}}
            </td>
        </tr>
    </table>

    
    
Liczba godzin nastroju = {{$hour}}<br>
Procent {{$percent}}%

</div>
`
