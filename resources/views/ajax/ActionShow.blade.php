  <div class="ajaxlist">
      <table class="tableAction ajaxlist">
          
          <tr class="trAction">
              <td width="10%" class="tdAction"></td>
              <td class="tdAction">
                  <div class="center silverActions">Nazwa</div>
              </td>
              <td class="tdAction"><div class="center silverActions">Procent wykonania</div></td>
              <td width="10%" class="tdAction"></td>
          </tr>
        @foreach ($list as $list2)
        <tr>
            <td width="10%" class="tdAction"></td>
            <td class="tdAction"><div class=' center namePleasure level_pleasure_{{App\Http\Services\Action::setColorPleasure($list2->level_pleasure)}}'><span class=" level_pleasure" >{{$list2->name}}</span></div></td>
            @if (isset(App\Actions_plan::setAllDay($list2->id)->if_all_day) and   App\Actions_plan::setAllDay($list2->id)->if_all_day == 1)
                <td class="tdAction"><div class="center colorLevel_percent colorLevel_percent_{{App\Http\Services\Action::setColorPercent($list2->percent_executing / 100 * App\Actions_plan::setAllDay($list2->id)->datediff,2)}}">{{round($list2->percent_executing / 100,2)  * App\Actions_plan::setAllDay($list2->id)->datediff}} %</td>
            @else
                <td class="tdAction"><div class="center colorLevel_percent colorLevel_percent_{{App\Http\Services\Action::setColorPercent($list2->percent_executing / 100,2)}}">{{round($list2->percent_executing / 100,2)}} %</td>
            @endif
            
            <td class="tdAction" width="10%"></td>
        @endforeach
       
      </table>
  </div>