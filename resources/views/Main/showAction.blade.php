@if (count($ActionDay) != 0 ) 
<table class="table" style="width: 90%; margin-left: auto;margin-right: auto;">
    
    <tr>
        <th style="background-color: #8F8FBD; color: yellow" class="center" colspan="3">
        Akcje dla całego dnia
    </th>
    </tr>
    

    @for($i=0;$i < count ($ActionDay);$i++)

    <tr>
        <td class="center" colspan="3">
     
            
            <div class='namePleasure level_pleasure_{{\App\Http\Services\Action::setColorPleasure(\App\Action::selectNameAction2($ActionDay[$i]->id_actions,$idUser)->level_pleasure)}}'>
             
             <span class="level_pleasure"> {{\App\Action::selectNameAction($ActionDay[$i]->id_actions,$idUser)->name}}</span> <br>
          
            </div>
            <div>
                Dodano {{\App\Http\Services\Common::returnHour($ActionDay[$i]->created_at)}}
            </div>
        </td>
    </tr>
    

    <form method="get" id='formActionDay{{$i}}' >
        
    <tr>
        <td class="center">
            Zamień na
        </td>
        <td>
            <input type="hidden" name="actionForDayId" value="{{$ActionDay[$i]->id}}">
    <select name="actionForDay" class="form-control">
            @foreach ($Action as $list2)
                @if ($ActionDay[$i]->id_actions == $list2->id)
                    <option value="{{$list2->id}}" selected>{{$list2->name}}</option>
                @else
                    <option value="{{$list2->id}}">{{$list2->name}}</option>
                @endif
            @endforeach
    </select>
        </td>
        <td>
            <input type="button" onclick="UpdateActionDay('{{ route('Action.changeDay')}}',{{$i}})" class="btn btn-primary" value="Zamień">
        </td>
    </tr>
        
      </form>
 @if ($i != count($ActionDay)-1 and \App\Http\Services\Common::diffTime($ActionDay[$i]->created_at,$ActionDay[$i+1]->created_at) == true)
 
     <tr>
        <td class="center" colspan="3">
     
            <hr class="action">
            <br>
            <br><br>
            <br>
            <br>
            
        </td>
    </tr>
 @endif
    @endfor
    <tr>
        <td colspan="3">
            <div id='ForDayAction'>
                
            </div>
        </td>
    </tr>
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