  <head>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
      <meta charset="utf-8">
      <style>
         body {
              font-family: "dejavu sans", serif;
              font-size: 12px;
              color: #000;
          }
          .fontSmall {
                font-size: 6pt;
            }
            .center {
                text-align: center;
            }
            .bold {
                font-weight: bold;
                
            }
            .bold2 {
                font-weight: bold;
                font-size: 6.5pt;
            }
      </style>
   
 </head>

<table border="1">
@for ($i=0;$i< count($data);$i++)


    
            @if (($i == 0 or ($data[$i]["dat"] != $data[$i-1]["dat"] and $data[$i]["type"] == 1)) and $data[$i]["type"] == 1)
            <tr><td class="center bold" colspan="2"> DATA {{$data[$i]["dat"]}} </td></tr>
            <tr><td colspan="2">
            <table>
                        @foreach (App\Http\Services\Common::sumMoods($data[$i]["dat"],$id) as $day)
                    <tr>
                        <th class="center fontSmall">
                            Poziom nastroju dla całego dnia
                        </th>
                        <th class="center fontSmall">
                            Poziom lęku dla całego dnia
                        </th>
                        <th class="center fontSmall">
                            Poziom napięcia dla całego dnia
                        </th>
                        <th class="center fontSmall">
                            Poziom pobudzenia dla całego dnia
                        </th>
                    </tr>
                        <td style="text-align: center;" class="fontSmall">
                            {{round($day["average_mood"],2)}} 
                        </td>
                        <td  style="text-align: center;" class="fontSmall">
                            {{round($day["average_anxiety"],2)}} 
                        </td>
                        <td  style="text-align: center;" class="fontSmall">
                            {{round($day["average_nervousness"],2)}} 
                        </td>
                        <td  style="text-align: center;" class="fontSmall">
                            {{round($day["average_stimulation"],2)}} 
                        </td>
                        @endforeach
            </table>
        </td></tr>
            @endif
            
            <tr>
            @if ($data[$i]["type"] == 0)
                <td class="fontSmall" colspan="2"> SEN  od {{$data[$i]["date_start"]}} do 
                {{$data[$i]["date_end"]}}
                
                @if ($data[$i]["epizodes_psychotik"] != "")
                    <span class="bold">Ilość wybudzeń {{$data[$i]["epizodes_psychotik"]}}</span>
                @endif
                </td>
            @else
            <td class="fontSmall"> NASTRÓJ od {{date("H:i",strtotime($data[$i]["date_start"]))}} do {{date("H:i",strtotime($data[$i]["date_end"]))}} Długość {{$data[$i]["second"] / 60}} Minut<br>
                    Poziom nastroju {{$data[$i]["level_mood"]}}<br>
                    Poziom lęku {{$data[$i]["level_anxiety"]}}<br>
                    Poziom napięcia {{$data[$i]["level_nervousness"]}}<br>
                    Poziom pobudzenia {{$data[$i]["level_stimulation"]}}<br>
                </td> 
                <td class="fontSmall">
                    
                    @foreach (\App\Moods_action::selectAction($data[$i]["id"]) as $actionsMood)
                        <span class="bold2">{{$actionsMood->name}}</span> <br>
                    @endforeach
                    
                    {{$data[$i]["what_work"]}}
                    
                </td>
            @endif
            </tr>
            
            @if (($i != count($data)-1 and $data[$i]["dat"] != $data[$i+1]["dat"] and $data[$i]["type"] == 1) or $i == count($data)-1)
            <tr><td style="border:none; height: 20px;"></td></tr>
            @endif
            
    </td></tr>
@endfor

</table>


