<script data-ad-client="ca-pub-9009102811248163" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>

	<table  align=center class='kalendar'>
	  <tr>
	    <td colspan=7><div align=center><span class="kalendar">{{$text_month}} {{$year}}</span></div></td>
	  </tr>
	  <tr>
	    <td width='14%'><div align=center><span class="kalendar">Pon</span></div></td>
	    <td width='14%'><div align=center><span class="kalendar">Wto</span></div></td>
	    <td width='14%'><div align=center><span class="kalendar">śro</span></div></td>
	    <td width='14%'><div align=center><span class="kalendar">Czwa</span></div></td>
	    <td width='14%'><div align=center><span class="kalendar">Pią</span></div></td>
	    <td width='14%'><div align=center><span class="kalendar">Sob</span></div></td>
	    <td width='14%'><div align=center><span class="kalendar">Nie</span></div></td>
	  </tr>
	  <tbody>


  @while ( $day2 <= $how_day_month) 

    <tr height=70>
    
    @for ($cols=0;$cols < 7;$cols++) 
    <td width="14%">
      @if ($day2 <= $how_day_month ) 

	
	
        @if ($day1 >= $day_week )

            @if ( $day2 == $day3 ) 
                <div  align=center id='day_{{$day2}}' class="cell_active"><span class="active">{{$day2}}</span></div>


            @else
     
                <div onmouseover='calendarOn("day_{{$day2}}")' onmouseout='calendarOff("day_{{$day2}}")' align=center id='day_{{$day2}}' class="cell{{$color[$day2-1]}}" onclick="LoadPage('{{route('main')}}/{{$year}}/{{$month}}/{{$day2}}')"><a  class="no_active" href={{   route('main')}}/{{$year}}/{{$month}}/{{$day2}}  }}>{{$day2}}</a></div>
                
            @endif
            </td>
            @php
                
                $day2++;
            @endphp
            
       
        
        
       
        @endif
	@php 
        $day1++;
	@endphp
	
      @endif
        
    @endfor
    </tr>

  @endwhile
  <tr>

</table>
<div class="row center">
  <div class="col-md-2 col-xs-2"></div>
  <div class="col-md-2 col-xs-2">
      <button class="btn btn-primary" onclick=location.href="{{ route('main')}}/{{$back[0]}}/{{$back[1]}}/1/wstecz">Miesiąc Wstecz</button>
  </div>
  <div class="col-md-2 col-xs-2">
          <button class="btn btn-primary" onclick=location.href="{{ route('main')}}/{{$back_year[0]}}/{{$back_year[1]}}/1/wstecz">Rok Wstecz</button>
  </div>
  <div class="col-md-2 col-xs-2">
      <button class="btn btn-primary" onclick=location.href="{{ route('main')}}/{{$next_year[0]}}/{{$next_year[1]}}/1/wstecz">Rok Dalej</button>
      
  </div>
  <div class="col-md-2 col-xs-2">
      <button class="btn btn-primary" onclick=location.href="{{ route('main')}}/{{$next[0]}}/{{$next[1]}}/1/wstecz">miesiąc Dalej</button>
      
      
  </div>
  
</div>
<div class="separateAction">
    Co ile minut rozdzielenie czasu w akcjach
    <div class="row">
        <div class="col-md-2 col-lg-2 col-xs-2 col-sm-2">
            
        </div>
        <div class="col-md-1 col-lg-1 col-xs-1 col-sm-1">
            <a href="{{ route('change.minutes',15)}}"><button class="btn btn-info">15 minut</button> </a>
        </div>
        <div class="col-md-1 col-lg-1 col-xs-1 col-sm-1">
              <a href="{{ route('change.minutes',30)}}"><button class="btn btn-info">30 minut</button> </a>
        </div>
        <div class="col-md-1 col-lg-1 col-xs-1 col-sm-1">
              <a href="{{ route('change.minutes',60)}}"><button class="btn btn-info">60 minut</button> </a>
        </div>
        <div class="col-md-1 col-lg-1 col-xs-1 col-sm-1">
              <a href="{{ route('change.minutes',120)}}"><button class="btn btn-info">2 godziny</button> </a>
        </div>
        <div class="col-md-1 col-lg-1 col-xs-1 col-sm-1">
               <a href="{{ route('change.minutes',240)}}"><button class="btn btn-info">4 godzin</button> </a>
        </div>
        <div class="col-md-1 col-lg-1 col-xs-1 col-sm-1">
               <a href="{{ route('change.minutes',360)}}"><button class="btn btn-info">6 godzin</button> </a>
        </div>
        <div class="col-md-1 col-lg-1 col-xs-1 col-sm-1">
              <a href="{{ route('change.minutes',720)}}"><button class="btn btn-info">12 godzin</button></a>
        </div>  
        <div class="col-md-1 col-lg-1 col-xs-1 col-sm-1">
             <a href="{{ route('change.minutes',1440)}}"> <button class="btn btn-info">24 godzin</button></a>
        </div> 
    </div>
</div>


    
