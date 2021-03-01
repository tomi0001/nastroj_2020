<div class="center">Ilość dni {{$sumDay}}</div>
    @for ($i=0;$i < count($hourDrugs);$i++)
    <div class="ajaxSucces" >
    {{$hourDrugs[$i][2]}} - {{$hourDrugs[$i][1]}}<br>
    dawka {{round($hourDrugs[$i][0],2)}}<br>

    ilość dni {{$arrayDay[$i]}}<br>
        Ilośc wzięć {{$hourDrugs[$i][4]}}
    </div>
    @if ($hourDrugs[$i][3] == 1)
    <hr>
    @endif
    <br>
    @endfor
    
