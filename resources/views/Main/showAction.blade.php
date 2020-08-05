<table class="table" style="width: 90%; margin-left: auto;margin-right: auto;">
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
           
        @endif
       
         <div class='namePleasure'>
             
        <span class=" level_pleasure level_pleasure_{{$listActionMood[$i]['level_pleasure']}}"> {{$listActionMood[$i]["name"]}}</span>
             
        </div>
        
        
        @if (($i < count($listActionMood)-1 and $listActionMood[$i]["date_start"] != $listActionMood[$i+1]["date_start"]) or $i == count($listActionMood))
            
        </td>
 
        </tr>
        @endif
        
        
        
    @endfor
    
</table>