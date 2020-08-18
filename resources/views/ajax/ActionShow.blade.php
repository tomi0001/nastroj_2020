  <div class="ajaxlist">
      <table class="table">
          
          <tr>
              <td width="10%"></td>
              <td>
                  <div class="center silverActions">Nazwa</div>
              </td>
              <td><div class="center silverActions">Procent wykonania</div></td>
              <td width="10%"></td>
          </tr>
        @foreach ($list as $list2)
        <tr>
            <td width="10%"></td>
            <td><div class=' center namePleasure level_pleasure_{{App\Http\Services\Action::setColorPleasure($list2->level_pleasure)}}'><span class=" level_pleasure" >{{$list2->name}}</span></div></td>
            <td><div class="center colorLevel_percent colorLevel_percent_{{App\Http\Services\Action::setColorPercent($list2->percent_executing / 10,2)}}">{{round($list2->percent_executing / 10,2)}} %</td>
            <td width="10%"></td>
        @endforeach
      </table>
    </div>