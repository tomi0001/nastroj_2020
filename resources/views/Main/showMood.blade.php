
@php
    $i = 1;
@endphp
@if (!empty($colorForDay) )
    <div class='level{{$colorForDay["mood"]}}' style='width: 30%; text-align: center; margin-left: auto;margin-right: auto;'>
        Poziom nastróju dla tego dnia {{$dayList["mood"]}}
    </div>
    <div class='level{{$colorForDay["anxiety"]}}' style='width: 30%;text-align: center; margin-left: auto;margin-right: auto;'>
        Poziom lęku dla tego dnia {{$dayList["anxiety"]}}
    </div>
    <div class='level{{$colorForDay["nervousness"]}}' style='width: 30%;text-align: center; margin-left: auto;margin-right: auto;'>
        Poziom napięcia/rozdrażnienia dla tego dnia {{$dayList["nervousness"]}}
    </div>
    <div class='level{{$colorForDay["stimulation"]}}' style='width: 30%;text-align: center; margin-left: auto;margin-right: auto;'>
        Poziom pobudzenia dla tego dnia {{$dayList["stimulation"]}}
    </div>
@endif



<table class="table" style="width: 95%; margin-left: auto;margin-right: auto;">
    <thead class="titleThead">
        <td width="10%" class="center">
            Start
        </td>
        <td width="10%" class="center">
            Koniec
        </td>
        <td width="10%" class="center">
            Nastrój
        </td>
        <td width="10%" class="center">
            Lęk
        </td>
        <td width="10%" class="center">
           napięcie/rozdrażnienie
        </td>
        <td width="10%" class="center">
            Pobudzenie
        </td>
        <td width="15%" class="center">
            Epizdy Pychotyczne /<br> Ilośc wybudzeń
        </td>
    </thead>
    @foreach ($listMood as $list)
        <tr class="idMood{{$i-1}}" id="id_{{$list["id"]}}">
            @if ($list["type"] == 0)
                <td colspan="7" class=" titlemood" >

                    <div class="titleSleep2" style="width: {{$listPercent[$i-1]["percent"]}}%;"> <span style="color: #7e1d38; font-size: 21px;">{{$i}}</span></div>

                </td>
            @else
                <td colspan="7"  class="level titlemood"  >

                    <div class="titlemood{{$list["color_mood"]}}" style="width: {{$listPercent[$i-1]["percent"]}}%;"> <span style="color: #7e1d38; font-size: 21px;">{{$i}}</span></div>

                </td>
            @endif
        </tr>
    <tr>
        <td colspan="7" class="idMood{{$i-1}}">

            <table width=" 100%">
                <tr>
            <td  width="10%" class="center">
                {{substr($list["date_start"],11,5)}}
            </td>
            <td  width="10%" class="center">
                {{substr($list["date_end"],11,5)}}
            </td>
                    @if ($list["type"] != 0)
        <td  width="10%" class="center" rowspan="2">
            {{$listPercent[$i-1]["level_mood"]}}
        </td>
            <td  width="10%" class="center" rowspan="2">
                {{$listPercent[$i-1]["level_anxiety"]}}
            </td>
            <td  width="10%" class="center" rowspan="2">
                {{$listPercent[$i-1]["level_nervousness"]}}
            </td>
            <td  width="10%" class="center" rowspan="2">

                {{$listPercent[$i-1]["level_stimulation"]}}
            </td>
                        @else
                        <td  width="10%" class="center" rowspan="2">

                        </td>
                        <td  width="10%" class="center" rowspan="2">

                        </td>
                        <td  width="10%" class="center" rowspan="2">

                        </td>
                        <td  width="10%" class="center" rowspan="2">


                        </td>
                    @endif
                    @if ($listPercent[$i-1]["epizodes_psychotik"] != null and $list["type"] == 0)
                        <td  width="15%" class="centerbold boldWarning" rowspan="2">

                                Ilość wybudzeń {{$listPercent[$i-1]["epizodes_psychotik"]}}

                        </td>
                    
                        
                    
                    
                    @elseif ($listPercent[$i-1]["epizodes_psychotik"] != null and $list["type"] == 1)
                            <td  width="15%" class="centerbold boldWarning" rowspan="2">

                                    Ilość epizodów psychotycznych {{$listPercent[$i-1]["epizodes_psychotik"]}}

                            </td>

                    @else
                        <td  width="15%" class="center" rowspan="2">

                               Brak

                        </td>
                    @endif

                </tr>
                <tr>
                    <td colspan="2" class="center" rowspan="2">
                        {{$listPercent[$i-1]["second"]}}
                    </td>



    </tr>
                </table>
        </td>
    </tr>
    <tr>
        <td colspan="7"  class="idMood{{$i-1}}">
            @if ( ($list["type"] == 0))
                <button onclick="deleteSleep('{{ route('sleep.delete')}}',{{$listMood[$i-1]["id"]}},{{$i-1}})" class='btn btn-danger btn-lg'>usuń sen</button>
            @else
                <div class="buttonMood">
                    @if ($listPercent[$i-1]["name"] != 0)
                        <button onclick="showAction('{{route('action.show')}}',{{$i-1}},{{$listPercent[$i-1]["id"]}})" class="btn btn-primary btn-lg">Pokaż akcje</button>
                    @else
                        <button class="btn btn-danger btn-lg" disabled>Nie było akcji</button>
                    @endif
                        @if ($listPercent[$i-1]["what_work"] == true)
                            <button onclick="showDescription('{{route('mood.showDescription')}}',{{$listPercent[$i-1]["id"]}},{{$i-1}})" class="btn btn-primary btn-lg">Pokaż opis</button>
                        @else
                            <button  class="btn btn-danger btn-lg" disabled>Nie było opisu</button>
                        @endif
                        
                        <button onclick="editMood('{{route('mood.edit')}}',{{$listMood[$i-1]["id"]}},{{$i-1}})" class="btn btn-primary btn-lg">Edytuj nastrój</button>
                        <button onclick="deleteMood('{{route('mood.delete')}}',{{$listMood[$i-1]["id"]}},{{$i-1}})" class="btn btn-danger btn-lg">Usuń nastrój</button>
                        <button onclick="addDescription('{{route('mood.addDescription')}}',{{$listMood[$i-1]["id"]}},{{$i-1}})" class="btn btn-primary btn-lg">Edytuj dodaj opis</button>
                </div>
            @endif




            <br>
                <div id="showActions{{$i-1}}" style='display: none;'></div>
                <div id="showDescription{{$i-1}}" style='display: none;'></div>
                <div id="showFieldText{{$i-1}}" class='center' style='width: 50%; display: none;'></div>
                <div id="viewEditMood{{$i-1}}" style='display: none;'></div>

               


            <table width="60%" align="center">
                <tr>
                    <td colspan="6">
            <div id="addDrugsResult{{$i-1}}"></div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>





    <tr>
        <td colspan="7">
            <hr class="mood">
        </td>
    </tr>
        @php
            $i++;
        @endphp

    @endforeach
</table>

