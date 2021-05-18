@if (count($ActionDay) != 0 ) 
<table class="table" style="width: 90%; margin-left: auto;margin-right: auto;">
    
    <tr>
    <th style="background-color: #8F8FBD; color: yellow" class="center">
        Akcje dla całego dnia
    </th>
    </tr>
    

    @foreach ($ActionDay as $list)
    <tr>
        <td class="center">
     
            
            <div class='namePleasure level_pleasure_{{\App\Http\Services\Action::setColorPleasure(\App\Action::selectNameAction2($list->id_actions,$idUser)->level_pleasure)}}'>
             
             <span class="level_pleasure"> {{\App\Action::selectNameAction($list->id_actions,$idUser)->name}}</span> <br>

        </div>
        </td>
    </tr>
       
    @endforeach

@else

            <div class="titleError">
                    Nie ma żadnych czynnści dla danego dnia
            </div>
@endif
</table>





<table class="table" style="width: 90%; margin-left: auto;margin-right: auto;">
    <tr>
        <th style="background-color: #8F8FBD; color: yellow" class="center" colspan="3">
        Zaplanowane czynności
        </th>
    </tr>
    <tr>
        <td class="center">
            Godzina od
        </td>
        <td class="center">
            Godzina do
        </td>
        <td class="center">
            Nazwa czynności
        </td>
    </tr>
    
    @for ($i=0;$i < count($listActionMood);$i++)
        @if (($i > 0 and $listActionMood[$i]["date_start"] != $listActionMood[$i-1]["date_start"]) or $i == 0)
        <tr>
            <td width="15%" class="center">
                {{$listActionMood[$i]["date_start"]}} 
                
                
                
            </td>
            <td width="15%" class="center">
                {{$listActionMood[$i]["date_end"]}}
            </td>
        <td class="center">
           <div class='divpleasure'>
        @endif
       
         <div class='namePleasure level_pleasure_{{$listActionMood[$i]['level_pleasure']}}'>
             
             <span class=" level_pleasure" > {{$listActionMood[$i]["name"]}}</span> <br>
             @if ($listActionMood[$i]["percent"] != "")
             <span class=" level_pleasure bold" >Procent wykonania  {{$listActionMood[$i]["percent"]}} % </span>
             @endif
        </div>
        <div class='blank'>
            &nbsp;
        </div>
        
        @if (($i < count($listActionMood)-1 and $listActionMood[$i]["date_start"] != $listActionMood[$i+1]["date_start"]) or $i == count($listActionMood))
           </div>
        </td>
 
        </tr>
        @endif
        
        
        
    @endfor
    
</table>